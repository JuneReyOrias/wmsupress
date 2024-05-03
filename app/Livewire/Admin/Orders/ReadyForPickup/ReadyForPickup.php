<?php

namespace App\Livewire\Admin\Orders\ReadyForPickup;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination; 
use Livewire\WithFileUploads;

class ReadyForPickup extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $order_details = [
        'order_id'=> NULL,
        'image_proof'=> NULL,
        'customer_order'=> [],
        'order_items'=> [],
    ];
    public $user_id;
    public function mount(Request $request){
        $session = $request->session()->all();
        $this->user_id = $session['id'];
    }
    public function render()
    {
        $order_status = DB::table('order_status')
            ->where('name','=','Ready for Pickup')
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
        return view('livewire.admin.orders.ready-for-pickup.ready-for-pickup',[
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
            'image_proof'=>NULL,
            'customer_order'=> $customer_order,
            'order_items'=> $order_items,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    
    public function save_confirm_order($id,$modal_id){
        $order_status = DB::table('order_status')
            ->where('name','=','Confirmed')
            ->first();
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
                'Order returned to approved',
                '/customer/orders/confirmed',
                $customer_order->user_id,
                $this->user_id,
                0,
            );
            $this->dispatch('closeModal',$modal_id);
        }
    }
    public function save_complete_order($id,$modal_id){
        $order_status = DB::table('order_status')
            ->where('name','=','Completed')
            ->first();
        $order_details['image_proof'] = NULL;
        if($this->order_details['image_proof']){
            $order_details['image_proof'] = self::save_image($this->order_details['image_proof'],'orders/proof','orders','image_proof');
            if($order_details['image_proof'] == 0){
                return;
            }
        }
        if(DB::table('orders')
            ->where('id','=',$id)
            ->update([
                'status'=>$order_status->id,
                'image_proof'=> $order_details['image_proof']
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
                <svg width="800px" height="800px" viewBox="0 0 1024 1024" fill="#000000" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M824.8 1003.2H203.2c-12.8 0-25.6-2.4-37.6-7.2-11.2-4.8-21.6-12-30.4-20.8-8.8-8.8-16-19.2-20.8-30.4-4.8-12-7.2-24-7.2-37.6V260c0-12.8 2.4-25.6 7.2-37.6 4.8-11.2 12-21.6 20.8-30.4 8.8-8.8 19.2-16 30.4-20.8 12-4.8 24-7.2 37.6-7.2h94.4v48H203.2c-26.4 0-48 21.6-48 48v647.2c0 26.4 21.6 48 48 48h621.6c26.4 0 48-21.6 48-48V260c0-26.4-21.6-48-48-48H730.4v-48H824c12.8 0 25.6 2.4 37.6 7.2 11.2 4.8 21.6 12 30.4 20.8 8.8 8.8 16 19.2 20.8 30.4 4.8 12 7.2 24 7.2 37.6v647.2c0 12.8-2.4 25.6-7.2 37.6-4.8 11.2-12 21.6-20.8 30.4-8.8 8.8-19.2 16-30.4 20.8-11.2 4.8-24 7.2-36.8 7.2z" fill="" /><path d="M752.8 308H274.4V152.8c0-32.8 26.4-60 60-60h61.6c22.4-44 67.2-72.8 117.6-72.8 50.4 0 95.2 28.8 117.6 72.8h61.6c32.8 0 60 26.4 60 60v155.2m-430.4-48h382.4V152.8c0-6.4-5.6-12-12-12H598.4l-5.6-16c-12-33.6-43.2-56-79.2-56s-67.2 22.4-79.2 56l-5.6 16H334.4c-6.4 0-12 5.6-12 12v107.2zM432.8 792c-6.4 0-12-2.4-16.8-7.2L252.8 621.6c-4.8-4.8-7.2-10.4-7.2-16.8s2.4-12 7.2-16.8c4.8-4.8 10.4-7.2 16.8-7.2s12 2.4 16.8 7.2L418.4 720c4 4 8.8 5.6 13.6 5.6s10.4-1.6 13.6-5.6l295.2-295.2c4.8-4.8 10.4-7.2 16.8-7.2s12 2.4 16.8 7.2c9.6 9.6 9.6 24 0 33.6L449.6 784.8c-4.8 4-11.2 7.2-16.8 7.2z" fill="" /></svg>
                ',
                'Order is completed',
                '/customer/orders/completed',
                $customer_order->user_id,
                $this->user_id,
                0,
            );
            $this->dispatch('closeModal',$modal_id);
        }
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
