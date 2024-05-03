<?php

namespace App\Livewire\Admin\Services\Pendingservices;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Pendingservices extends Component
{
    use WithPagination;
    public $user_id;
    public function mount(Request $request){
        $session = $request->session()->all();
        $this->user_id = $session['id'];
    }
    public $error;
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
        ->where('service_status_id','=',$service_status->id)
        ->orderBy('avs.date_created','desc')
        ->paginate(10);
        return view('livewire.admin.services.pendingservices.pendingservices',[
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
    public function save_approve_availed_service($id,$modal_id){
        $service_status = DB::table('service_status')
        ->where('name','=','Approved')
        ->first();
        $valid =true;
        foreach ($this->service_availed['availed_service_items'] as $key => $value) {
            if( !$value->is_active){
                $this->error = 'Item no.'.($key +1).' Service '.$value->service_name.' is not currently available, kindly decline the service!';
                $valid =false;
                return;
            }
        }
        if( $valid){
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
                        <svg fill="#000000" width="800px" height="800px" viewBox="0 0 32 32" enable-background="new 0 0 32 32" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Approved">
                            <g>
                            <path d="M16,1C7.729,1,1,7.729,1,16s6.729,15,15,15s15-6.729,15-15S24.271,1,16,1z M16,29C8.832,29,3,23.168,3,16S8.832,3,16,3    s13,5.832,13,13S23.168,29,16,29z"/>
                            <path d="M23.317,10.27l-10.004,9.36l-4.629-4.332c-0.403-0.377-1.035-0.356-1.413,0.047c-0.377,0.403-0.356,1.036,0.047,1.413    l5.313,4.971c0.192,0.18,0.438,0.27,0.683,0.27s0.491-0.09,0.683-0.27l10.688-10c0.403-0.377,0.424-1.01,0.047-1.413    C24.353,9.913,23.719,9.892,23.317,10.27z"/>
                            </g>
                            </g>
                            <g id="Approved_1_"/>
                            <g id="File_Approve"/>
                            <g id="Folder_Approved"/>
                            <g id="Security_Approved"/>
                            <g id="Certificate_Approved"/>
                            <g id="User_Approved"/>
                            <g id="ID_Card_Approved"/>
                            <g id="Android_Approved"/>
                            <g id="Privacy_Approved"/>
                            <g id="Approved_2_"/>
                            <g id="Message_Approved"/>
                            <g id="Upload_Approved"/>
                            <g id="Download_Approved"/>
                            <g id="Email_Approved"/>
                            <g id="Data_Approved"/>
                        </svg>
                        ',
                        'Services approved',
                        '/customer/services/approved',
                        $availed_services->user_id,
                        $this->user_id,
                        0,
                    );
                    $this->dispatch('closeModal',$modal_id);
                }
            }
        }
    }
    public function save_decline_availed_service($id,$modal_id){
        $service_status = DB::table('service_status')
        ->where('name','=','Declined')
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
                    'Services declined',
                    '/customer/services/declined',
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
