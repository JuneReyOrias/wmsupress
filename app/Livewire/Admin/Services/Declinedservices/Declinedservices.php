<?php

namespace App\Livewire\Admin\Services\Declinedservices;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Declinedservices extends Component
{
    use WithPagination;
    public $user_id;
    public function mount(Request $request){
        $session = $request->session()->all();
        $this->user_id = $session['id'];
    }
    public $service_availed = [
        'image_proof'=>NULL,
        'availed_services'=>[],
        'availed_service_items'=> []
    ];
    public function render()
    {
        $service_status = DB::table('service_status')
            ->where('name','=','Declined')
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
            ->where('service_status_id','=',$service_status->id)
            ->orderBy('avs.date_created','desc')
            ->paginate(10);
        return view('livewire.admin.services.declinedservices.declinedservices',[
            'availed_services'=>$availed_services
        ])
        ->layout('components.layouts.admin');
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
            ->where('avail_service_id','=',$availed_services->id)
            ->get()
            ->toArray();
            $this->service_availed = [
                'availed_services'=>$availed_services,
                'availed_service_items'=> $availed_service_items
            ];
        }
        $this->dispatch('openModal',$modal_id);
    }
    public function save_pending_availed_service($id,$modal_id){
        $service_status = DB::table('service_status')
        ->where('name','=','Pending')
        ->first();
        if($service_status){
            if(DB::table('availed_services')
                ->where('id','=',$id)
                ->update([
                    'service_status_id'=>$service_status->id
                ])){
                $availed_services = DB::table('availed_services as avs')
                    ->select(
                        'avs.id',
                        'u.id as user_id',
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
                    ->where('avs.id','=',$id)
                    ->first();
                self::insert_notification(
                        '
                        <svg width="800px" height="800px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M511.9 183c-181.8 0-329.1 147.4-329.1 329.1s147.4 329.1 329.1 329.1c181.8 0 329.1-147.4 329.1-329.1S693.6 183 511.9 183z m0 585.2c-141.2 0-256-114.8-256-256s114.8-256 256-256 256 114.8 256 256-114.9 256-256 256z" fill="#0F1F3C" /><path d="M548.6 365.7h-73.2v161.4l120.5 120.5 51.7-51.7-99-99z" fill="#0F1F3C" /></svg>
                        ',
                        'Services returned to pending',
                        '/customer/services/pending',
                        $availed_services->user_id,
                        $this->user_id,
                        0,
                    );
                $this->dispatch('closeModal',$modal_id);
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

