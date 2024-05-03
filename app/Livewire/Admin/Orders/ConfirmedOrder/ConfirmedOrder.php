<?php

namespace App\Livewire\Admin\Orders\ConfirmedOrder;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination; 

class ConfirmedOrder extends Component
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
            ->where('name','=','Confirmed')
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
        return view('livewire.admin.orders.confirmed-order.confirmed-order',[
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
    public function save_pending_order(Request $request,$id,$modal_id){
        $order_status = DB::table('order_status')
            ->where('name','=','Pending')
            ->first();
        //stock in
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
        ->where('order_id','=',$id)
        ->groupby('product_stock_id')
        ->get()
        ->toArray();
    
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
            foreach($order_items as $key => $value){
                $current_stock = DB::table('product_stocks as ps')
                ->where('ps.id','=',$value->product_stock_id)
                ->first();
                if($current_stock ){
                    DB::table('product_stocks as ps')
                    ->where('ps.id','=',$value->product_stock_id)
                    ->update([
                        'quantity'=>$current_stock->quantity + $value->quantity
                    ]);
                }
                DB::table('stockin_stockout_records')
                ->insert([
                    'product_stock_id' => $value->product_stock_id,
                    'stock_type_id' => 1,
                    'stock_by' => $this->user_id,
                    'quantity' => $value->quantity,
                ]);
            }
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_rfpu_order($id,$modal_id){
        $order_status = DB::table('order_status')
            ->where('name','=','Ready for Pickup')
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
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 389.374 389.374"xml:space="preserve">
                    <g>
                        <g>
                            <rect x="188.712" y="73.19" style="fill:#030303;" width="11.71" height="134.671"/>
                            <polygon style="fill:#030303;" points="200.422,11.711 234.09,11.711 234.09,0 153.58,0 153.58,11.711 188.712,11.711 
                                188.712,26.349 194.566,26.349 200.422,26.349 		"/>
                            <path style="fill:#030303;" d="M344.241,81.985l23.799,23.807l8.279-8.28l-56.929-56.928l-8.279,8.276l24.839,24.845l-9.571,9.569
                                c-33.107-35.009-79.938-56.926-131.812-56.926c-100.082,0-181.512,81.431-181.512,181.513
                                c0,100.088,81.43,181.513,181.512,181.513c100.089,0,181.513-81.425,181.513-181.513c0-43.997-15.747-84.381-41.878-115.835
                                L344.241,81.985z M194.566,377.663c-93.632,0-169.802-76.175-169.802-169.802c0-93.632,76.17-169.802,169.802-169.802
                                c93.627,0,169.803,76.169,169.803,169.802C364.369,301.488,288.193,377.663,194.566,377.663z"/>
                        </g>
                    </g>
                </svg>
                ',
                'Order is ready to pick up',
                '/customer/orders/ready-for-pickup',
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
