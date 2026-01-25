<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAuthentication
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
        // Allow both verified users (role_id = 1) and unverified users (role_id = 0) to access user areas
        if(auth()->user() && (auth()->user()->role_id == 1 || auth()->user()->role_id == 0)) {
            return $next($request);
        }

        return redirect('/');
    }
}
