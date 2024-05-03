<?php

namespace App\Livewire\Admin\Products\Color;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Color extends Component
{
    use WithPagination;
    public $product_color = [
        'id' =>NULL,
        'name' =>NULL,
        'description' =>NULL,
        'error' => NULL,
    ];

    public function render()
    {
        $colors_data = DB::table('product_colors')
            ->paginate(10);
        return view('livewire.admin.products.color.color',[
            'colors_data'=> $colors_data
        ])
        ->layout('components.layouts.admin');
    }
    public function add_color_default($modal_id){
        $this->product_color = [
            'id' =>NULL,
            'name' =>NULL,
            'description' =>NULL,
            'error' => NULL,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    public function save_add_color($modal_id){
        if(strlen($this->product_color['name']) <=0){
            $this->product_color['error'] = "Please input color name";
            return;
        }
        if(DB::table('product_colors')
            ->where('name','=',$this->product_color['name'])
            ->first()){
            $this->product_color['error'] = "Color Exist";
            return;
        }
        if(DB::table('product_colors')
            ->insert([
            'name' => $this->product_color['name'],
            'description' => $this->product_color['description'],
        ])){
            $this->dispatch('closeModal',$modal_id);
            $this->resetPage();
        }
    }
    public function edit($id,$modal_id){
        if($product_color = DB::table('product_colors')
            ->where('id','=',$id)
            ->first()){
            $this->product_color = [
                'id' => $product_color->id,
                'name' => $product_color->name,
                'description' => $product_color->description,
                'error' => NULL,
            ];
            $this->dispatch('openModal',$modal_id);
        }
    }
    public function save_edit_color($id,$modal_id){
        if(strlen($this->product_color['name']) <=0){
            $this->product_color['error'] = "Please input color name";
            return;
        }
        if(DB::table('product_colors')
            ->where('name','=',$this->product_color['name'])
            ->where('id','<>',$id)
            ->first()){
            $this->product_color['error'] = "Color Exist";
            return;
        }
        if(DB::table('product_colors')
            ->where('id','=',$id)
            ->update([
                'name' => $this->product_color['name'],
                'description' =>  $this->product_color['description'],
            ])
            ){
        }
        $this->dispatch('closeModal',$modal_id);
    }
    public function save_activate_color($id,$modal_id){
        if(DB::table('product_colors')
        ->where('id','=',$id)
        ->update([
            'is_active' => 1
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_deactivate_color($id,$modal_id){
        if(DB::table('product_colors')
        ->where('id','=',$id)
        ->update([
            'is_active' => 0
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    
}
