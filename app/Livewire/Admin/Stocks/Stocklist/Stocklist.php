<?php

namespace App\Livewire\Admin\Stocks\Stocklist;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;


class Stocklist extends Component
{
    use WithPagination;
    public $product_stock = [
        'id' => NULL,
        'product_id' => NULL,
        'product_code' => NULL,
        'product_name' => NULL,
        'product_size_id' => NULL,
        'product_size' => NULL,
        'product_color_id' => NULL,
        'product_quantity' => 1,
        'error' => NULL,
    ];
    public $user_id = NULL;
    public function mount(Request $request){
        $session = $request->session()->all();
        $this->user_id = $session['id'];
    }
    public function render()
    {
        $products = DB::table('products')
            ->where('is_active','=',1)
            ->get()
            ->toArray();
        $product_sizes = DB::table('product_sizes')
            ->where('is_active','=',1)
            ->get()
            ->toArray();
        $product_colors = DB::table('product_colors')
            ->where('is_active','=',1)
            ->get()
            ->toArray();
        $stocks_data = [];
        $stocks_data = DB::table('product_stocks as ps')
            ->select(
                'ps.id as id',
                'ps.product_id' ,
                'p.image as product_image' ,
                'p.code as product_code' ,
                'p.name as product_name' ,
                'product_size_id' ,
                'psz.name as product_size' ,
                'product_color_id' ,
                'pc.name as product_color' ,
                'ps.quantity as product_quantity' ,
                'ps.is_active',
            )
            ->join('products as p','p.id','product_id')
            ->join('product_sizes as psz','psz.id','product_size_id')
            ->join('product_colors as pc','pc.id','product_color_id')
            ->paginate(10);
        return view('livewire.admin.stocks.stocklist.stocklist',[
            'stocks_data' =>$stocks_data,
            'products'=>$products,
            'product_sizes'=>$product_sizes,
            'product_colors'=>$product_colors
        ])
        ->layout('components.layouts.admin');
    }
    public function add_product_stock_default($modal_id){
        $this->product_stock = [
            'id' => NULL,
            'product_id' => NULL,
            'product_code' => NULL,
            'product_name' => NULL,
            'product_size_id' => NULL,
            'product_size' => NULL,
            'product_color_id' => NULL,
            'product_color' => NULL,
            'product_quantity' => NULL,
            'error' => NULL,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    public function update_product_details(){
        if(intval($this->product_stock['product_id'])>0 && $product = DB::table('products')
            ->where('id','=',$this->product_stock['product_id'])
            ->where('is_active','=',1)
            ->first()
            ){
            $this->product_stock['product_code'] = $product->code;
            $this->product_stock['product_name'] = $product->name;
            $this->product_stock['product_description'] = $product->description;
        }
    }
    public function update_product_size_details(){
        if(intval($this->product_stock['product_size_id'])>0 && $product_size = DB::table('product_sizes')
            ->where('id','=',$this->product_stock['product_size_id'])
            ->where('is_active','=',1)
            ->first()
            ){
            $this->product_stock['product_size'] = $product_size->description;
        }
    }
    public function add_new_stock($modal_id){
        if(  !DB::table('products')
        ->where('id','=',$this->product_stock['product_id'])
        ->where('is_active','=',1)
        ->first()){
            $this->product_stock['error'] = "Please Select Product";
            return;
        }
        if( !DB::table('product_sizes')
        ->where('id','=',$this->product_stock['product_size_id'])
        ->where('is_active','=',1)
        ->first()){
            $this->product_stock['error'] = "Please Select Product Size";
            return;
        }
        if(intval($this->product_stock['product_quantity'])<=0){
            $this->product_stock['error'] = "Quantity must be greater than 0";
            return;
        }
        if( !DB::table('product_colors')
        ->where('id','=',$this->product_stock['product_color_id'])
        ->where('is_active','=',1)
        ->first()){
            $this->product_stock['error'] = "Please Select Product Color";
            return;
        }
        if(DB::table('product_stocks')
            ->where('product_id','=',$this->product_stock['product_id'])
            ->where('product_color_id','=',$this->product_stock['product_color_id'])
            ->where('product_size_id','=',$this->product_stock['product_size_id'])
            ->first()){
            $this->product_stock['error'] = "Product Stock Exist, Please just stock in";
            return;
        }
        if(DB::table('product_stocks')
            ->insert([
                'product_id' => $this->product_stock['product_id'],
                'product_color_id' => $this->product_stock['product_color_id'],
                'product_size_id' => $this->product_stock['product_size_id'],
                'quantity' => $this->product_stock['product_quantity'],
        ])){
            $product_stock = DB::table('product_stocks')
                ->where('product_id','=',$this->product_stock['product_id'])
                ->where('product_color_id','=',$this->product_stock['product_color_id'])
                ->where('product_size_id','=',$this->product_stock['product_size_id'])
                ->first();

            if($product_stock){
                DB::table('stockin_stockout_records')
                ->insert([
                    'product_stock_id' => $product_stock->id,
                    'stock_type_id' => 1,
                    'stock_by' => $this->user_id,
                    'quantity' => $this->product_stock['product_quantity'],
                ]);
            }
            $this->dispatch('closeModal',$modal_id);
            $this->resetPage();
        }
    }
    public function edit($id,$modal_id){
        $product_stock = DB::table('product_stocks as ps')
            ->select(
                'ps.id as id',
                'ps.product_id' ,
                'p.image as product_image' ,
                'p.code as product_code' ,
                'p.name as product_name' ,
                'product_size_id' ,
                'psz.name as product_size' ,
                'product_color_id' ,
                'pc.name as product_color' ,
                'ps.quantity as product_quantity' ,
                'ps.is_active',
            )
            ->join('products as p','p.id','product_id')
            ->join('product_sizes as psz','psz.id','product_size_id')
            ->join('product_colors as pc','pc.id','product_color_id')
            ->where('ps.id','=',$id)
            ->first();
        if($product_stock){
            $this->product_stock = [
                'id' =>  $product_stock->id,
                'product_id' => $product_stock->product_id,
                'product_code' => $product_stock->product_code,
                'product_name' => $product_stock->product_name,
                'product_size_id' => $product_stock->product_size_id,
                'product_size' => $product_stock->product_size,
                'product_color_id' => $product_stock->product_color_id,
                'product_quantity' => $product_stock->product_quantity,
                'error' => NULL,
            ];
            $this->dispatch('openModal',$modal_id);
        }
    }
    public function save_edit_stock($id,$modal_id){
        if(  !DB::table('products')
        ->where('id','=',$this->product_stock['product_id'])
        ->where('is_active','=',1)
        ->first()){
            $this->product_stock['error'] = "Please Select Product";
            return;
        }
        if( !DB::table('product_sizes')
        ->where('id','=',$this->product_stock['product_size_id'])
        ->where('is_active','=',1)
        ->first()){
            $this->product_stock['error'] = "Please Select Product Size";
            return;
        }
        if( !DB::table('product_colors')
        ->where('id','=',$this->product_stock['product_color_id'])
        ->where('is_active','=',1)
        ->first()){
            $this->product_stock['error'] = "Please Select Product Color";
            return;
        }
        if(DB::table('product_stocks')
            ->where('product_id','=',$this->product_stock['product_id'])
            ->where('product_color_id','=',$this->product_stock['product_color_id'])
            ->where('product_size_id','=',$this->product_stock['product_size_id'])
            ->where('id','<>',$id)
            ->first()){
            $this->product_stock['error'] = "Product Stock Exist, Please just stock in";
            return;
        }
        if(DB::table('product_stocks')
            ->where('id','=',$id)
            ->update([
                'product_id' => $this->product_stock['product_id'],
                'product_color_id' => $this->product_stock['product_color_id'],
                'product_size_id' => $this->product_stock['product_size_id'],
        ])){

        }
        $this->dispatch('closeModal',$modal_id);
    }
    public function save_deactivate_product_stock($id,$modal_id){
        if(DB::table('product_stocks')
        ->where('id','=',$id)
        ->update([
            'is_active' => 0
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_activate_product_stock($id,$modal_id){
        if(DB::table('product_stocks')
        ->where('id','=',$id)
        ->update([
            'is_active' => 1
        ])){
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_stock_in($id,$modal_id){
        $product_stock = DB::table('product_stocks as ps')
        ->select(
            'ps.id as id',
            'ps.product_id' ,
            'p.image as product_image' ,
            'p.code as product_code' ,
            'p.name as product_name' ,
            'product_size_id' ,
            'psz.name as product_size' ,
            'product_color_id' ,
            'pc.name as product_color' ,
            'ps.quantity as product_quantity' ,
            'ps.is_active',
        )
        ->join('products as p','p.id','product_id')
        ->join('product_sizes as psz','psz.id','product_size_id')
        ->join('product_colors as pc','pc.id','product_color_id')
        ->where('ps.id','=',$id)
        ->first();
        if(intval($this->product_stock['product_quantity'])<=0){
            $this->product_stock['error'] = "Quantity must be greater than 0";
            return;
        }
        if(DB::table('product_stocks')
        ->where('id','=',$id)
        ->update([
            'quantity' => $this->product_stock['product_quantity']
        ])){
            if( $product_stock && ($product_stock->product_quantity - $this->product_stock['product_quantity'])){
                DB::table('stockin_stockout_records')
                ->insert([
                    'product_stock_id' => $product_stock->id,
                    'stock_type_id' => 1,
                    'stock_by' => $this->user_id,
                    'quantity' => $this->product_stock['product_quantity'] - $product_stock->product_quantity,
                ]);
            }
        }
        $this->dispatch('closeModal',$modal_id);

    }
    public function save_stock_out($id,$modal_id){
        $product_stock = DB::table('product_stocks as ps')
        ->select(
            'ps.id as id',
            'ps.product_id' ,
            'p.image as product_image' ,
            'p.code as product_code' ,
            'p.name as product_name' ,
            'product_size_id' ,
            'psz.name as product_size' ,
            'product_color_id' ,
            'pc.name as product_color' ,
            'ps.quantity as product_quantity' ,
            'ps.is_active',
        )
        ->join('products as p','p.id','product_id')
        ->join('product_sizes as psz','psz.id','product_size_id')
        ->join('product_colors as pc','pc.id','product_color_id')
        ->where('ps.id','=',$id)
        ->first();
        if(intval($this->product_stock['product_quantity']) < 0){
            $this->product_stock['error'] = "Quantity must not be negative";
            return;
        }
        if(intval($this->product_stock['product_quantity']) > $product_stock->product_quantity){
            $this->product_stock['error'] = "Quantity must be less than current quantity";
            return;
        }
        if(DB::table('product_stocks')
        ->where('id','=',$id)
        ->update([
            'quantity' => $this->product_stock['product_quantity']
        ])){
           
            if( $product_stock && ($product_stock->product_quantity - $this->product_stock['product_quantity'])){
                DB::table('stockin_stockout_records')
                ->insert([
                    'product_stock_id' => $product_stock->id,
                    'stock_type_id' => 2,
                    'stock_by' => $this->user_id,
                    'quantity' => $product_stock->product_quantity - $this->product_stock['product_quantity'] ,
                ]);
            }
        }
        $this->dispatch('closeModal',$modal_id);
    }
}
