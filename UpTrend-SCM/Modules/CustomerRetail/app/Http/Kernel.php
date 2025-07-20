<?php

namespace Modules\CustomerRetail\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Modules\CustomerRetail\Http\Middleware\Authenticate;
use Modules\CustomerRetail\Http\Middleware\RedirectIfAuthenticated;
use Modules\CustomerRetail\Http\Middleware\ValidateSignature;
use Modules\CustomerRetail\Http\Middleware\RedirectIfNotRetailer;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'retailer' => RedirectIfNotRetailer::class,
        'customer.auth' => \Modules\CustomerRetail\Http\Middleware\RedirectIfNotCustomer::class,
    ];
} 