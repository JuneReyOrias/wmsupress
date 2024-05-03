<?php

namespace App\Livewire\Customer\Contact;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class Contact extends Component
{
    public function render()
    {
        return view('livewire.customer.contact.contact')
        ->layout('components.layouts.customer');
    }
}
