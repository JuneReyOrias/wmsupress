<?php

namespace App\Livewire\Admin\Products\Sizes;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Sizes extends Component
{
    use WithPagination;
    public $product_size = [
        'id' =>NULL,
        'name' =>NULL,
        'description' =>NULL,
        'error' => NULL,
    ];
    public function render()
    {
        $sizes_data = DB::table('product_sizes')
        ->paginate(10);
        return view('livewire.admin.products.sizes.sizes',[
            'sizes_data'=> $sizes_data
        ])
        ->layout('components.layouts.admin');
    }
    public function add_size_default($modal_id){
        $this->product_size = [
            'id' =>NULL,
            'name' =>NULL,
            'description' =>NULL,
            'error' => NULL,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    public function save_add_size($modal_id){
        if(strlen($this->product_size['name']) <=0){
            $this->product_size['error'] = "Please input size name";
            return;
        }
        if(strlen($this->product_size['description']) <=0){
            $this->product_size['error'] = "Please input description";
            return;
        }
        if(DB::table('product_sizes')
            ->where('name','=',$this->product_size['name'])
            ->first()){
            $this->product_size['error'] = "size Exist";
            return;
        }
        if(DB::table('product_sizes')
            ->insert([
            'name' => $this->product_size['name'],
            'description' => $this->product_size['description'],
        ])){
            $this->dispatch('closeModal',$modal_id);
            $this->resetPage();
        }
    }
    public function edit($id,$modal_id){
        if($product_size = DB::table('product_sizes')
            ->where('id','=',$id)
            ->first()){
            $this->product_size = [
                'id' => $product_size->id,
                'name' => $product_size->name,
                'description' => $product_size->description,
                'error' => NULL,
            ];
            $this->dispatch('openModal',$modal_id);
        }
    }
    public function save_edit_size($id,$modal_id){
        if(strlen($this->product_size['name']) <=0){
            $this->product_size['error'] = "Please input size name";
            return;
        }
        if(strlen($this->product_size['description']) <=0){
            $this->product_size['error'] = "Please input description";
            return;
        }
        if(DB::table('product_sizes')
            ->where('name','=',$this->product_size['name'])
            ->where('id','<>',$id)
            ->first()){
            $this->product_size['error'] = "size Exist";
            return;
        }
        if(DB::table('product_sizes')
            ->where('id','=',$id)
            ->update([
                'name' => $this->product_size['name'],
                'description' =>  $this->product_size['description'],
            ])
            ){
        }
        $this->dispatch('closeModal',$modal_id);
    }
    public function save_activate_size($id,$modal_id){
        if(DB::table('product_sizes')
        ->where('id','=',$id)
        ->update([
            'is_active' => 1
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_deactivate_size($id,$modal_id){
        if(DB::table('product_sizes')
        ->where('id','=',$id)
        ->update([
            'is_active' => 0
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    
}
