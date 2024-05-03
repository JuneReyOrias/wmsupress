<?php

namespace App\Livewire\Customer\Cart;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Cart extends Component
{
    use WithPagination;
    public $customer_cart = [];
    public $order = [
        'Customer Detail' =>NULL,
        'customer_cart' => NULL,
    ];
    public $product_stock_id = NULL;
    public function mount(Request $request){
        self::update_cart_data($request);
    }
    public function update_cart_data(Request $request){
        $data = $request->session()->all();
        $this->customer_cart = DB::table('customer_cart as cc')
            ->select(
                'product_stock_id',
                DB::raw('SUM(cc.quantity) as quantity'),
                'ps.product_id' ,
                'p.image as product_image' ,
                'p.code as product_code' ,
                'p.price as product_price' ,
                'p.name as product_name' ,
                'ps.product_size_id' ,
                'psz.name as product_size' ,
                'ps.product_color_id' ,
                'pc.name as product_color' ,
                'ps.quantity as product_quantity' ,
                'ps.is_active',
                )
            ->join('product_stocks as ps','ps.id','cc.product_stock_id')
            ->join('products as p','p.id','ps.product_id')
            ->join('product_sizes as psz','psz.id','ps.product_size_id')
            ->join('product_colors as pc','pc.id','ps.product_color_id')
            ->where('cc.customer_id','=',$data['id'])
            ->groupby('product_stock_id')
            ->get()
            ->toArray();
    }
    public function render(Request $request){
        $data = $request->session()->all();
       
        return view('livewire.customer.cart.cart',[
        ])
        ->layout('components.layouts.customer');
    }
    public function update_cart_quantity(Request $request,$id){
        $data = $request->session()->all();
        $quantity = NULL;
        $product_quantity = NULL;
        foreach ($this->customer_cart as $key => $value) {
            if($value->product_stock_id == $id){
                $quantity = $this->customer_cart[$key]->quantity;
                $product_quantity = $this->customer_cart[$key]->product_quantity;
            }
        }
        $cart_quantity = DB::table('customer_cart as cc')
            ->select(DB::raw('SUM(quantity) as quantity'))
            ->where('cc.customer_id','=',$data['id'])
            ->where('cc.product_stock_id','=',$id)
            ->first();
        if($cart_quantity){
            $cart_quantity = $cart_quantity->quantity;
        }
        if($customer_product_cart = DB::table('customer_cart as cc')
        ->select('*')
        ->where('cc.customer_id','=',$data['id'])
        ->where('cc.product_stock_id','=',$id)
        ->get()
        ->toArray()){
            if($quantity && intval($quantity)>0 ){
                if($quantity <= $product_quantity ){
                    $current_val = $cart_quantity - $quantity;
                    if($quantity < $cart_quantity ){
                        foreach ($customer_product_cart as $key => $value) {
                            if( $current_val >= 0){
                                if(($value->quantity - $current_val ) > 0){
                                    DB::table('customer_cart as cc') 
                                        ->where('id','=',$value->id)
                                        ->where('cc.customer_id','=',$data['id'])
                                        ->where('cc.product_stock_id','=',$id)
                                        ->update([
                                            'quantity' => $value->quantity -  $current_val
                                        ]);
                                }else{
                                    DB::table('customer_cart as cc') 
                                    ->where('id','=',$value->id)
                                    ->where('cc.customer_id','=',$data['id'])
                                    ->where('cc.product_stock_id','=',$id)
                                    ->delete();
                                }
                                $current_val -= $value->quantity;
                            }
                        }
                    }else{
                        foreach ($customer_product_cart as $key => $value) {
                            if($quantity <= $product_quantity){
                                if($customer_product_cart){
                                    DB::table('customer_cart as cc') 
                                    ->where('id','=',$customer_product_cart[0]->id)
                                    ->where('cc.customer_id','=',$data['id'])
                                    ->where('cc.product_stock_id','=',$id)
                                    ->update([
                                        'quantity' => $quantity
                                    ]);
                                }
                            }else{
                                //error
                            }
                        }
                    }
                }else{
                    // error
                }
               
            }
        }
    }
    public function remove_item_default($id,$modal_id){
        $this->product_stock_id = $id;
        $this->dispatch('openModal',$modal_id);
    }
    public function remove_item(Request $request,$id,$modal_id){
        $data = $request->session()->all();
        if($customer_product_cart = DB::table('customer_cart as cc')
        ->select('*')
        ->where('cc.customer_id','=',$data['id'])
        ->where('cc.product_stock_id','=',$id)
        ->get()
        ->toArray()){
            foreach ($customer_product_cart as $key => $value) {
                DB::table('customer_cart as cc') 
                ->where('id','=',$value->id)
                ->where('cc.customer_id','=',$data['id'])
                ->where('cc.product_stock_id','=',$id)
                ->delete();
            }
          
        }
        $this->dispatch('closeModal',$modal_id);
        $this->customer_cart = DB::table('customer_cart as cc')
            ->select(
                'product_stock_id',
                DB::raw('SUM(cc.quantity) as quantity'),
                'ps.product_id' ,
                'p.image as product_image' ,
                'p.code as product_code' ,
                'p.price as product_price' ,
                'p.name as product_name' ,
                'ps.product_size_id' ,
                'psz.name as product_size' ,
                'ps.product_color_id' ,
                'pc.name as product_color' ,
                'ps.quantity as product_quantity' ,
                'ps.is_active',
                )
            ->join('product_stocks as ps','ps.id','cc.product_stock_id')
            ->join('products as p','p.id','ps.product_id')
            ->join('product_sizes as psz','psz.id','ps.product_size_id')
            ->join('product_colors as pc','pc.id','ps.product_color_id')
            ->where('cc.customer_id','=',$data['id'])
            ->groupby('product_stock_id')
            ->get()
            ->toArray();
    }
    public function add_order(Request $request,$modal_id){
        $data = $request->session()->all();
        $cart = DB::table('customer_cart as cc')
        ->select(
            'product_stock_id',
            DB::raw('SUM(cc.quantity) as quantity'),
            'ps.product_id' ,
            'p.image as product_image' ,
            'p.code as product_code' ,
            'p.price as product_price' ,
            'p.name as product_name' ,
            'ps.product_size_id' ,
            'psz.name as product_size' ,
            'ps.product_color_id' ,
            'pc.name as product_color' ,
            'ps.quantity as product_quantity' ,
            'ps.is_active',
            )
        ->join('product_stocks as ps','ps.id','cc.product_stock_id')
        ->join('products as p','p.id','ps.product_id')
        ->join('product_sizes as psz','psz.id','ps.product_size_id')
        ->join('product_colors as pc','pc.id','ps.product_color_id')
        ->where('cc.customer_id','=',$data['id'])
        ->groupby('product_stock_id')
        ->get()
        ->toArray();

        // validation
        $order = [
            'order_by' =>$data['id'],
            'valid'=> true,
            'total_price'=> 0,
        ];
        if( count($cart) ){
            foreach ($cart  as $key => $value) {
                if($value->quantity > $value->product_quantity){
                    $order['valid'] = false;
                }  
                $order['total_price'] += $value->quantity * $value->product_price;
    
            }
        }else{
            $order['valid'] = false;
        }
      
        if( $order['valid'] ){
            DB::table('orders')
                ->insert([
                    'order_by' =>$order['order_by'],
                    'total_price'=>$order['total_price']
                ]);
            $current_order = DB::table('orders as o')
                ->where('order_by','=',$order['order_by'])
                ->orderBy('o.id','desc')
                ->first();
            foreach ($cart  as $key => $value) {
                DB::table('order_items')
                    ->insert([
                    'order_id' => $current_order->id,
                    'order_by' => $order['order_by'],
                    'product_stock_id' => $value->product_stock_id,
                    'quantity' => $value->quantity,
                ]);
                DB::table('customer_cart as cc')
                ->where('cc.customer_id','=',$data['id'])
                ->where('cc.product_stock_id','=',$value->product_stock_id)
                ->delete();
            }

            self::insert_notification(
                '<svg width="24px" height="24px" viewBox="0 0 1024 1024" fill="#000000" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M959.018 208.158c0.23-2.721 0.34-5.45 0.34-8.172 0-74.93-60.96-135.89-135.89-135.89-1.54 0-3.036 0.06-6.522 0.213l-611.757-0.043c-1.768-0.085-3.563-0.17-5.424-0.17-74.812 0-135.67 60.84-135.67 135.712l0.188 10.952h-0.306l0.391 594.972-0.162 20.382c0 74.03 60.22 134.25 134.24 134.25 1.668 0 7.007-0.239 7.1-0.239l608.934 0.085c2.985 0.357 6.216 0.468 9.55 0.468 35.815 0 69.514-13.954 94.879-39.302 25.373-25.34 39.344-58.987 39.344-94.794l-0.145-12.015h0.918l-0.008-606.41z m-757.655 693.82l-2.585-0.203c-42.524 0-76.146-34.863-76.537-79.309V332.671H900.79l0.46 485.186-0.885 2.865c-0.535 1.837-0.8 3.58-0.8 5.17 0 40.382-31.555 73.766-71.852 76.002l-10.816 0.621v-0.527l-615.533-0.01zM900.78 274.424H122.3l-0.375-65.934 0.85-2.924c0.52-1.82 0.782-3.63 0.782-5.247 0-42.236 34.727-76.665 78.179-76.809l0.45-0.068 618.177 0.018 2.662 0.203c42.329 0 76.767 34.439 76.767 76.768 0 1.326 0.196 2.687 0.655 4.532l0.332 0.884v68.577z" fill="" /><path d="M697.67 471.435c-7.882 0-15.314 3.078-20.918 8.682l-223.43 223.439L346.599 596.84c-5.544-5.603-12.95-8.69-20.842-8.69s-15.323 3.078-20.918 8.665c-5.578 5.518-8.674 12.9-8.7 20.79-0.017 7.908 3.07 15.357 8.69 20.994l127.55 127.558c5.57 5.56 13.01 8.622 20.943 8.622 7.925 0 15.364-3.06 20.934-8.63l244.247-244.247c5.578-5.511 8.674-12.883 8.7-20.783 0.017-7.942-3.079-15.408-8.682-20.986-5.552-5.612-12.958-8.698-20.85-8.698z" fill="" /></svg>',
                'Order Created',
                '/customer/orders/pending',
                $data['id'],
                $data['id'],
                0,
            );
            self::insert_notification(
                '<svg width="24px" height="24px" viewBox="0 0 1024 1024" fill="#000000" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M959.018 208.158c0.23-2.721 0.34-5.45 0.34-8.172 0-74.93-60.96-135.89-135.89-135.89-1.54 0-3.036 0.06-6.522 0.213l-611.757-0.043c-1.768-0.085-3.563-0.17-5.424-0.17-74.812 0-135.67 60.84-135.67 135.712l0.188 10.952h-0.306l0.391 594.972-0.162 20.382c0 74.03 60.22 134.25 134.24 134.25 1.668 0 7.007-0.239 7.1-0.239l608.934 0.085c2.985 0.357 6.216 0.468 9.55 0.468 35.815 0 69.514-13.954 94.879-39.302 25.373-25.34 39.344-58.987 39.344-94.794l-0.145-12.015h0.918l-0.008-606.41z m-757.655 693.82l-2.585-0.203c-42.524 0-76.146-34.863-76.537-79.309V332.671H900.79l0.46 485.186-0.885 2.865c-0.535 1.837-0.8 3.58-0.8 5.17 0 40.382-31.555 73.766-71.852 76.002l-10.816 0.621v-0.527l-615.533-0.01zM900.78 274.424H122.3l-0.375-65.934 0.85-2.924c0.52-1.82 0.782-3.63 0.782-5.247 0-42.236 34.727-76.665 78.179-76.809l0.45-0.068 618.177 0.018 2.662 0.203c42.329 0 76.767 34.439 76.767 76.768 0 1.326 0.196 2.687 0.655 4.532l0.332 0.884v68.577z" fill="" /><path d="M697.67 471.435c-7.882 0-15.314 3.078-20.918 8.682l-223.43 223.439L346.599 596.84c-5.544-5.603-12.95-8.69-20.842-8.69s-15.323 3.078-20.918 8.665c-5.578 5.518-8.674 12.9-8.7 20.79-0.017 7.908 3.07 15.357 8.69 20.994l127.55 127.558c5.57 5.56 13.01 8.622 20.943 8.622 7.925 0 15.364-3.06 20.934-8.63l244.247-244.247c5.578-5.511 8.674-12.883 8.7-20.783 0.017-7.942-3.079-15.408-8.682-20.986-5.552-5.612-12.958-8.698-20.85-8.698z" fill="" /></svg>',
                'New order received ',
                '/admin/orders/pending',
                0,
                $data['id'],
                1,
            );
            $this->dispatch('closeModal',$modal_id);
            self::update_cart_data($request);
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
