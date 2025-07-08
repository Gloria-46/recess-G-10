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
        // Share low stock inventories with all views for retailer
        view()->composer('*', function ($view) {
            if (auth('retailer')->check()) {
                $retailer = auth('retailer')->user();
                $products = \App\Models\Product::where('retailer_id', $retailer->id)->get();
                $low_stock_inventories = $products->filter(function ($product) {
                    return ($product->current_stock ?? 0) <= 5;
                });
                $view->with('low_stock_inventories', $low_stock_inventories);
            }
        });

        View::composer('layouts.retailer', function ($view) {
            $pending = 0;
            if (auth('retailer')->check()) {
                $pending = \App\Models\Order::where('retailer_id', auth('retailer')->id())
                    ->where('status', 'pending')
                    ->count();
            }
            $view->with('pending_orders_count', $pending);
        });
    }
}
