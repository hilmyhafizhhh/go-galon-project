<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                // Role admin
                if (Auth::user()->hasRole('admin')) {
                    return redirect()->route('admin.dashboard');
                }

                // Role courier
                if (Auth::user()->hasRole('courier')) {
                    return redirect()->route('courier.home');
                }

                // Role customer
                return redirect()->route('customer.home');
            }
        }

        return $next($request);
    }
}
