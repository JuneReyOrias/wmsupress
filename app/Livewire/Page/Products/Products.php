<?php

namespace App\Livewire\Page\Products;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Products extends Component
{
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
        return view('livewire.page.products.products',[
            'stocks_data'=> $stocks_data
        ])
        ->layout('components.layouts.page');
    }
}
