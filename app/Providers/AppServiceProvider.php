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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share low stock inventories with all views for vendor
        view()->composer('*', function ($view) {
            if (auth('vendor')->check()) {
                $vendor = auth('vendor')->user();
                $products = \App\Models\Product::where('vendor_id', $vendor->id)->get();
                $low_stock_inventories = $products->filter(function ($product) {
                    return ($product->current_stock ?? 0) <= 5;
                });
                $view->with('low_stock_inventories', $low_stock_inventories);
            }
        });

        View::composer('layouts.vendor', function ($view) {
            $pending = 0;
            if (auth('vendor')->check()) {
                $pending = \App\Models\Order::where('vendor_id', auth('vendor')->id())
                    ->where('status', 'pending')
                    ->count();
            }
            $view->with('pending_orders_count', $pending);
        });
    }
}
