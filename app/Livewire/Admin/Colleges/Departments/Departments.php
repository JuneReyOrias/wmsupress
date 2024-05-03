<?php

namespace App\Livewire\Admin\Colleges\Departments;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination; 

class Departments extends Component
{
    public $department = [
        'id' =>NULL,
        'name' =>NULL,
        'code' =>NULL,
        'error' => NULL,
    ];
    public $college = [
        'id' =>NULL,
        'name' =>NULL,
        'code' =>NULL,
        'error' => NULL,
    ];
    use WithPagination;
    public $college_id;
    public function mount($id){
        if($id = intval($id)){
            $this->college_id = $id;
            if($college = DB::table('colleges')
                ->where('id','=',$id)
                ->first()){
                $this->college = [
                    'id' =>$college->id,
                    'name' =>$college->name,
                    'code' =>$college->code,
                    'error' => NULL,
                ];
            }
        }else{
            $this->college_id = NULL;
        }
    }
    public function render()
    {
        $colleges_data = DB::table('colleges')
            ->orderby('date_created','desc')
            ->get()
            ->toArray();
        if( $this->college_id){
            $departments_data = DB::table('departments')
                ->where('college_id','=',$this->college_id)
                ->orderby('date_created','desc')
                ->paginate(10);
            if($college = DB::table('colleges')
                ->where('id','=',$this->college_id)
                ->first()){
                $this->college = [
                    'id' =>$college->id,
                    'name' =>$college->name,
                    'code' =>$college->code,
                    'error' => NULL,
                ];
            }
        }else{
            $departments_data = DB::table('departments')
            ->orderby('date_created','desc')
            ->paginate(10);
        }
        return view('livewire.admin.colleges.departments.departments',[
            'colleges_data'=>$colleges_data,
            'departments_data'=>$departments_data
        ])
        ->layout('components.layouts.admin');
    }
    public function redirect_college_department(){
        return redirect('admin/colleges/'.$this->college_id);
    }
    public function add_department_default($modal_id){
        $this->department = [
            'id' =>NULL,
            'name' =>NULL,
            'code' =>NULL,
            'error' => NULL,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    public function edit($id,$modal_id){
        if($department = DB::table('departments')
            ->where('id','=',$id)
            ->first()){
            $this->department = [
                'id' =>$department->id,
                'name' =>$department->name,
                'code' =>$department->code,
                'error' => NULL,
            ];
            $this->college_id = $department->college_id;
            if($college = DB::table('colleges')
                ->where('id','=',$this->college_id )
                ->first()){
                $this->college = [
                    'id' =>$college->id,
                    'name' =>$college->name,
                    'code' =>$college->code,
                    'error' => NULL,
                ];
            }
        }
        $this->dispatch('openModal',$modal_id);
    }
    public function save_add_department($modal_id){
        $this->department['error'] = NULL;
        if(strlen($this->department['code'])<=0){
            $this->department['error'] = "Please input department code";
            return;
        }
        if(strlen($this->department['name'])<=0){
            $this->department['error'] = "Please input department name";
            return;
        }
        if(DB::table('departments as c')
            ->where('code','=',$this->department['code'])
            ->first()){
            $this->department['error'] = "College code exist";
            return;
        }
        if(DB::table('departments as c')
            ->where('code','=',$this->department['code'])
            ->first()){
            $this->department['error'] = "College code exist";
            return;
        }
        if(DB::table('departments as c')
            ->where('name','=',$this->department['name'])
            ->first()){
            $this->department['error'] = "College name exist";
            return;
        }
        if(!intval($this->college_id)){
            $this->department['error'] = "Select college";
            return;
        }
        if(DB::table('departments')
            ->insert([
                'name' =>$this->department['name'],
                'college_id' =>$this->college_id,
                'code' =>$this->department['code'],
            ])){
            $this->dispatch('closeModal',$modal_id);
            $this->resetPage();
        }
    }
   
    public function save_edit_department($id,$modal_id){
        $this->department['error'] = NULL;
        if(strlen($this->department['code'])<=0){
            $this->department['error'] = "Please input department code";
            return;
        }
        if(strlen($this->department['name'])<=0){
            $this->department['error'] = "Please input department name";
            return;
        }
        if(DB::table('departments as c')
            ->where('code','=',$this->department['code'])
            ->where('id','<>',$id)
            ->first()){
            $this->department['error'] = "College code exist";
            return;
        }
        if(DB::table('departments as c')
            ->where('code','=',$this->department['code'])
            ->where('id','<>',$id)
            ->first()){
            $this->department['error'] = "College code exist";
            return;
        }
        if(DB::table('departments as c')
            ->where('name','=',$this->department['name'])
            ->where('id','<>',$id)
            ->first()){
            $this->department['error'] = "College name exist";
            return;
        }
        if(!intval($this->college_id)){
            $this->department['error'] = "Select college";
            return;
        }
        if(DB::table('departments')
            ->where('id','=',$id)
            ->update([
                'name' =>$this->department['name'],
                'college_id' =>$this->college_id,
                'code' =>$this->department['code'],
            ])){
            }
        $this->dispatch('closeModal',$modal_id);
        $this->resetPage();
    }
    public function save_activate_department($id,$modal_id){
        if(DB::table('departments')
        ->where('id','=',$id)
        ->update([
            'is_active' => 1
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_deactivate_department($id,$modal_id){
        if(DB::table('departments')
        ->where('id','=',$id)
        ->update([
            'is_active' => 0
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
}

