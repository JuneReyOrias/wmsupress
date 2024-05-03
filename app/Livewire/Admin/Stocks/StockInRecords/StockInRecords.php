<?php

namespace App\Livewire\Admin\Stocks\StockInRecords;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class StockInRecords extends Component
{
    use WithPagination;
    public function render()
    {
        $stock_in_out_records = DB::table('stockin_stockout_records as stio')
            ->select(
                'u.email',
                'u.last_name',
                'u.middle_name',
                'u.first_name',

                'ps.product_id' ,
                'p.image as product_image' ,
                'p.code as product_code' ,
                'p.name as product_name' ,
                'ps.product_size_id' ,
                'psz.name as product_size' ,
                'ps.product_color_id' ,
                'pc.name as product_color' ,
                'stio.quantity as stock_quantity' ,

                'st.name as stock_type_name',
                'stio.date_created',
                'stio.date_updated'
            )
            ->join('product_stocks as ps','ps.id','stio.product_stock_id')
            ->join('products as p','p.id','product_id')
            ->join('product_sizes as psz','psz.id','product_size_id')
            ->join('product_colors as pc','pc.id','product_color_id')
            ->join('stock_types as st','st.id','stio.stock_type_id')
            ->join('users as u','u.id','stio.stock_by')
            ->where('stio.stock_type_id','=',1)
            ->orderBy('stio.date_created','desc')
            ->paginate(10);
        return view('livewire.admin.stocks.stock-in-records.stock-in-records',[
            'stock_in_out_records'=>$stock_in_out_records
        ])
        ->layout('components.layouts.admin');
    }
}
