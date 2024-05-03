<?php

namespace App\Livewire\Admin\Orders\Revieworders;

use Livewire\Component;

class Revieworders extends Component
{
    public function render()
    {
        return view('livewire.admin.orders.revieworders.revieworders')
        ->layout('components.layouts.admin');
    }
}
