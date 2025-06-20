<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $vendor = Auth::guard('vendor')->user();
        
        $stats = [
            'total_orders' => Order::where('vendor_id', $vendor->id)->count(),
            'total_products' => Product::where('vendor_id', $vendor->id)->count(),
            'total_revenue' => Order::where('vendor_id', $vendor->id)
                ->where('status', 'completed')
                ->sum('total_amount'),
            'pending_orders' => Order::where('vendor_id', $vendor->id)
                ->where('status', 'pending')
                ->count(),
        ];

        $recent_orders = Order::where('vendor_id', $vendor->id)
            ->latest()
            ->take(5)
            ->get();

        $low_stock_products = Product::where('vendor_id', $vendor->id)
            ->where('stock', '<', 10)
            ->take(5)
            ->get();

        return view('vendor.dashboard', compact('stats', 'recent_orders', 'low_stock_products'));
    }
}
