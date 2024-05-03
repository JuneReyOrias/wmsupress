<?php

namespace App\Livewire\Customer\TrackOrder;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class TrackOrder extends Component
{
    public function render()
    {
        return view('livewire.customer.track-order.track-order')
        ->layout('components.layouts.customer');
    }
}
