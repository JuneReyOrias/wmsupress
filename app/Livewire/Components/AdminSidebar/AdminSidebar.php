<?php

namespace App\Livewire\Components\AdminSidebar;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminSidebar extends Component
{
    public function render(Request $request)
    {
        $session = $request->session()->all();
        if(isset($session['id'])){
            $user_info  =  DB::table('users as u')
            ->select(
                'u.id',
                'r.name as role_name',
                )
            ->where('u.id','=',$session['id'])
            ->join('roles as r','u.role_id','r.id')
            ->first();
        }
        return view('livewire.components.admin-sidebar.admin-sidebar',[
            'user_info'=>$user_info
        ]);
    }
}
