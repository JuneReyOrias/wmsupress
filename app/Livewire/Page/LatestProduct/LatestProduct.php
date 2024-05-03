<?php

namespace App\Livewire\Page\LatestProduct;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class LatestProduct extends Component
{
    public function render()
    {
        return view('livewire.page.latest-product.latest-product')
        ->layout('components.layouts.page');
    }
}
