<?php

namespace Modules\CustomerRetail\App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\CustomerRetail\App\Models\Order;
use Modules\CustomerRetail\App\Models\OrderItem;
use Modules\CustomerRetail\App\Models\Product;
// use App\Models\SalesForecast; // Uncomment if you have a model

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $retailerId = Auth::guard('retailer')->id();
        $month = $request->input('month');

        $orderQuery = Order::where('retailer_id', $retailerId);
        if ($month) {
            $orderQuery = $orderQuery
                ->whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2));
        }

        // Sales over time (last 6 months, or filtered month)
        $salesData = (clone $orderQuery)
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->take(6)
            ->get();
        $salesLabels = $salesData->pluck('month');
        $salesTotals = $salesData->pluck('total');

        // Sales per month for the last 12 months (or filtered month)
        $monthlySales = (clone $orderQuery)
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->take(12)
            ->get();
        $monthlySalesLabels = $monthlySales->pluck('month');
        $monthlySalesTotals = $monthlySales->pluck('total');

        // Stock distribution (by product)
        $products = Product::where('retailer_id', $retailerId)->get();
        $stockLabels = $products->pluck('name');
        $stockData = $products->pluck('current_stock');

        // Real-time stats (filtered by month if selected)
        $totalOrders = (clone $orderQuery)->count();
        $completedOrders = (clone $orderQuery)->where('status', 'completed')->count();
        $pendingOrders = (clone $orderQuery)->where('status', 'pending')->count();
        $totalRevenue = (clone $orderQuery)->where('status', 'completed')->sum('total_amount');
        $totalProducts = $products->count();
        $totalInventory = $products->sum('current_stock');

        // Sales per product (stock sold and revenue, filtered by month if selected)
        $salesPerProduct = Product::where('retailer_id', $retailerId)
            ->with(['orderItems' => function($q) use ($month) {
                $q->whereHas('order', function($oq) use ($month) {
                    $oq->where('status', 'completed');
                    if ($month) {
                        $oq->whereYear('created_at', substr($month, 0, 4))
                           ->whereMonth('created_at', substr($month, 5, 2));
                    }
                });
            }])
            ->get()
            ->map(function($product) {
                return [
                    'name' => $product->name,
                    'sold' => $product->orderItems->sum('quantity'),
                    'revenue' => $product->orderItems->sum(function($item) { return $item->quantity * $item->price; }),
                    'stock_remaining' => $product->current_stock,
                ];
            });

        // If you have a model:
        // $forecasts = SalesForecast::orderBy('forecast_date')->get();
        // If not, use DB facade:
        $selectedProductId = $request->input('product_id');
        $products = Product::orderBy('name')->get();
        if ($selectedProductId) {
            $forecasts = DB::table('sales_forecasts')
                ->where('product_id', $selectedProductId)
                ->orderBy('forecast_date')
                ->get();
        } else {
            $forecasts = DB::table('sales_forecasts')
                ->whereNull('product_id')
                ->orWhere('product_id', '')
                ->orderBy('forecast_date')
                ->get();
        }

        return view('customerretail::retailer.analytics', [
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
            'month' => $month,
            'forecasts' => $forecasts,
            'products' => $products,
            'selected_product_id' => $selectedProductId,
        ]);
    }

    public function trends()
    {
        $retailerId = Auth::guard('retailer')->id();
        $months = [];
        $sales = [];
        $orders = [];

        // Get last 6 months (including current)
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('F');
            $year = $date->year;

            $monthOrders = \Modules\CustomerRetail\App\Models\Order::where('retailer_id', $retailerId)
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