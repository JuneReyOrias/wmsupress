<?php

namespace App\Livewire\Admin\Users\Staff;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Staff extends Component
{
    use WithPagination;
    public $user = [
        'id' => NULL,
        'first_name' => NULL,
        'middle_name' => NULL,
        'last_name' => NULL,
        'email' => NULL,
        'contact_no' => NULL,
        'role_id' => NULL,
        'college_id' => NULL,
        'department_id' => NULL,
        'password' => NULL,
        'confirm_password' => NULL,
        'error' => NULL,
    ];
    public function render()
    {
        $roles = DB::table('roles')
            ->where('name','=','admin-staff')
            ->first();

        if(intval($this->user['college_id'])){
            $departments =  DB::table('departments')
            ->where('college_id','=',$this->user['college_id'])
            ->get()
            ->toArray();
        }else{
            $departments = DB::table('departments')
                ->get()
                ->toArray();
        }
        $colleges = DB::table('colleges')
            ->get()
            ->toArray();
        $admin_roles =  DB::table('roles')
            ->where('name','=','admin-staff')
            ->get()
            ->toArray();
        $users_data = [];
        if($roles){
            $this->user['role_id'] = $roles->id;
            $users_data = DB::table('users as u')
                ->select(
                    "u.id",
                    "u.first_name",
                    "u.middle_name",
                    "u.last_name",
                    "u.email" ,
                    "u.image",
                    "u.contact_no",
                    "u.role_id",
                    "u.college_id",
                    "c.name as college_name",
                    "u.department_id",
                    "d.name as department_name",
                    "u.is_active",
                    "u.date_created",
                    "u.date_updated",
                )
                ->join('colleges as c','u.college_id','c.id')
                ->join('departments as d','u.department_id','d.id')
                ->where('role_id','=',$roles->id)
                ->paginate(10);
        }
        return view('livewire.admin.users.staff.staff',[
            'users_data' =>$users_data,
            'departments' =>$departments,
            'colleges' =>$colleges,
            'admin_roles' =>$admin_roles,
            'roles' =>$roles,
            ])
        ->layout('components.layouts.admin');
    }
    public function add_user_default($modal_id){
        $this->dispatch('openModal',$modal_id);
    }
    public function add_user($modal_id){
        if(strlen($this->user['first_name'])<= 0){
            $this->user['error'] = "Please Input firstname";
            return;
        }
        if(strlen($this->user['last_name'])<= 0){
            $this->user['error'] = "Please Input lastname";
            return;
        }
        if(isset($this->user['contact_no']) && strlen($this->user['contact_no']) >0 && $this->user['contact_no'][0] !=0 ){
            $this->user['error'] = "Contact number must start with 0";
            return;
        }
        if(isset($this->user['contact_no']) && strlen($this->user['contact_no']) != 11){
            $this->user['error'] = "Contact number must be 11 digits";
            return;
        }
        if(strlen($this->user['email'])<= 0){
            $this->user['error'] = "Please Input email";
            return;
        }else{
            if(!filter_var($this->user['email'], FILTER_VALIDATE_EMAIL)){
                $this->user['error'] = "Please Input valid email";
                return;
            }else{
                if(DB::table('users')
                    ->where('email','=',$this->user['email'])
                    ->first()){
                    $this->user['error'] = "Email Exist";
                    return;
                }
            }
        }
        if(strlen($this->user['password'])< 8){
            $this->user['error'] = "Password must be at least 8";
            return;
        }
        if(strlen($this->user['confirm_password'])< 8){
            $this->user['error'] = "Password must be at least 8";
            return;
        }
        if($this->user['confirm_password'] != $this->user['password']){
            $this->user['error'] = "Password doesn't match";
            return;
        }
  
        if(!DB::table('colleges')    
            ->where('id','=',$this->user['college_id'])
            ->first()){
            $this->user['error'] = "Please select college";
            return;
        }
        if(!DB::table('departments')    
            ->where('id','=',$this->user['department_id'])
            ->first()){
            $this->user['error'] = "Please select department";
            return;
        }
        if(DB::table('users')
            ->insert([
                'first_name' => $this->user['first_name'],
                'middle_name' => $this->user['middle_name'],
                'last_name' => $this->user['last_name'],
                'email' => $this->user['email'],
                'contact_no' => $this->user['contact_no'],
                'role_id' => $this->user['role_id'],
                'college_id' => $this->user['college_id'],
                'department_id' => $this->user['department_id'],
                'password' => bcrypt($this->user['password']),
        ])){
            $this->dispatch('closeModal',$modal_id);
            $this->resetPage();
        }
    }
    public function deactivate_user($modal_id){
        $this->dispatch('openModal',$modal_id);

    }
    public function activate_user($modal_id){
        $this->dispatch('openModal',$modal_id);
    }
    public function edit_user($id,$modal_id){
        $roles = DB::table('roles')
        ->where('name','=','admin-staff')
        ->first();

        if($user = DB::table('users as u')
        ->where('u.id','=',$id)
        ->where('u.role_id','=',$roles->id)
        ->get()
        ->first()){
            $this->user = [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'contact_no' => $user->contact_no,
                'role_id' => $user->role_id,
                'college_id' => $user->college_id,
                'department_id' => $user->department_id,
                'confirm_password' => $user->id,
                'error' => NULL,
            ];
        }
        $this->dispatch('openModal',$modal_id);

    }
    public function save_deactivate_user($id,$modal_id){
        $roles = DB::table('roles')
        ->where('name','=','admin-staff')
        ->first();
        if(DB::table('users as u')
        ->where('u.id','=',$id)
        ->where('u.role_id','=',$roles->id)
        ->update([
            'is_active' => 0
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_activate_user($id,$modal_id){
        $roles = DB::table('roles')
        ->where('name','=','admin-staff')
        ->first();
        if(DB::table('users as u')
        ->where('u.id','=',$id)
        ->where('u.role_id','=',$roles->id)
        ->update([
            'is_active' => 1
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_edit_user($id,$modal_id){
        $roles = DB::table('roles')
        ->where('name','=','admin-staff')
        ->first();
        if(strlen($this->user['first_name'])<= 0){
            $this->user['error'] = "Please Input firstname";
            return;
        }
        if(strlen($this->user['last_name'])<= 0){
            $this->user['error'] = "Please Input lastname";
            return;
        }
        
  
        if(!DB::table('colleges')    
            ->where('id','=',$this->user['college_id'])
            ->first()){
            $this->user['error'] = "Please select college";
            return;
        }
        if(!DB::table('departments as d')    
            ->where('d.id','=',$this->user['department_id'])
            ->where('d.college_id','=',$this->user['college_id'])
            ->first()){
            $this->user['error'] = "Invalid department";
            return;
        }
        if(DB::table('users as u')
            ->where('u.id','=',$id)
            ->where('u.role_id','=',$roles->id)
            ->update([
                'first_name' => $this->user['first_name'],
                'middle_name' => $this->user['middle_name'],
                'last_name' => $this->user['last_name'],
                'contact_no' => $this->user['contact_no'],
                'college_id' => $this->user['college_id'],
                'department_id' => $this->user['department_id'],
        ])){
            $this->dispatch('closeModal',$modal_id);
            $this->resetPage();
        }
    }
}
