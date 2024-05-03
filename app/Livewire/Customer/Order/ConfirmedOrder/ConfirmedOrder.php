<?php

namespace App\Livewire\Customer\Order\ConfirmedOrder;

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
    public function render(Request $request){
        $data = $request->session()->all();
        $order_status = DB::table('order_status as os')
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
            ->where('order_by','=',$data['id'])
            ->where('status','=',$order_status->id)
            ->join('order_status as os','os.id','o.status')
            ->join('users as u','u.id','o.order_by')
            ->orderBy('o.date_updated','desc')
            ->paginate(10);
        return view('livewire.customer.order.confirmed-order.confirmed-order',[
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
}
