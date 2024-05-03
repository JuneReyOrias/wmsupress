<?php

namespace App\Livewire\Admin\Products\Productlist;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Productlist extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $product =[
        'id' => NULL,
        'code' => NULL,
        'name' => NULL,
        'description' => NULL,
        'image' => NULL,
        'price' => NULL,
        'error' => NULL,
    ];
    public function render()
    {
        $products_data = DB::table('products')
            ->paginate(10);
        return view('livewire.admin.products.productlist.productlist',[
            'products_data'=>$products_data  
        ])
        ->layout('components.layouts.admin');
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
    public function add_product_default($modal_id){
        $this->product =[
            'id' => NULL,
            'code' => NULL,
            'name' => NULL,
            'description' => NULL,
            'image' => NULL,
            'price' => NULL,
            'error' => NULL,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    public function save_add_product($modal_id){
        
        if(strlen($this->product['code'])<=0){
            $this->product['error'] = "Please input code";
            return;
        }
        if(DB::table('products')
            ->where('code','=',$this->product['code'])
            ->first()){
            $this->product['error'] = "Product code exist";
            return;
        }
        if(strlen($this->product['name'])<=0){
            $this->product['error'] = "Please input name";
            return;
        }
        if(strlen($this->product['price'])<=0){
            $this->product['error'] = "Please input valid price";
            return;
        }
        if(DB::table('products')
            ->where('name','=',$this->product['name'])
            ->first()){
            $this->product['error'] = "Product name exist";
            return;
        }
        $product['image'] = NULL;
        if($this->product['image']){
            $product['image'] = self::save_image($this->product['image'],'products','products','image');
            if($product['image'] == 0){
                return;
            }
        }
        if(DB::table('products')
            ->insert([
                'code' => $this->product['code'],
                'name' => $this->product['name'],
                'description' =>  $this->product['description'] ,
                'price' => $this->product['price'],
                'image' =>  $product['image'],
                ])){
            $this->dispatch('closeModal',$modal_id);
            $this->resetPage();
        }
    }
    public function edit($id,$modal_id){
        if($product = DB::table('products')
            ->where('id','=',$id)
            ->first()){
                $this->product =[
                    'id' => $product->id,
                    'code' => $product->code,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'image' => NULL,
                    'error' => NULL,
                ];
            $this->dispatch('openModal',$modal_id);
        }
    }
    public function save_edit_product($id,$modal_id){
        if(strlen($this->product['code'])<=0){
            $this->product['error'] = "Please input code";
            return;
        }
        if(DB::table('products')
            ->where('code','=',$this->product['code'])
            ->where('id','<>',$this->product['id'])
            ->first()){
            $this->product['error'] = "Product code exist";
            return;
        }
        if(strlen($this->product['name'])<=0){
            $this->product['error'] = "Please input name";
            return;
        }
        if(DB::table('products')
            ->where('name','=',$this->product['name'])
            ->where('id','<>',$this->product['id'])
            ->first()){
            $this->product['error'] = "Product name exist";
            return;
        }
        $product['image'] = NULL;
        if($this->product['image']){
            $product['image'] = self::save_image($this->product['image'],'products','products','image');
            if($product['image'] == 0){
                return;
            }
        } 
        if( $product['image'] ){
            $temp_product = DB::table('products')
            ->where('id','=',$id)
            ->first();
            if(DB::table('products')
            ->where('id','=',$id)
            ->update([
                'image' =>  $product['image'],
                ])){
                if(file_exists(public_path('storage').'/content/products/'.$temp_product->image)){
                    unlink(public_path('storage').'/content/products/'.$temp_product->image);
                }
            }
        }
       
        
        if(DB::table('products')
        ->where('id','=',$id)
        ->update([
            'code' => $this->product['code'],
            'name' => $this->product['name'],
            'description' =>  $this->product['description'] ,
            'price' => $this->product['price'],
            ])){
        }
            $this->dispatch('closeModal',$modal_id);
    }
    public function save_activate_product($id,$modal_id){
        if(DB::table('products')
        ->where('id','=',$id)
        ->update([
            'is_active' => 1
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_deactivate_product($id,$modal_id){
        if(DB::table('products')
        ->where('id','=',$id)
        ->update([
            'is_active' => 0
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
}
