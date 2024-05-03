<?php

namespace App\Livewire\Authentication;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Login extends Component
{
    public $user = [
        'email' => NULL,
        'error'=> NULL,
        'password' =>NULL,
    ];
    public function render()
    {
        return view('livewire.authentication.login')
        ->layout('components.layouts.guest');
    }

    public function login(Request $request){
        $data = $request->session()->all();
        if(!isset($data['id'])){ 
            $user_details = DB::table('users as u')
                ->select(
                    'u.id',
                    'u.password',
                    'u.email',
                    'r.name',
                    )
                ->where('u.email','=',$this->user['email'])
                ->join('roles as r','u.role_id','r.id')
                ->first();
            if( $user_details && password_verify($this->user['password'],$user_details->password)){
                $request->session()->regenerate();
                $request->session()->put('id', $user_details->id);
                
                return redirect('/admin/dashboard');
            }else{
                $this->user['error'] = 'Invalid credentials';
            }
        }else{
            return redirect('/admin/dashboard');
        }
    }
}
