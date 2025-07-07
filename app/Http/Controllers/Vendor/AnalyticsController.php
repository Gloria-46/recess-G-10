<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;

class AnalyticsController extends Controller
{
    public function index()
    {
        $vendorId = Auth::guard('vendor')->id();

        // Sales over time (last 6 months)
        $salesData = Order::where('vendor_id', $vendorId)
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->take(6)
            ->get();
        $salesLabels = $salesData->pluck('month');
        $salesTotals = $salesData->pluck('total');

        // Sales per month for the last 12 months
        $monthlySales = Order::where('vendor_id', $vendorId)
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->take(12)
            ->get();
        $monthlySalesLabels = $monthlySales->pluck('month');
        $monthlySalesTotals = $monthlySales->pluck('total');

        // Stock distribution (by product)
        $products = Product::where('vendor_id', $vendorId)->get();
        $stockLabels = $products->pluck('name');
        $stockData = $products->pluck('current_stock');

        // Real-time stats
        $totalOrders = Order::where('vendor_id', $vendorId)->count();
        $completedOrders = Order::where('vendor_id', $vendorId)->where('status', 'completed')->count();
        $pendingOrders = Order::where('vendor_id', $vendorId)->where('status', 'pending')->count();
        $totalRevenue = Order::where('vendor_id', $vendorId)->where('status', 'completed')->sum('total_amount');
        $totalProducts = $products->count();
        $totalInventory = $products->sum('current_stock');

        // Sales per product (stock sold and revenue)
        $salesPerProduct = \App\Models\Product::where('vendor_id', $vendorId)
            ->with(['orderItems' => function($q) {
                $q->whereHas('order', function($oq) {
                    $oq->where('status', 'completed');
                });
            }])
            ->get()
            ->map(function($product) {
                return [
                    'name' => $product->name,
                    'sold' => $product->orderItems->sum('quantity'),
                    'revenue' => $product->orderItems->sum(function($item) { return $item->quantity * $item->price; }),
                ];
            });

        return view('vendor.analytics', [
            'salesLabels' => $salesLabels,
            'salesTotals' => $salesTotals,
            'stockLabels' => $stockLabels,
            'stockData' => $stockData,
            'monthlySalesLabels' => $monthlySalesLabels,
            'monthlySalesTotals' => $monthlySalesTotals,
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'pendingOrders' => $pendingOrders,
            'totalRevenue' => $totalRevenue,
            'totalProducts' => $totalProducts,
            'totalInventory' => $totalInventory,
            'salesPerProduct' => $salesPerProduct,
        ]);
    }

    public function trends()
    {
        $vendorId = Auth::guard('vendor')->id();
        $months = [];
        $sales = [];
        $orders = [];

        // Get last 6 months (including current)
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('F');
            $year = $date->year;

            $monthOrders = \App\Models\Order::where('vendor_id', $vendorId)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'completed')
                ->get();

            $months[] = $month;
            $sales[] = $monthOrders->sum('total_amount');
            $orders[] = $monthOrders->count();
        }

        return response()->json([
            'months' => $months,
            'sales' => $sales,
            'orders' => $orders,
        ]);
    }
} 