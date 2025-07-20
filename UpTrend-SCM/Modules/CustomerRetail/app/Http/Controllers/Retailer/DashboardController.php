<?php

namespace Modules\CustomerRetail\App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CustomerRetail\App\Models\Order;
use Modules\CustomerRetail\App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // dd(Auth::guard('retailer')->check(), Auth::user(), Auth::guard('retailer')->user());
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

        return view('customerretail::retailer.dashboard', compact('stats', 'recent_orders'));
    }
}
