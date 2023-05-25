<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class User
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
        if (Auth::user()->is_admin == 0) {
            return $next($request);
        }
        if (Auth::user()->is_admin == 1) {
            return redirect()->route('Admin-Dashboard');
        }

        if (Auth::user()->is_admin == 2) {
            return redirect()->route('SA-Dashboard');
        }
    }
}
