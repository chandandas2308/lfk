<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! Auth::user()->is_admin == 4)
        // {
        //     return $next($request);
        // }
        if ($request->expectsJson()) {
            return route('login');
            // return $next($request);
        }
        // if($request->is()   

    }
}
