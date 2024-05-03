<?php

namespace App\Livewire\Admin\Orders\OrderList;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination; 

class OrderList extends Component
{
    use WithPagination;
    public $filters = [
        'status_id' => NULL,
    ];
    public function render()
    {
        $order_status = DB::table('order_status')
            ->get()
            ->toArray();
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
        ->where('o.status','like',$this->filters['status_id'].'%')
        ->join('order_status as os','os.id','o.status')
        ->join('users as u','u.id','o.order_by')
        ->orderBy('o.date_created','desc')
        ->paginate(10);
        return view('livewire.admin.orders.order-list.order-list',[
            'customer_order'=>$customer_order,
            'order_status'=>$order_status
        ])
        ->layout('components.layouts.admin');
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
