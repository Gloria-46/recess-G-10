<?php

namespace Modules\Warehouse\App\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Warehouse\App\Models\Product;
use Modules\Warehouse\App\Models\Supplier;
use Modules\Warehouse\App\Models\Order;
use Modules\Warehouse\App\Models\OrderItem;
use Modules\Warehouse\App\Models\StockLog;
use Modules\Warehouse\App\Models\StockTransfer;

class WarehouseDashboardController extends Controller
{
    public function index()
    {
        // Products
        $totalProducts = Product::count();

        // Suppliers
        $totalSuppliers = Supplier::count();

        // Stock
        $totalStock = number_format(Product::sum('quantity'));
        $lowStock = Product::whereColumn('quantity', '<', 'reorder_level')->count();
        $activeProducts = Product::where('status', 'Active')->count();

        // Orders
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
       
        // Stock Logs
        $totalStockLogs = StockLog::count();
        $recentStockLogs = StockLog::orderBy('created_at', 'desc')->take(5)->get();

        // Transfers
        $totalTransfers = StockTransfer::count();
        // Temporary test: Set to 5 to see if card appears
        $totalTransfers = 5;
        $recentTransfers = StockTransfer::orderBy('transfer_date', 'desc')->take(5)->get();

        // Debug: Log the totalTransfers value
        \Log::info('Dashboard Data', [
            'totalTransfers' => $totalTransfers,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
        ]);

        // Top products by quantity
        $topProducts = Product::orderBy('quantity', 'desc')->take(5)->get();

        return view('warehouse::dashboard', [
            'totalProducts' => $totalProducts,
            'totalSuppliers' => $totalSuppliers,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'processingOrders' => $processingOrders,
            'deliveredOrders' => $deliveredOrders,
            'lowStock' => $lowStock,
            'activeProducts' => $activeProducts,
            'totalStock' => $totalStock,
            'totalStockLogs' => $totalStockLogs,
            'recentStockLogs' => $recentStockLogs,
            'totalTransfers' => $totalTransfers,
            'recentTransfers' => $recentTransfers,
            'topProducts' => $topProducts,
        ]);
    }
}
