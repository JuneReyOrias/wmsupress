<?php

namespace App\Livewire\Components\CustomerHeader;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class CustomerHeader extends Component
{
    use WithPagination;
    public function render(Request $request)
    {
        $session = $request->session()->all();
        $header_info = [
            'cart_items' => 0,
            'notification_items'=> 0,
            'pending_order' => 0,
            'service_items' => 0,
            'pending_service' => 0,
            'notifications_count' => 0,
            'notifications_list'=> [],
        ];
        if(isset($session['id'])){
            $user_info  = DB::table('users as u')
                ->select(
                    "u.id",
                    "u.first_name",
                    "u.middle_name",
                    "u.last_name",
                    "u.email" ,
                    "u.image",
                )
                ->where('id','=',$session['id'])
                ->first();
        }
        $cart_items = DB::table('customer_cart as cc')
            ->select(DB::raw('SUM(quantity) as quantity'))
            ->where('cc.customer_id','=',$session['id'])
            ->first();
        if($cart_items->quantity){
            $header_info['cart_items'] = $cart_items->quantity;
        }

        $order_status = DB::table('order_status as os')
        ->where('name','=','Pending')
        ->first();

        $pending_orders = DB::table('orders as o')
        ->select(
            DB::raw('count(*) as pending_order_count')
        )
        ->where('order_by','=',$session['id'])
        ->where('status','=',$order_status->id)
        ->first();
        $service_items = DB::table('services_cart')
            ->select(DB::raw('count(* ) as quantity'))
            ->where('customer_id','=',$session['id'])
            ->first();
        if($service_items->quantity){
            $header_info['service_items'] = $service_items->quantity;
        }
        $service_status = DB::table('service_status as ss')
        ->where('name','=','Pending')
        ->first();
        $pending_service = DB::table('availed_services')
            ->select(DB::raw('count(* ) as quantity'))
            ->where('service_status_id','=',$service_status->id)
            ->where('customer_id','=',$session['id'])
            ->first();
        if($pending_service->quantity){
            $header_info['pending_service'] = $pending_service->quantity;
        }
        if($pending_orders->pending_order_count){
            $header_info['pending_order'] = $pending_orders->pending_order_count;
        }
        
        $notifications_count = DB::table('notifications')
            ->select(
                DB::raw('count(*) as notifications_count')
            )
            ->where('is_read','=',0)
            ->where('notification_target','=',$session['id'])
            ->orderBy('date_created','desc')
            ->first();
        if($notifications_count->notifications_count){
            $header_info['notifications_count'] = $notifications_count->notifications_count;
        }
        $notifications_list = DB::table('notifications')
            ->where('notification_target','=',$session['id'])
            ->orderBy('date_created','desc')
            ->limit(10)
            ->get()
            ->toArray();
        if($notifications_list){
            $header_info['notifications_list'] = $notifications_list;
        }
        return view('livewire.components.customer-header.customer-header',[
            'user_info'=>$user_info,
            'header_info'=>$header_info
        ]);
    }
    function timeAgo($time_ago){
        date_default_timezone_set('Asia/Hong_Kong');
        $time_ago = strtotime($time_ago);
        $cur_time   = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = abs($time_elapsed) ;
        $minutes    = intval($time_elapsed / 60 );
        $hours      = intval($time_elapsed / 3600);
        $days       = intval($time_elapsed / 86400 );
        $weeks      = intval($time_elapsed / 604800);
        $months     = intval($time_elapsed / 2600640 );
        $years      = intval($time_elapsed / 31207680 );
        if($years>0){
            if($years==1){
                return "one year ago";
            }else{
                return "$years years ago";
            }
        }else if($months > 0){
            if($months==1){
                return "a month ago";
            }else{
                return "$months months ago";
            }
        }
        else if($weeks > 0){
            if($weeks==1){
                return "a week ago";
            }else{
                return "$weeks weeks ago";
            }
        }
        else if($days > 0){
            if($days==1){
                return "yesterday";
            }else{
                return "$days days ago";
            }
        }
        else if($hours > 0){
            if($hours==1){
                return "an hour ago";
            }else{
                return "$hours hrs ago";
            }
        }
        else if($minutes > 0){
            if($minutes==1){
                return "one minute ago";
            }
            else{
                return "$minutes minutes ago";
            }
        }else{
            return "Just now";
        }
    }
    public function update_header_info(Request $request){
        $session = $request->session()->all();
        $cart_items = DB::table('customer_cart as cc')
            ->select(DB::raw('SUM(quantity) as quantity'))
            ->where('cc.customer_id','=',$session['id'])
            ->first();
        if($cart_items->quantity){
            $header_info['cart_items'] = $cart_items->quantity;
        }

        $order_status = DB::table('order_status as os')
            ->where('name','=','Pending')
            ->first();

        $pending_orders = DB::table('orders as o')
            ->select(
                DB::raw('count(*) as pending_order_count')
            )
            ->where('order_by','=',$session['id'])
            ->where('status','=',$order_status->id)
            ->first();
        $service_items = DB::table('services_cart')
            ->select(DB::raw('count(* ) as quantity'))
            ->where('customer_id','=',$session['id'])
            ->first();
        if($service_items->quantity){
            $header_info['service_items'] = $service_items->quantity;
        }

        if($pending_orders->pending_order_count){
            $header_info['pending_order'] = $pending_orders->pending_order_count;
        }
    }
    public function update_notifications(){

    }
    public function clear_notification(Request $request){
        $session = $request->session()->all();
        DB::table('notifications')
            ->where('notification_target','=',$session['id'])
            ->update([
                'is_read'=>1
            ]);
    }
}
