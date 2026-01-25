<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUser
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
        // Allow both verified users (role_id = 1) and unverified users (role_id = 0) to access user dashboard
        if (Auth::check() && (Auth::user()->role_id == 1 || Auth::user()->role_id == 0)) {
            return $next($request);
        }
        
        return redirect('/'); // Redirect to home if not a student
    }
}