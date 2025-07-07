<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderItem;

class HomeController extends Controller
{
    public function index()
    {
        // Most viewed products (top 4)
        $mostViewed = Product::orderByDesc('views')->take(4)->get();

        // Most ordered products (top 4)
        $mostOrderedIds = OrderItem::selectRaw('product_id, SUM(quantity) as total_ordered')
            ->groupBy('product_id')
            ->orderByDesc('total_ordered')
            ->take(4)
            ->pluck('product_id');
        $mostOrdered = Product::whereIn('id', $mostOrderedIds)->get();

        // All products
        $products = Product::where('is_active', true)->latest()->get();

        return view('customer.home', compact('mostViewed', 'mostOrdered', 'products'));
    }
} 