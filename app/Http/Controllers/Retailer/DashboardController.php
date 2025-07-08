<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $retailer = Auth::guard('retailer')->user();
        
        $stats = [
            'total_orders' => Order::where('retailer_id', $retailer->id)->count(),
            'total_products' => Product::where('retailer_id', $retailer->id)->count(),
            'total_revenue' => Order::where('retailer_id', $retailer->id)
                ->where('status', 'completed')
                ->sum('total_amount'),
            'pending_orders' => Order::where('retailer_id', $retailer->id)
                ->where('status', 'pending')
                ->count(),
        ];

        $recent_orders = Order::where('retailer_id', $retailer->id)
            ->latest()
            ->take(5)
            ->get();

        return view('retailer.dashboard', compact('stats', 'recent_orders'));
    }
}
