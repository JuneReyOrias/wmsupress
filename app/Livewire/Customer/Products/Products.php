<?php

namespace App\Livewire\Customer\Products;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    public $current_cart = [
        'product_stock_id'=> NULL,
        'product' => NULL,
        'product_colors'=> [],
        'product_sizes'=> [],
        'product_color'=> NULL,
        'product_size'=> NULL,
        'quantity' => NULL,
        'error' => NULL,
    ];
    public function render()
    {
        $stocks_data = DB::table('products as p')
        ->select(
            'p.id',
            'p.image as product_image' ,
            'p.code as product_code' ,
            'p.name as product_name' ,
            'p.description as product_description' ,
            'p.price as product_price' ,
            'p.is_active',
        )
        ->rightjoin('product_stocks as ps','p.id','ps.product_id')
        ->groupby('p.id')
        ->paginate(10);
        return view('livewire.customer.products.products',[
            'stocks_data'=>$stocks_data
        ])
        ->layout('components.layouts.customer');
    }

    public function add_to_cart($id,$modal_id){
        $product = DB::table('products as p')
            ->where('id','=',$id)
            ->first();
        
        $product_colors = DB::table('product_stocks as ps')
            ->select(DB::raw('DISTINCT(product_color_id)'),
            'pc.name as product_color_name',
            'pc.description as product_color_description'
            )
            ->leftjoin('product_colors as pc','pc.id','ps.product_color_id')
            ->where('ps.product_id','=',$id)
            ->get()
            ->toArray();
        $product_sizes = DB::table('product_stocks as ps')
            ->select(DB::raw('DISTINCT(product_size_id)'),
            'psz.name as product_size_name',
            'psz.description as product_size_description'
            )
            ->leftjoin('product_sizes as psz','psz.id','ps.product_size_id')
            ->where('ps.product_id','=',$id)
            ->get()
            ->toArray();
        $this->current_cart = [
            'product_stock_id'=> NULL,
            'product' => $product,
            'product_colors'=> $product_colors,
            'product_sizes'=> $product_sizes,
            'product_color_id'=> NULL,
            'product_size_id'=> NULL,
            'quantity' => NULL,
            'error' => NULL,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    public function update_product_color_details(){
        $product_colors = DB::table('product_stocks as ps')
            ->select(DB::raw('DISTINCT(product_color_id)'),
            'pc.name as product_color_name',
            'pc.description as product_color_description'
            )
            ->leftjoin('product_colors as pc','pc.id','ps.product_color_id')
            ->where('ps.product_id','=',$this->current_cart['product']->id)
            ->where('ps.product_size_id','=',$this->current_cart['product_size_id'])
            ->get()
            ->toArray();
        $this->current_cart['product_colors'] = $product_colors;
    }
    public function update_product_size_details(){

    }
    public function save_add_to_cart(Request $request,$modal_id){
        $data = $request->session()->all();
        $this->current_cart['error'] = NULL;
        if( !intval($this->current_cart['product_size_id'])){
            $this->current_cart['error'] = "Please select size";
            return;
        }
        if( !intval($this->current_cart['product_color_id'])){
            $this->current_cart['error'] = "Please select color";
            return;
        }
        if( !intval($this->current_cart['quantity'])){
            $this->current_cart['error'] = "Please input quantity";
            return;
        }
        if($stocks = DB::table('product_stocks as ps')
            ->where('ps.product_id','=',$this->current_cart['product']->id)
            ->where('ps.product_color_id','=',$this->current_cart['product_color_id'])
            ->where('ps.product_size_id','=',$this->current_cart['product_size_id'])
            ->first()){
            if($customer_cart = DB::table('customer_cart as cc')
                ->select(DB::raw('SUM(quantity) as quantity'))
                ->where('cc.customer_id','=',$data['id'])
                ->where('cc.product_stock_id','=',$stocks->id)
                ->first()){
                if($this->current_cart['quantity']> $stocks->quantity-$customer_cart->quantity ){
                    $this->current_cart['error'] = "You currently have ".$customer_cart->quantity.' pcs on your cart, you\'re trying to add '.$this->current_cart['quantity'].' max quantity is '.$stocks->quantity;
                    return;
                }
            }
            if($this->current_cart['quantity'] > $stocks->quantity){
                $this->current_cart['error'] = "Please quantity must be less than or equal to ".$stocks->quantity;
                return;
            }
        }
        $customer_cart = DB::table('customer_cart as cc')
            ->select(DB::raw('SUM(quantity) as quantity'))
            ->where('cc.customer_id','=',$data['id'])
            ->where('cc.product_stock_id','=',$stocks->id)
            ->first();
        if($customer_cart->quantity){
            DB::table('customer_cart as cc')
            ->select(DB::raw('SUM(quantity) as quantity'))
            ->where('cc.customer_id','=',$data['id'])
            ->where('cc.product_stock_id','=',$stocks->id)
            ->update([
                'quantity' => $customer_cart->quantity+$this->current_cart['quantity']
            ]);
        }else{
            DB::table('customer_cart')
            ->insert([
                'customer_id' => $data['id'],
                'product_stock_id' => $stocks->id,
                'quantity' => $this->current_cart['quantity'],
            ]);
        }
        $this->dispatch('closeModal',$modal_id);
        
        
    }
    public function update_max_stock(Request $request){
        $data = $request->session()->all();
        $this->current_cart['error'] = NULL;
        if( !intval($this->current_cart['product_size_id'])){
            $this->current_cart['error'] = "Please select size";
            return;
        }
        if( !intval($this->current_cart['product_color_id'])){
            $this->current_cart['error'] = "Please select color";
            return;
        }
    
        if($stocks = DB::table('product_stocks as ps')
            ->where('ps.product_id','=',$this->current_cart['product']->id)
            ->where('ps.product_color_id','=',$this->current_cart['product_color_id'])
            ->where('ps.product_size_id','=',$this->current_cart['product_size_id'])
            ->first()){
            if($customer_cart = DB::table('customer_cart as cc')
                ->select(DB::raw('SUM(quantity) as quantity'))
                ->where('cc.customer_id','=',$data['id'])
                ->where('cc.product_stock_id','=',$stocks->id)
                ->first()){
                if($this->current_cart['quantity']> $stocks->quantity-$customer_cart->quantity ){
                    $this->current_cart['error'] = "You currently have ".$customer_cart->quantity.' pcs on your cart, you\'re trying to add '.$this->current_cart['quantity'].' max quantity is '.$stocks->quantity;
                    return;
                }
            }
            if($this->current_cart['quantity'] > $stocks->quantity){
                $this->current_cart['error'] = "Please quantity must be less than or equal to ".$stocks->quantity;
                return;
            }
        }
    }
}
