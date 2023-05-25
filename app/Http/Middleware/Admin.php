<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class Admin
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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2)
        {
            return $next($request);
        }
        else if (Auth::user()->is_admin == 4)
        {
            return redirect()->route('Pos-Dashbaord');
        }
        else
        {
            return redirect()->route('Home');
        }
        
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }
        // if (Auth::user()->is_admin == 0) {
        //     return redirect()->route('Home');
        // }
        // if (Auth::user()->is_admin == 1) {
        //     return $next($request);
        // }

        // if (Auth::user()->is_admin == 2) {
        //     return redirect()->route('SA-Dashboard');
        // }


    }
}
