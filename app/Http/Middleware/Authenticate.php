<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // If the route is for customer, always redirect to customer login and use customer guard
            if (
                ($request->route() && $request->routeIs('customer.*')) ||
                str_starts_with($request->path(), 'customer')
            ) {
                auth()->shouldUse('customer');
                return route('customer.login');
            }
            // Otherwise, fallback to vendor login and use vendor guard
            auth()->shouldUse('vendor');
            return route('vendor.login');
        }
    }
} 