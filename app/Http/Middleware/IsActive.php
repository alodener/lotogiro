<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $data = $request->all();
        $user = User::where('email', $data['email'])->first();
     
        if ($user && $user['is_active'] == 0) {
            session()->flash('erro', 'Conta Bloqueada. Favor entrar em contato com o Administrador!');
            return redirect()->route('homepage');
        }
    
        return $next($request);
     }
}

