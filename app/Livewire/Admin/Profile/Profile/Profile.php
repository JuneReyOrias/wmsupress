<?php

namespace App\Livewire\Admin\Profile\Profile;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;
    public $profile_details = [
        'first_name'=> NULL,
        'middle_name'=> NULL,
        'last_name'=> NULL,
        'date_created'=> NULL,
        'image'=> NULL,
        'temp_image'=> NULL,
        'error'=> NULL,
    ];
    public function render(Request $request)
    {
        $session = $request->session()->all();

        $user_details = DB::table('users as u')
            ->select(
                'first_name',
                'middle_name',
                'last_name',
                'image',
                'date_created',
            )
            ->where('id','=',$session['id'])
            ->first();
        $this->profile_details['first_name'] = $user_details->first_name;
        $this->profile_details['middle_name'] = $user_details->middle_name;
        $this->profile_details['last_name'] = $user_details->last_name;
        $this->profile_details['image'] = $user_details->image;
        $this->profile_details['date_created'] = $user_details->date_created;
       
        return view('livewire.admin.profile.profile.profile')
        ->layout('components.layouts.admin');
    }
    public function save_profile(Request $request,$modal_id){
        $session = $request->session()->all();
        if(strlen($this->profile_details['first_name'])<=0){
            $this->profile_details['error'] = 'First name is required'; 
                return;
        }
        if(strlen($this->profile_details['last_name'])<=0){
            $this->profile_details['error'] = 'Last name is required'; 
                return;
        }
        if(DB::table('users')
            ->where('id','=',$session['id'])
            ->update([
                'first_name'=> $this->profile_details['first_name'],
                'middle_name'=> $this->profile_details['middle_name'],
                'last_name'=> $this->profile_details['last_name'],
            ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_profile_image(Request $request){
        $session = $request->session()->all();
        $profile_details['temp_image'] = NULL;
        if($this->profile_details['temp_image']){
            $profile_details['temp_image'] = self::save_image($this->profile_details['temp_image'],'profile','users','image');
            if($profile_details['temp_image'] == 0){
                return;
            }
        }
        if($profile_details['temp_image']){
            if(DB::table('users')
                ->where('id','=',$session['id'])
                ->update([
                    'image'=> $profile_details['temp_image'],
                ])){
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
}
