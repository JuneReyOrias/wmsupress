<?php

namespace App\Livewire\Components\AdminHeader;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class AdminHeader extends Component
{
    public function render(Request $request)
    {
        $session = $request->session()->all();
        $header_info = [
            'notification_items'=> 0,
            'notifications_count' => 0,
            'notifications_list'=> [],
        ];
        $notifications_count = DB::table('notifications')
            ->select(
                DB::raw('count(*) as notifications_count')
            )
            ->where('is_read','=',0)
            ->where('notification_for_admin','=',1)
            ->orderBy('date_created','desc')
            ->first();
        if($notifications_count->notifications_count){
            $header_info['notifications_count'] = $notifications_count->notifications_count;
        }
        $notifications_list = DB::table('notifications')
            ->where('notification_for_admin','=',1)
            ->orderBy('date_created','desc')
            ->limit(10)
            ->get()
            ->toArray();
        if($notifications_list){
            $header_info['notifications_list'] = $notifications_list;
        }
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
        return view('livewire.components.admin-header.admin-header',[
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
    public function update_is_read($id,$is_read){
        DB::table('notifications')
        ->where('id','=',$id)
        ->update([
            'is_read'=>$is_read
        ]);
    }
}
