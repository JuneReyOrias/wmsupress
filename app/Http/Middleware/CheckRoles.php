<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = $request->session()->all();
        if(isset($data['id'])){
            if($roles =  DB::table('users as u')
            ->select(
                'u.id',
                'r.name as role_name',
                )
            ->where('u.id','=',$data['id'])
            ->join('roles as r','u.role_id','r.id')
            ->first()){
                if($roles->role_name == 'admin' ){
                    return redirect('/admin/dashboard');
                }elseif( $roles->role_name == 'admin-staff' ){
                    return redirect('/staff/dashboard');
                }elseif( $roles->role_name == 'customer' ){
                    return redirect('/customer/dashboard');
                }
            }
        }
        return $next($request);
    }
}
