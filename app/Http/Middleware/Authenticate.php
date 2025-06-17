<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('vendor') || $request->is('vendor/*')) {
                return route('vendor.login');
            }
            // return route('login'); // Commented out to prevent undefined route error
        }
    }
} 