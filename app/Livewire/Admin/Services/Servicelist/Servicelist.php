<?php

namespace App\Livewire\Admin\Services\Servicelist;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Servicelist extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $service = [
        'id' => NULL,
        'name' => NULL,
        'description' => NULL,
        'image' => NULL,
        'error' => NULL,
    ];
    public $user_id;
    public function mount(Request $request){
        $session = $request->session()->all();
        $this->user_id = $session['id'];
    }
    public function render()
    {
        $service_data = DB::table('services')
            ->paginate(10);
        return view('livewire.admin.services.servicelist.servicelist',[
            'service_data'=>$service_data

        ])
        ->layout('components.layouts.admin');
    }
    public function add_service_default($modal_id){
        $this->service = [
            'id' => NULL,
            'name' => NULL,
            'description' => NULL,
            'image' => NULL,
            'error' => NULL,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    public function save_add_service($modal_id){
        if(strlen($this->service['name'])<=0){
            $this->service['error'] = "Please input name";
            return;
        }
        if(DB::table('services')
            ->where('name','=',$this->service['name'])
            ->first()){
            $this->service['error'] = "Service Exist";
            return;
        }
        $service['image'] = NULL;
        if($this->service['image']){
            $service['image'] = self::save_image($this->service['image'],'services','services','image');
            if($service['image'] == 0){
                return;
            }
        }
        if($service['image']){
            if(DB::table('services')
                ->insert([
                    'name' => $this->service['name'],
                    'description' => $this->service['description'],
                    'image' => $service['image'],
                ])){
                $this->dispatch('closeModal',$modal_id);
                $this->resetPage();
            }
        }
    }
    public function save_image($image_file,$folder_name,$table_name,$column_name){
        if($image_file && file_exists(storage_path().'/app/livewire-tmp/'.$image_file->getfilename())){
            $file_extension =$image_file->getClientOriginalExtension();
            $tmp_name = 'livewire-tmp/'.$image_file->getfilename();
            $size = Storage::size($tmp_name);
            $mime = Storage::mimeType($tmp_name);
            $max_image_size = 20 * 1024*1024; // 5 mb
            $file_extensions = array('image/jpeg','image/png','image/jpg');
            
            if($size<= $max_image_size){
                $valid_extension = false;
                foreach ($file_extensions as $value) {
                    if($value == $mime){
                        $valid_extension = true;
                        break;
                    }
                }
                if($valid_extension){
                    // move
                    $new_file_name = md5($tmp_name).'.'.$file_extension;
                    while(DB::table($table_name)
                    ->where([$column_name=> $new_file_name])
                    ->first()){
                        $new_file_name = md5($tmp_name.rand(1,10000000)).'.'.$file_extension;
                    }
                    if(Storage::move($tmp_name, 'public/content/'.$folder_name.'/'.$new_file_name)){
                        return $new_file_name;
                    }
                }else{
                    $this->dispatch('swal:redirect',
                        position         									: 'center',
                        icon              									: 'warning',
                        title             									: 'Invalid image type!',
                        showConfirmButton 									: 'true',
                        timer             									: '1000',
                        link              									: '#'
                    );
                    return 0;
                }
            }else{
                $this->dispatch('swal:redirect',
                    position         									: 'center',
                    icon              									: 'warning',
                    title             									: 'Image is too large!',
                    showConfirmButton 									: 'true',
                    timer             									: '1000',
                    link              									: '#'
                );
                return 0;
            } 
        }
        return 0;
    }
    public function edit_service($id,$modal_id){
        if($service = DB::table('services')
            ->where('id','=',$id)
            ->first() ){
            $this->service = [
                'id' => $service->id,
                'name' => $service->name,
                'description' => $service->description,
                'image' => NULL,
                'error' => NULL,
            ];
            $this->dispatch('openModal',$modal_id);
        }
    }
    public function save_edit_service($id,$modal_id){
        if(strlen($this->service['name'])<=0){
            $this->service['error'] = "Please input name";
            return;
        }
        if(DB::table('services')
        ->where('name','=',$this->service['name'])
        ->where('id','<>',$id)
        ->first()){
        $this->service['error'] = "Service Exist";
        return;
    }
        $service['image'] = NULL;
        if($this->service['image']){
            $service['image'] = self::save_image($this->service['image'],'services','services','image');
            if($service['image'] == 0){
                return;
            }
        }
        if($service['image']){
            if(DB::table('services')
                ->where('id','=',$id)
                ->update([
                    'name' => $this->service['name'],
                    'description' => $this->service['description'],
                    'image' => $service['image'],
                ])){
                
            }
        }else{
            if(DB::table('services')
                ->where('id','=',$id)
                ->update([
                    'name' => $this->service['name'],
                    'description' => $this->service['description'],
                ])){
            }
        }
        $this->dispatch('closeModal',$modal_id);
    }
    public function save_activate_service($id,$modal_id){
        if(DB::table('services')
        ->where('id','=',$id)
        ->update([
            'is_active' => 1
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_deactivate_service($id,$modal_id){
        if(DB::table('services')
        ->where('id','=',$id)
        ->update([
            'is_active' => 0
        ])){
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
