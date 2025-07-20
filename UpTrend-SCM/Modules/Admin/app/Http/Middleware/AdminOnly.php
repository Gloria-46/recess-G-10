<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || !str_ends_with($user->email, '@admin.uptrend.com')) {
            return redirect()->route('login')->withErrors(['You are not authorized to access the admin area.']);
        }
        return $next($request);
    }
} 