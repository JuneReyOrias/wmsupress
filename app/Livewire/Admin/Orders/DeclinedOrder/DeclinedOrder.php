<?php

namespace App\Livewire\Admin\Orders\DeclinedOrder;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination; 

class DeclinedOrder extends Component
{
    use WithPagination;
    public $order_details = [
        'order_id'=> NULL,
        'customer_order'=> [],
        'order_items'=> [],
    ];
    public $user_id;
    public function mount(Request $request){
        $session = $request->session()->all();
        $this->user_id = $session['id'];
    }
    public function render()
    {
        $order_status = DB::table('order_status')
            ->where('name','=','Declined')
            ->first();
        $customer_order = DB::table('orders as o')
            ->select(
                'o.id as id',
                'os.name as order_status',
                'o.total_price',
                'o.date_created as date_created',
                "u.first_name",
                "u.middle_name",
                "u.last_name",
                "u.email" ,
            )
            ->where('o.status','=',$order_status->id)
            ->join('order_status as os','os.id','o.status')
            ->join('users as u','u.id','o.order_by')
            ->orderBy('o.date_created','desc')
            ->paginate(10);
        return view('livewire.admin.orders.declined-order.declined-order',[
            'customer_order'=>$customer_order,
        ])
        ->layout('components.layouts.admin');
    }
    public function view_order($id,$modal_id){
         $customer_order = DB::table('orders as o')
            ->select(
                'o.id as id',
                'os.name as order_status',
                'o.total_price',
                'o.date_created as date_created',
                "u.first_name",
                "u.middle_name",
                "u.last_name",
                "u.email" ,
                "u.college_id",
                "c.name as college_name",
                "u.department_id",
                "d.name as department_name",
                "u.is_active",
                "o.image_proof",
                "o.date_created",
                "o.date_updated",
            )
            ->join('order_status as os','os.id','o.status')
            ->join('users as u','u.id','o.order_by')
            ->join('colleges as c','u.college_id','c.id')
            ->join('departments as d','u.department_id','d.id')
            ->where('o.id','=',$id)
            ->first();
        $order_items = DB::table('order_items as oi')
            ->select(
                'product_stock_id',
                DB::raw('SUM(oi.quantity) as quantity'),
                'ps.product_id' ,
                'p.image as product_image' ,
                'p.code as product_code' ,
                'p.price as product_price' ,
                'p.name as product_name' ,
                'ps.product_size_id' ,
                'psz.name as product_size' ,
                'ps.product_color_id' ,
                'pc.name as product_color' ,
                'ps.quantity as product_quantity' ,
                'ps.is_active',
                )
            ->join('product_stocks as ps','ps.id','oi.product_stock_id')
            ->join('products as p','p.id','ps.product_id')
            ->join('product_sizes as psz','psz.id','ps.product_size_id')
            ->join('product_colors as pc','pc.id','ps.product_color_id')
            ->where('order_id','=',$customer_order->id)
            ->groupby('product_stock_id')
            ->get()
            ->toArray();
        $this->order_details = [
            'order_id'=> $id,
            'image_proof'=>$customer_order->image_proof,
            'customer_order'=> $customer_order,
            'order_items'=> $order_items,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    public function save_pending_order($id,$modal_id){
        $order_status = DB::table('order_status')
            ->where('name','=','Pending')
            ->first();
        if(DB::table('orders')
            ->where('id','=',$id)
            ->update([
                'status'=>$order_status->id
            ])){
            
            $customer_order = DB::table('orders as o')
                ->select(
                    'o.id as id',
                    'os.name as order_status',
                    'o.total_price',
                    'o.date_created as date_created',
                    "u.id as user_id",
                    "u.first_name",
                    "u.middle_name",
                    "u.last_name",
                    "u.email" ,
                    "u.college_id",
                    "c.name as college_name",
                    "u.department_id",
                    "d.name as department_name",
                    "u.is_active",
                    "o.image_proof",
                    "o.date_created",
                    "o.date_updated",
                )
                ->join('order_status as os','os.id','o.status')
                ->join('users as u','u.id','o.order_by')
                ->join('colleges as c','u.college_id','c.id')
                ->join('departments as d','u.department_id','d.id')
                ->where('o.id','=',$id)
                ->first();
            self::insert_notification(
                '
                <svg width="800px" height="800px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M511.9 183c-181.8 0-329.1 147.4-329.1 329.1s147.4 329.1 329.1 329.1c181.8 0 329.1-147.4 329.1-329.1S693.6 183 511.9 183z m0 585.2c-141.2 0-256-114.8-256-256s114.8-256 256-256 256 114.8 256 256-114.9 256-256 256z" fill="#0F1F3C" /><path d="M548.6 365.7h-73.2v161.4l120.5 120.5 51.7-51.7-99-99z" fill="#0F1F3C" /></svg>
                ',
                'Order returned to pending',
                '/customer/orders/pending',
                $customer_order->user_id,
                $this->user_id,
                0,
            );
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function insert_notification(
        $notification_icon,
        $notification_content,
        $notification_link,
        $notification_target,
        $notification_creator,
        $notification_for_admin
    ){
        DB::table('notifications')
            ->insert([
                'notification_icon' =>$notification_icon,
                'notification_content' =>$notification_content,
                'notification_link' => $notification_link,
                'notification_target' => $notification_target,
                'notification_creator' => $notification_creator,
                'notification_for_admin' =>  $notification_for_admin
            ]);
    }
}
