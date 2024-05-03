<?php

namespace App\Livewire\Page\About;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class About extends Component
{
    public function render()
    {
        return view('livewire.page.about.about')
        ->layout('components.layouts.page');
    }
}
