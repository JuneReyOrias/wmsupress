<?php

namespace App\Livewire\Customer\OrderList;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class OrderList extends Component
{

    public function render(Request $request){
        $data = $request->session()->all();
        $customer_order = DB::table('orders as o')
            ->select(
                'o.id as id',
                'os.name as order_status',
                'o.total_price',
                'o.date_created as date_created',
            )
            ->where('order_by','=',$data['id'])
            ->join('order_status as os','os.id','o.status')
            ->orderBy('o.date_created')
            ->paginate(10);

        return view('livewire.customer.order-list.order-list',[
            'customer_order'=>$customer_order
        ])
        ->layout('components.layouts.customer');
    }
}
