<?php

namespace App\Livewire\Customer\Order\PendingOrder;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class PendingOrder extends Component
{
    use WithPagination;
    public $order_details = [
        'order_id'=> NULL,
        'customer_order'=> [],
        'order_items'=> [],
    ];
    public function render(Request $request){
        $data = $request->session()->all();
        $order_status = DB::table('order_status as os')
            ->where('name','=','Pending')
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
            ->where('order_by','=',$data['id'])
            ->where('status','=',$order_status->id)
            ->join('order_status as os','os.id','o.status')
            ->join('users as u','u.id','o.order_by')
            ->orderBy('o.date_updated','desc')
            ->paginate(10);
        return view('livewire.customer.order.pending-order.pending-order',[
            'customer_order'=>$customer_order
        ])
        ->layout('components.layouts.customer');
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
    public function save_cancel_order(Request $request,$id,$modal_id){
        $data = $request->session()->all();
        $order_status = DB::table('order_status')
            ->where('name','=','Cancelled')
            ->first();
        if(DB::table('orders')
            ->where('id','=',$id)
            ->update([
                'status'=>$order_status->id
            ])){
            $this->dispatch('closeModal',$modal_id);
            self::insert_notification(
                '
                <svg width="800px" height="800px" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <title>cancelled</title>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="add" fill="#000000" transform="translate(42.666667, 42.666667)">
                            <path d="M213.333333,1.42108547e-14 C331.15408,1.42108547e-14 426.666667,95.5125867 426.666667,213.333333 C426.666667,331.15408 331.15408,426.666667 213.333333,426.666667 C95.5125867,426.666667 4.26325641e-14,331.15408 4.26325641e-14,213.333333 C4.26325641e-14,95.5125867 95.5125867,1.42108547e-14 213.333333,1.42108547e-14 Z M42.6666667,213.333333 C42.6666667,307.589931 119.076736,384 213.333333,384 C252.77254,384 289.087204,370.622239 317.987133,348.156908 L78.5096363,108.679691 C56.044379,137.579595 42.6666667,173.894198 42.6666667,213.333333 Z M213.333333,42.6666667 C173.894198,42.6666667 137.579595,56.044379 108.679691,78.5096363 L348.156908,317.987133 C370.622239,289.087204 384,252.77254 384,213.333333 C384,119.076736 307.589931,42.6666667 213.333333,42.6666667 Z" id="Combined-Shape">

                </path>
                        </g>
                    </g>
                </svg>
                ',
                'Order cancelled',
                '/customer/orders/cancelled',
                $data['id'],
                $data['id'],
                0,
            );
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
