<?php

namespace Modules\CustomerRetail\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotRetailer
{
    public function handle(Request $request, Closure $next, $guard = 'retailer')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('retailer.login');
        }

        return $next($request);
    }
} 