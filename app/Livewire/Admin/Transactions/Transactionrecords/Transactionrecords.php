<?php

namespace App\Livewire\Admin\Transactions\Transactionrecords;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination; 
use Barryvdh\DomPDF\Facade\Pdf;

class Transactionrecords extends Component
{
    use WithPagination;
    public $order_details = [
        'order_id'=> NULL,
        'customer_order'=> [],
        'order_items'=> [],
    ];
    public $filters = [
        'department_id'=> NULL,
        'college_id'=>NULL,
        'status_id' =>NULL,
        'year' =>NULL,
    ];
    public function render()
    {
        $order_status = DB::table('order_status')
            ->where('name','=','Completed')
            ->first();
        $years = DB::table('orders')
        ->select(
            DB::raw('YEAR(date_updated) as year')
            )
        ->orderBy(DB::raw('YEAR(date_updated)'),'desc')
        ->groupBy(DB::raw('YEAR(date_updated)'))
        ->get()
        ->toArray();
        $colleges_data = DB::table('colleges')
            ->get();
        $departments_data = DB::table('departments')
            ->get();
        if($this->filters['year']){
            if($this->filters['college_id']){
                $departments_data = DB::table('departments')
                    ->where('college_id','=',$this->filters['college_id'])
                    ->get();
                if($this->filters['department_id']){
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->first();
                }
            }else{
                if($this->filters['department_id']){
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->first();
                }
            }
        }else{
            if($this->filters['college_id']){
                $departments_data = DB::table('departments')
                ->where('college_id','=',$this->filters['college_id'])
                ->get();
                if($this->filters['department_id']){
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->first();
                }
            }else{
                if($this->filters['department_id']){
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->first();
                }
            }
        }

        if($this->filters['year']){
            if($this->filters['college_id']){
                if($this->filters['department_id']){
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->orderBy('o.date_created','desc')
                    ->paginate(10);
                }else{
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->orderBy('o.date_created','desc')
                    ->paginate(10);
                }
            }else{
                if($this->filters['department_id']){
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->orderBy('o.date_created','desc')
                    ->paginate(10);
                }else{
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->orderBy('o.date_created','desc')
                    ->paginate(10);
                }
            }
        }else{
            if($this->filters['college_id']){
                if($this->filters['department_id']){
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->orderBy('o.date_created','desc')
                    ->paginate(10);
                }else{
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->orderBy('o.date_created','desc')
                    ->paginate(10);
                }
            }else{
                if($this->filters['department_id']){
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->orderBy('o.date_created','desc')
                    ->paginate(10);
                }else{
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->orderBy('o.date_created','desc')
                    ->paginate(10);
                }
            }
        }
       
        return view('livewire.admin.transactions.transactionrecords.transactionrecords',[
            'customer_order'=>$customer_order,
            'colleges_data'=>$colleges_data,
            'departments_data'=>$departments_data,
            'years'=>$years,
            'total_product_revenue'=>$total_product_revenue
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
            'customer_order'=> $customer_order,
            'order_items'=> $order_items,
        ];
        $this->dispatch('openModal',$modal_id);
    }
    public function downloadPDF(){
        $order_status = DB::table('order_status')
            ->where('name','=','Completed')
            ->first();
        if($this->filters['year']){
            if($this->filters['college_id']){
                $departments_data = DB::table('departments')
                    ->where('college_id','=',$this->filters['college_id'])
                    ->get();
                if($this->filters['department_id']){
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->first();
                }
            }else{
                if($this->filters['department_id']){
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->first();
                }
            }
        }else{
            if($this->filters['college_id']){
                $departments_data = DB::table('departments')
                ->where('college_id','=',$this->filters['college_id'])
                ->get();
                if($this->filters['department_id']){
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->first();
                }
            }else{
                if($this->filters['department_id']){
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_product_revenue =  DB::table('orders as o')
                    ->select(DB::raw('sum(o.total_price) as total_product_revenue'))
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->where('os.name','=','Completed')
                    ->first();
                }
            }
        }
        if($this->filters['year']){
            if($this->filters['college_id']){
                if($this->filters['department_id']){
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->orderBy('o.date_created','desc')
                    ->get()
                    ->toArray();
                }else{
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->orderBy('o.date_created','desc')
                    ->get()
                    ->toArray();
                }
            }else{
                if($this->filters['department_id']){
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->orderBy('o.date_created','desc')
                    ->get()
                    ->toArray();
                }else{
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where(DB::raw('YEAR(o.date_updated)'),'=',$this->filters['year'])
                    ->orderBy('o.date_created','desc')
                    ->get()
                    ->toArray();
                }
            }
        }else{
            if($this->filters['college_id']){
                if($this->filters['department_id']){
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->orderBy('o.date_created','desc')
                    ->get()
                    ->toArray();
                }else{
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->orderBy('o.date_created','desc')
                    ->get()
                    ->toArray();
                }
            }else{
                if($this->filters['department_id']){
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->orderBy('o.date_created','desc')
                    ->get()
                    ->toArray();
                }else{
                    $customer_order = DB::table('orders as o')
                    ->select(
                        'o.id as id',
                        'os.name as order_status',
                        'o.total_price',
                        'o.date_created as date_created',
                        'o.date_updated as date_updated',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                    )
                    ->where('o.status','=',$order_status->id)
                    ->join('order_status as os','os.id','o.status')
                    ->join('users as u','u.id','o.order_by')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->orderBy('o.date_created','desc')
                    ->get()
                    ->toArray();
                }
            }
        }
        $file_name = 'Complete Orders ';
        $header =NULL;
        $content = NULL;
        $pdf = Pdf::loadView('livewire.admin.transactions.transactionrecords.exportpdf',  array( 
            'header'=>$header,
            'customer_order'=> $customer_order,
            'filters'=>$this->filters,
            'total_revenue'=>$total_product_revenue->total_product_revenue
            ));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('a4', 'landscape')->stream();
        },  $file_name.'.pdf');

    }
}
