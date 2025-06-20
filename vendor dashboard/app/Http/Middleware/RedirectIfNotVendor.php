<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotVendor
{
    public function handle(Request $request, Closure $next, $guard = 'vendor')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('vendor.login');
        }

        return $next($request);
    }
} 