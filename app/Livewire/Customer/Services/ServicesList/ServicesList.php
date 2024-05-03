<?php

namespace App\Livewire\Customer\Services\ServicesList;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class ServicesList extends Component
{
    use WithPagination;
    public $service_cart = [
        'id'=> NULL,
        'serivice'=> NULL,
        'services' =>[],
    ];
    public $user_id ;
    public function mount(Request $request){
        $data = $request->session()->all();
        $this->user_id = $data['id'];
        $this->service_cart['services'] = DB::table('services_cart')
            ->where('customer_id','=',$this->user_id)
            ->get()
            ->toArray();

    }
    public function render(){
        $service_data = DB::table('services')
            ->paginate(10);
        return view('livewire.customer.services.services-list.services-list',[
            'service_data'=>$service_data
        ])
        ->layout('components.layouts.customer');
    }
    public function add_to_service_cart($id){
        if( DB::table('services_cart')
            ->where('customer_id','=',$this->user_id)
            ->where('service_id','=',$id)
            ->first()){
            $this->dispatch('swal:redirect',
                position         									: 'center',
                icon              									: '',
                title             									: 'Service is already added!',
                showConfirmButton 									: 'true',
                timer             									: '1000',
                link              									: '#'
            );
        }else{
            if(DB::table('services_cart')
            ->insert([
                'customer_id' =>  $this->user_id,
                'service_id' =>$id , 
           ])){
            $this->dispatch('swal:redirect',
                position         									: 'center',
                icon              									: '',
                title             									: 'Service added!',
                showConfirmButton 									: 'true',
                timer             									: '1000',
                link              									: '#'
            );
           }
        }
    }
}
