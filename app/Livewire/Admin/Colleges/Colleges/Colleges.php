<?php

namespace App\Livewire\Admin\Colleges\Colleges;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination; 

class Colleges extends Component
{
    use WithPagination;
    public $college = [
        'id' =>NULL,
        'name' =>NULL,
        'code' =>NULL,
        'error' => NULL,
    ];
    public function render()
    {
        $colleges_data = DB::table('colleges')
            ->orderby('date_created','desc')
            ->paginate(10);
        return view('livewire.admin.colleges.colleges.colleges',[
            'colleges_data'=>$colleges_data
        ])
        ->layout('components.layouts.admin');
    }
    public function edit($id,$modal_id){
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
        $this->dispatch('openModal',$modal_id);
    }
    public function add_college_default($modal_id){
        $this->college = [
            'id' =>NULL,
            'name' =>NULL,
            'code' =>NULL,
            'error' => NULL,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    public function save_add_college($modal_id){
        $this->college['error'] = NULL;
        if(strlen($this->college['code'])<=0){
            $this->college['error'] = "Please input college code";
            return;
        }
        if(strlen($this->college['name'])<=0){
            $this->college['error'] = "Please input college name";
            return;
        }
        if(DB::table('colleges as c')
            ->where('code','=',$this->college['code'])
            ->first()){
            $this->college['error'] = "College code exist";
            return;
        }
        if(DB::table('colleges as c')
            ->where('code','=',$this->college['code'])
            ->first()){
            $this->college['error'] = "College code exist";
            return;
        }
        if(DB::table('colleges as c')
            ->where('name','=',$this->college['name'])
            ->first()){
            $this->college['error'] = "College name exist";
            return;
        }
        if(DB::table('colleges')
            ->insert([
                'name' =>$this->college['name'],
                'code' =>$this->college['code'],
            ])){
            $this->dispatch('closeModal',$modal_id);
            $this->resetPage();
        }
    }
   
    public function save_edit_college($id,$modal_id){
        $this->college['error'] = NULL;
        if(strlen($this->college['code'])<=0){
            $this->college['error'] = "Please input college code";
            return;
        }
        if(strlen($this->college['name'])<=0){
            $this->college['error'] = "Please input college name";
            return;
        }
        if(DB::table('colleges as c')
            ->where('code','=',$this->college['code'])
            ->where('id','<>',$id)
            ->first()){
            $this->college['error'] = "College code exist";
            return;
        }
        if(DB::table('colleges as c')
            ->where('code','=',$this->college['code'])
            ->where('id','<>',$id)
            ->first()){
            $this->college['error'] = "College code exist";
            return;
        }
        if(DB::table('colleges as c')
            ->where('name','=',$this->college['name'])
            ->where('id','<>',$id)
            ->first()){
            $this->college['error'] = "College name exist";
            return;
        }
        if(DB::table('colleges')
            ->where('id','=',$id)
            ->update([
                'name' =>$this->college['name'],
                'code' =>$this->college['code'],
            ])){
            }
        $this->dispatch('closeModal',$modal_id);
        $this->resetPage();
    }
    public function save_activate_college($id,$modal_id){
        if(DB::table('colleges')
        ->where('id','=',$id)
        ->update([
            'is_active' => 1
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_deactivate_college($id,$modal_id){
        if(DB::table('colleges')
        ->where('id','=',$id)
        ->update([
            'is_active' => 0
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
}
