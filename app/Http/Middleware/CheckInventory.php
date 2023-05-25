<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckInventory
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
        $user = User::where('id', Auth::user()->id)->first();
        $assigned = explode(",", $user->assigned_modules);
        if (in_array("inventory", $assigned)|| $user->is_admin==2) {
            return $next($request);
        } else {
            return redirect()->route('SA-Dashboard')->with("error", "You don't have access to this module, Please Contact your Administrator!");
        }
    }
}
