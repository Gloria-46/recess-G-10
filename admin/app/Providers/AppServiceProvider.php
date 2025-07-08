<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


    // public function boot()
    // {
    //     View::addNamespace('admin', base_path('admin/resources/views'));
    //     View::addNamespace('vendor', base_path('vendor/resources/views'));
    //     View::addNamespace('warehouse', base_path('warehouse/resources/views'));
    //     View::addNamespace('retailer', base_path('retailer/resources/views'));
    //     View::addNamespace('customer', base_path('customer/resources/views'));
    // }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
