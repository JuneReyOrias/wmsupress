<?php

namespace App\Livewire\Admin\Orders\PendingOrder;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination; 

class PendingOrder extends Component
{
    use WithPagination;
    public $order_details = [
        'order_id'=> NULL,
        'customer_order'=> [],
        'order_items'=> [],
        'error'=> NULL,
    ];
    public $user_id;
    public function mount(Request $request){
        $session = $request->session()->all();
        $this->user_id = $session['id'];
    }
    public function render()
    {
        $order_status = DB::table('order_status')
            ->where('name','=','Pending')
            ->first();
        $customer_order = DB::table('orders as o')
            ->select(
                'o.id as id',
                'os.name as order_status',
                'o.total_price',
                'o.date_created as date_created',
                "u.first_name",
                "u.middle_name",
                "u.last_name",
                "u.email" ,
            )
            ->where('o.status','=',$order_status->id)
            ->join('order_status as os','os.id','o.status')
            ->join('users as u','u.id','o.order_by')
            ->orderBy('o.date_created','desc')
            ->paginate(10);
        return view('livewire.admin.orders.pending-order.pending-order',[
            'customer_order'=>$customer_order,
        ])
        ->layout('components.layouts.admin');
    }
    public function view_order($id,$modal_id){
         $customer_order = DB::table('orders as o')
            ->select(
                'o.id as id',
                'os.name as order_status',
                'o.total_price',
                'o.date_created as date_created',
                "u.first_name",
                "u.middle_name",
                "u.last_name",
                "u.email" ,
                "u.college_id",
                "c.name as college_name",
                "u.department_id",
                "d.name as department_name",
                "u.is_active",
                "o.image_proof",
                "o.date_created",
                "o.date_updated",
            )
            ->join('order_status as os','os.id','o.status')
            ->join('users as u','u.id','o.order_by')
            ->join('colleges as c','u.college_id','c.id')
            ->join('departments as d','u.department_id','d.id')
            ->where('o.id','=',$id)
            ->first();
        $order_items = DB::table('order_items as oi')
            ->select(
                'product_stock_id',
                DB::raw('SUM(oi.quantity) as quantity'),
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
            ->join('product_stocks as ps','ps.id','oi.product_stock_id')
            ->join('products as p','p.id','ps.product_id')
            ->join('product_sizes as psz','psz.id','ps.product_size_id')
            ->join('product_colors as pc','pc.id','ps.product_color_id')
            ->where('order_id','=',$customer_order->id)
            ->groupby('product_stock_id')
            ->get()
            ->toArray();
        $this->order_details = [
            'order_id'=> $id,
            'image_proof'=>$customer_order->image_proof,
            'customer_order'=> $customer_order,
            'order_items'=> $order_items,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    public function save_decline_order($id,$modal_id){
        $order_status = DB::table('order_status')
            ->where('name','=','Declined')
            ->first();
        if(DB::table('orders')
            ->where('id','=',$id)
            ->update([
                'status'=>$order_status->id
            ])){
            $this->dispatch('closeModal',$modal_id);
            $customer_order = DB::table('orders as o')
                ->select(
                    'o.id as id',
                    'os.name as order_status',
                    'o.total_price',
                    'o.date_created as date_created',
                    "u.id as user_id",
                    "u.first_name",
                    "u.middle_name",
                    "u.last_name",
                    "u.email" ,
                    "u.college_id",
                    "c.name as college_name",
                    "u.department_id",
                    "d.name as department_name",
                    "u.is_active",
                    "o.image_proof",
                    "o.date_created",
                    "o.date_updated",
                )
                ->join('order_status as os','os.id','o.status')
                ->join('users as u','u.id','o.order_by')
                ->join('colleges as c','u.college_id','c.id')
                ->join('departments as d','u.department_id','d.id')
                ->where('o.id','=',$id)
                ->first();
            self::insert_notification(
                '
                <svg width="800px" height="800px" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <title>cancelled</title>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="add" fill="#000000" transform="translate(42.666667, 42.666667)">
                            <path d="M213.333333,1.42108547e-14 C331.15408,1.42108547e-14 426.666667,95.5125867 426.666667,213.333333 C426.666667,331.15408 331.15408,426.666667 213.333333,426.666667 C95.5125867,426.666667 4.26325641e-14,331.15408 4.26325641e-14,213.333333 C4.26325641e-14,95.5125867 95.5125867,1.42108547e-14 213.333333,1.42108547e-14 Z M42.6666667,213.333333 C42.6666667,307.589931 119.076736,384 213.333333,384 C252.77254,384 289.087204,370.622239 317.987133,348.156908 L78.5096363,108.679691 C56.044379,137.579595 42.6666667,173.894198 42.6666667,213.333333 Z M213.333333,42.6666667 C173.894198,42.6666667 137.579595,56.044379 108.679691,78.5096363 L348.156908,317.987133 C370.622239,289.087204 384,252.77254 384,213.333333 C384,119.076736 307.589931,42.6666667 213.333333,42.6666667 Z" id="Combined-Shape">

                </path>
                        </g>
                    </g>
                </svg>
                ',
                'Order declined',
                '/customer/orders/declined',
                $customer_order->user_id,
                $this->user_id,
                0,
            );
        }
    }
    public function save_confirm_order($id,$modal_id){
        $order_status = DB::table('order_status')
            ->where('name','=','Confirmed')
            ->first();
        $order_items = DB::table('order_items as oi')
            ->select(
                'product_stock_id',
                DB::raw('SUM(oi.quantity) as quantity'),
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
            ->join('product_stocks as ps','ps.id','oi.product_stock_id')
            ->join('products as p','p.id','ps.product_id')
            ->join('product_sizes as psz','psz.id','ps.product_size_id')
            ->join('product_colors as pc','pc.id','ps.product_color_id')
            ->where('order_id','=',$id)
            ->groupby('product_stock_id')
            ->get()
            ->toArray();
        $valid =true;
        $this->order_details['error'] = NULL;
        foreach($order_items as $key => $value){
            $current_stock = DB::table('product_stocks as ps')
            ->where('ps.id','=',$value->product_stock_id)
            ->first();
            if($value->quantity > $current_stock->quantity){
                $this->order_details['error'] = "Customer avail ".$value->quantity." pcs of Product \"".$value->product_name.'" has only '.$current_stock->quantity.' it is not adequate for the order';
                $valid =false;
                break;
            }
        }
        if($valid){
            if(DB::table('orders')
                ->where('id','=',$id)
                ->update([
                    'status'=>$order_status->id
                ])){
                $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        "u.id as user_id",
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                        "u.is_active",
                        "o.image_proof",
                        "o.date_created",
                        "o.date_updated",
                    )
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->join('colleges as c','u.college_id','c.id')
                    ->join('departments as d','u.department_id','d.id')
                    ->where('o.id','=',$id)
                    ->first();
                self::insert_notification(
                    '
                    <svg fill="#000000" width="800px" height="800px" viewBox="0 0 32 32" enable-background="new 0 0 32 32" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g id="Approved">
                        <g>
                        <path d="M16,1C7.729,1,1,7.729,1,16s6.729,15,15,15s15-6.729,15-15S24.271,1,16,1z M16,29C8.832,29,3,23.168,3,16S8.832,3,16,3    s13,5.832,13,13S23.168,29,16,29z"/>
                        <path d="M23.317,10.27l-10.004,9.36l-4.629-4.332c-0.403-0.377-1.035-0.356-1.413,0.047c-0.377,0.403-0.356,1.036,0.047,1.413    l5.313,4.971c0.192,0.18,0.438,0.27,0.683,0.27s0.491-0.09,0.683-0.27l10.688-10c0.403-0.377,0.424-1.01,0.047-1.413    C24.353,9.913,23.719,9.892,23.317,10.27z"/>
                        </g>
                        </g>
                        <g id="Approved_1_"/>
                        <g id="File_Approve"/>
                        <g id="Folder_Approved"/>
                        <g id="Security_Approved"/>
                        <g id="Certificate_Approved"/>
                        <g id="User_Approved"/>
                        <g id="ID_Card_Approved"/>
                        <g id="Android_Approved"/>
                        <g id="Privacy_Approved"/>
                        <g id="Approved_2_"/>
                        <g id="Message_Approved"/>
                        <g id="Upload_Approved"/>
                        <g id="Download_Approved"/>
                        <g id="Email_Approved"/>
                        <g id="Data_Approved"/>
                    </svg>
                    ',
                    'Order approved',
                    '/customer/orders/confirmed',
                    $customer_order->user_id,
                    $this->user_id,
                    0,
                );
                foreach($order_items as $key => $value){
                    $current_stock = DB::table('product_stocks as ps')
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
                        'ps.quantity as quantity' ,
                        'ps.is_active',
                    )
                    ->join('products as p','p.id','product_id')
                    ->join('product_sizes as psz','psz.id','product_size_id')
                    ->join('product_colors as pc','pc.id','product_color_id')
                    ->where('ps.id','=',$value->product_stock_id)
                    ->first();
                    if($current_stock ){
                        DB::table('product_stocks as ps')
                        ->where('ps.id','=',$value->product_stock_id)
                        ->update([
                            'quantity'=>$current_stock->quantity - $value->quantity
                        ]);
                        if(($current_stock->quantity - $value->quantity) <= 5){
                            self::insert_notification(
                                '
                                <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                    width="800px" height="800px" viewBox="0 0 70.399 70.398"
                                    xml:space="preserve">
                                    <g>
                                        <path d="M70.227,57.273c0-0.63-0.509-1.132-1.124-1.132c-0.63,0-1.132,0.509-1.132,1.132l0.005,9.486L48.535,44.666l-8.342,12.68
                                            l-9.689-37.104l-7.126,22.4L2.567,10.89c-0.036-0.058-0.098-0.098-0.143-0.145V1.128C2.425,0.502,1.917,0,1.292,0
                                            S0.165,0.506,0.165,1.128v68.946h48.604c0.625,0,1.125-0.506,1.125-1.131c0-0.621-0.504-1.127-1.125-1.127H2.425V14.8l21.67,33.062
                                            l6.199-19.488l8.996,34.466l9.507-14.455l17.382,19.759h-9.083c-0.625,0-1.127,0.509-1.127,1.129s0.502,1.127,1.127,1.127h13.139
                                            L70.227,57.273z"/>
                                    </g>
                                </svg>
                                ',
                                $current_stock->product_name.' with size'.$current_stock->product_size.' and color '. $current_stock->product_color.' is low on stocks',
                                '/admin/stock/stocklist',
                                0,
                                $this->user_id,
                                1,
                            );
                        }
                    }
                    DB::table('stockin_stockout_records')
                    ->insert([
                        'product_stock_id' => $value->product_stock_id,
                        'stock_type_id' => 2,
                        'stock_by' => $this->user_id,
                        'quantity' => $value->quantity,
                    ]);

                    
                }
                $this->dispatch('closeModal',$modal_id);
            }
        }else{
            return;
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
