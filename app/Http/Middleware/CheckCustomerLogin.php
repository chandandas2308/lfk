<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCustomerLogin
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
        // return $next($request);

        if (!Auth::check()) {
            if ($request->ajax()) {
            return response()->json(['error' => 'error', 'message' => 'not logged In']);
        }else{
            return redirect()->route('login-with-us1');
        }
    }
        return $next($request);
        
    }
}
