<?php

namespace App\Livewire\Page\Services;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Services extends Component
{
    public function render()
    {
        return view('livewire.page.services.services')
        ->layout('components.layouts.page');
    }
}
