<?php

namespace App\Livewire\Customer\Services\ServicesPending;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class ServicesPending extends Component
{
    use WithPagination;
    public $user_id;
    public function mount(Request $request){
        $data = $request->session()->all();
        $this->user_id = $data['id'];
    }
    public $service_availed = [
        'image_proof'=>NULL,
        'availed_services'=>[],
        'availed_service_items'=> []
    ];
    public function render()
    {
        $service_status = DB::table('service_status')
            ->where('name','=','Pending')
            ->first();
        $availed_services = DB::table('availed_services as avs')
            ->select(
                'avs.id',
                "u.first_name",
                "u.middle_name",
                "u.last_name",
                "u.email" ,
                "ss.name as service_status"
            )
            ->join('service_status as ss','ss.id','avs.service_status_id')
            ->join('users as u','u.id','avs.customer_id')
            ->where('customer_id','=',$this->user_id)
            ->where('service_status_id','=',$service_status->id)
            ->orderBy('avs.date_updated','desc')
            ->paginate(10);
        return view('livewire.customer.services.services-pending.services-pending',[
            'availed_services'=>$availed_services
        ])
        ->layout('components.layouts.customer');
    }
    public function view_availed_service($id,$modal_id){
        $availed_services = DB::table('availed_services as avs')
        ->select(
            'avs.id',
            "u.first_name",
            "u.middle_name",
            "u.last_name",
            "u.email" ,
            "ss.name as service_status",
            "c.name as college_name",
            "u.department_id",
            "d.name as department_name",
            "u.is_active",
            "avs.image_proof",   
            "avs.date_created",
            "avs.date_updated",
        )
        ->join('service_status as ss','ss.id','avs.service_status_id')
        ->join('users as u','u.id','avs.customer_id')
        ->join('colleges as c','u.college_id','c.id')
        ->join('departments as d','u.department_id','d.id')
        ->where('customer_id','=',$this->user_id)
        ->where('avs.id','=',$id)
        ->first();
        if(  $availed_services ){
            $availed_service_items = DB::table('availed_service_items as asi')
                ->select(
                    's.id as service_id',
                    's.name as service_name',
                    's.is_active',
                    's.image as service_image',
                    's.description as service_description',
                    "asi.service_id",
                    "asi.quantity",
                    "asi.price_per_unit",
                    "asi.total_price",
                    "asi.remarks",
                )
            ->join('services as s','s.id','asi.service_id')
            ->where('customer_id','=',$this->user_id)
            ->where('avail_service_id','=',$availed_services->id)
            ->get()
            ->toArray();
            $this->service_availed = [
                'image_proof'=>$availed_services->image_proof,
                'availed_services'=>$availed_services,
                'availed_service_items'=> $availed_service_items
            ];
        }
        $this->dispatch('openModal',$modal_id);
    }
    public function save_cancel_availed_service($id,$modal_id){
        $service_status = DB::table('service_status')
        ->where('name','=','Cancelled')
        ->first();
        if($service_status){
            if(DB::table('availed_services')
                ->where('id','=',$id)
                ->update([
                    'service_status_id'=>$service_status->id
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
                    'Availed service cancelled',
                    '/customer/services/cancelled',
                    $this->user_id,
                    $this->user_id,
                    0,
                );
                
                
            }
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
