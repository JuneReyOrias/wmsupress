<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class admindashboard extends Controller
{
    //
    public function product_revenue($year,$month){
        $total_product_revenue_months =  DB::table('orders as o')
            ->select(
                DB::raw('distinct MONTHNAME(o.date_updated) as month_label'),
                DB::raw('MONTH(o.date_updated) as month')
            )
            ->join('order_status as os','os.id','o.status')
            ->orderBy(DB::raw('MONTH(o.date_updated)'),'asc')
            ->where(DB::raw('YEAR(o.date_updated)'),'=',$year) 
            ->where('os.name','=','Completed')
            ->get()
            ->toArray();
        if($month == -1){
            $product_revenue = DB::table('orders as o')
                ->select(
                    
                    DB::raw('MONTH(o.date_updated) as month'),
                    DB::raw('sum(total_price) as total')
                )
                ->join('order_status as os','os.id','o.status')
                ->groupBy(DB::raw('MONTH(o.date_updated)'))
                ->orderBy(DB::raw('MONTH(o.date_updated)'),'asc')
                ->where(DB::raw('YEAR(o.date_updated)'),'=',$year) 
                ->where('os.name','=','Completed')
                ->get()
                ->toArray();
            
        }else{
            $product_revenue = DB::table('orders as o')
                ->select(
                    DB::raw('DAY(o.date_updated) as day'),
                    DB::raw('sum(total_price) as total')
                )
                ->where(DB::raw('YEAR(o.date_updated)'),'=',$year) 
                ->where('o.status','=',6)
                ->groupBy(DB::raw('DAY(o.date_updated)'))
                ->orderBy(DB::raw('DAY(o.date_updated)'),'asc')
                ->get()
                ->toArray();
        }
        return ['product_revenue'=>$product_revenue,'total_product_revenue_months'=>$total_product_revenue_months];
    }
}
