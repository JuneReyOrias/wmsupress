<?php

namespace App\Livewire\Admin\Transactions\ServiceTransactionRecords;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination; 
use Barryvdh\DomPDF\Facade\Pdf;

class ServiceTransactionRecords extends Component
{
    use WithPagination;
    public function mount(Request $request){
        $data = $request->session()->all();
    }
    public $service_availed = [
        'availed_services'=>[],
        'availed_service_items'=> []
    ];
    public $filters = [
        'department_id'=> NULL,
        'college_id'=>NULL,
        'status_id' =>NULL,
        'year'=>NULL,
    ];
    public function render()
    {
        $service_status = DB::table('service_status')
            ->where('name','=','Completed')
            ->first();
        $years = DB::table('availed_services')
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
                if($this->filters['department_id']){
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where(DB::raw('YEAR(asi.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where(DB::raw('YEAR(asi.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->first();
                }
            }else{
                if($this->filters['department_id']){
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where(DB::raw('YEAR(asi.date_updated)'),'=',$this->filters['year'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where(DB::raw('YEAR(asi.date_updated)'),'=',$this->filters['year'])
                    ->first();
                }
            }
        }else{
            if($this->filters['college_id']){
                if($this->filters['department_id']){
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->first();
                }
            }else{
                if($this->filters['department_id']){
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->first();
                }
            }
           
        }
       
        
        if($this->filters['college_id']){
            $departments_data = DB::table('departments')
            ->where('college_id','=',$this->filters['college_id'])
            ->get();
            if($this->filters['department_id']){
                if($this->filters['year']){
                    $availed_services = DB::table('availed_services as avs')
                    ->select(
                        'avs.id',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "ss.name as service_status",
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                        DB::raw('sum(total_price) as total')
                    )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where(DB::raw('YEAR(avs.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->groupBy('avs.id')
                    ->orderBy('avs.date_created','desc')
                    ->paginate(10);
                }else{
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where('u.college_id','=',$this->filters['college_id'])
                        ->where('u.department_id','=',$this->filters['department_id'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->paginate(10);
                }
            }else{
                if($this->filters['year']){
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where(DB::raw('YEAR(avs.date_updated)'),'=',$this->filters['year'])
                        ->where('u.college_id','=',$this->filters['college_id'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->paginate(10);
                }else{
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where('u.college_id','=',$this->filters['college_id'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->paginate(10);
                }
            }
           
        }else{
            if($this->filters['department_id']){
                if($this->filters['year']){
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where(DB::raw('YEAR(avs.date_updated)'),'=',$this->filters['year'])
                        ->where('u.department_id','=',$this->filters['department_id'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->paginate(10);
                }else{
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where('u.department_id','=',$this->filters['department_id'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->paginate(10);
                }
            }else{
                if($this->filters['year']){
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where(DB::raw('YEAR(avs.date_updated)'),'=',$this->filters['year'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->paginate(10);
                }else{
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->paginate(10);
                }
            }
        }
        
        return view('livewire.admin.transactions.service-transaction-records.service-transaction-records',[
            'availed_services'=>$availed_services,
            'colleges_data'=>$colleges_data,
            'departments_data'=>$departments_data,
            'years'=>$years,
            'total_service_revenue'=>$total_service_revenue
        ])
        ->layout('components.layouts.admin');
    }
    public function view_availed_service($id,$modal_id){
        $availed_services = DB::table('availed_services as avs')
        ->select(
            'avs.id',
            "u.first_name",
            "u.middle_name",
            "u.last_name",
            "u.email" ,
            "ss.name as service_status",
            "c.name as college_name",
            "u.department_id",
            "d.name as department_name",
            "u.is_active",
            "avs.date_created",
            "avs.date_updated",
        )
        ->join('service_status as ss','ss.id','avs.service_status_id')
        ->join('users as u','u.id','avs.customer_id')
        ->join('colleges as c','u.college_id','c.id')
        ->join('departments as d','u.department_id','d.id')
        ->where('avs.id','=',$id)
        ->first();
        if(  $availed_services ){
            $availed_service_items = DB::table('availed_service_items as asi')
                ->select(
                    's.id as service_id',
                    's.name as service_name',
                    's.is_active',
                    's.image as service_image',
                    's.description as service_description',
                    "asi.service_id",
                    "asi.quantity",
                    "asi.price_per_unit",
                    "asi.total_price",
                    "asi.remarks",
                )
            ->join('services as s','s.id','asi.service_id')
            ->where('avail_service_id','=',$availed_services->id)
            ->get()
            ->toArray();
            $this->service_availed = [
                'availed_services'=>$availed_services,
                'availed_service_items'=> $availed_service_items
            ];
        }
        $this->dispatch('openModal',$modal_id);
    }
    public function downloadPDF(){
        $service_status = DB::table('service_status')
        ->where('name','=','Completed')
        ->first();
        if($this->filters['year']){
            if($this->filters['college_id']){
                if($this->filters['department_id']){
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where(DB::raw('YEAR(asi.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where(DB::raw('YEAR(asi.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->first();
                }
            }else{
                if($this->filters['department_id']){
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where(DB::raw('YEAR(asi.date_updated)'),'=',$this->filters['year'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where(DB::raw('YEAR(asi.date_updated)'),'=',$this->filters['year'])
                    ->first();
                }
            }
        }else{
            if($this->filters['college_id']){
                if($this->filters['department_id']){
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->first();
                }
            }else{
                if($this->filters['department_id']){
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->first();
                }else{
                    $total_service_revenue =  DB::table('availed_services as avs')
                    ->select(
                        DB::raw('sum(asi.total_price) as total_service_revenue')
                        )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->where('service_status_id','=',$service_status->id)
                    ->first();
                }
            }
           
        }
        if($this->filters['college_id']){
            $departments_data = DB::table('departments')
            ->where('college_id','=',$this->filters['college_id'])
            ->get();
            if($this->filters['department_id']){
                if($this->filters['year']){
                    $availed_services = DB::table('availed_services as avs')
                    ->select(
                        'avs.id',
                        "u.first_name",
                        "u.middle_name",
                        "u.last_name",
                        "u.email" ,
                        "ss.name as service_status",
                        "u.college_id",
                        "c.name as college_name",
                        "u.department_id",
                        "d.name as department_name",
                        DB::raw('sum(total_price) as total')
                    )
                    ->join('service_status as ss','ss.id','avs.service_status_id')
                    ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                    ->join('users as u','u.id','avs.customer_id')
                    ->leftjoin('colleges as c','u.college_id','c.id')
                    ->leftjoin('departments as d','u.department_id','d.id')
                    ->where('service_status_id','=',$service_status->id)
                    ->where(DB::raw('YEAR(avs.date_updated)'),'=',$this->filters['year'])
                    ->where('u.college_id','=',$this->filters['college_id'])
                    ->where('u.department_id','=',$this->filters['department_id'])
                    ->groupBy('avs.id')
                    ->orderBy('avs.date_created','desc')
                    ->get()
                    ->toArray();
                }else{
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where('u.college_id','=',$this->filters['college_id'])
                        ->where('u.department_id','=',$this->filters['department_id'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->get()
                        ->toArray();
                }
            }else{
                if($this->filters['year']){
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where(DB::raw('YEAR(avs.date_updated)'),'=',$this->filters['year'])
                        ->where('u.college_id','=',$this->filters['college_id'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->get()
                        ->toArray();
                }else{
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where('u.college_id','=',$this->filters['college_id'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->get()
                        ->toArray();
                }
            }
           
        }else{
            if($this->filters['department_id']){
                if($this->filters['year']){
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where(DB::raw('YEAR(avs.date_updated)'),'=',$this->filters['year'])
                        ->where('u.department_id','=',$this->filters['department_id'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->get()
                        ->toArray();
                }else{
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where('u.department_id','=',$this->filters['department_id'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->get()
                        ->toArray();
                }
            }else{
                if($this->filters['year']){
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->where(DB::raw('YEAR(avs.date_updated)'),'=',$this->filters['year'])
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->get()
                        ->toArray();
                }else{
                    $availed_services = DB::table('availed_services as avs')
                        ->select(
                            'avs.id',
                            "u.first_name",
                            "u.middle_name",
                            "u.last_name",
                            "u.email" ,
                            "ss.name as service_status",
                            "u.college_id",
                            "c.name as college_name",
                            "u.department_id",
                            "d.name as department_name",
                            DB::raw('sum(total_price) as total')
                        )
                        ->join('service_status as ss','ss.id','avs.service_status_id')
                        ->join('availed_service_items as asi','asi.avail_service_id','avs.id')
                        ->join('users as u','u.id','avs.customer_id')
                        ->leftjoin('colleges as c','u.college_id','c.id')
                        ->leftjoin('departments as d','u.department_id','d.id')
                        ->where('service_status_id','=',$service_status->id)
                        ->groupBy('avs.id')
                        ->orderBy('avs.date_created','desc')
                        ->get()
                        ->toArray();
                }
            }
        }

        $file_name = 'Complete Availed Services ';
        $header =NULL;
        $content = NULL;
        $pdf = Pdf::loadView('livewire.admin.transactions.service-transaction-records.exportpdf',  array( 
            'header'=>$header,
            'availed_services'=> $availed_services,
            'filters'=>$this->filters,
            'total_revenue'=>$total_service_revenue->total_service_revenue
            ));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('a4', 'landscape')->stream();
        },  $file_name.'.pdf');

    }
}
