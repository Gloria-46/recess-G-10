<?php

namespace Modules\Vendor\App\Http\Controllers;

use App\Http\Controllers\Controller; // This line is usually present by default

use Modules\Vendor\App\Models\Inventory;
use Modules\Vendor\App\Models\Shipment;
use Modules\Vendor\App\Models\Supplier;
use Modules\Vendor\App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
   
public function index()
{
    // Supplier-focused metrics
    $today = Carbon::today();
    $yesterday = Carbon::yesterday();
    
    // Total Suppliers
    $totalSuppliers = Supplier::count();
    $activeSuppliers = Supplier::where('status', 'active')->count();
    
    // Inventory Metrics
    $totalInventoryItems = Inventory::count();
    $lowStockItems = Inventory::where('quantity', '<=', 'reorder_point')->count();
    $outOfStockItems = Inventory::where('quantity', 0)->count();
    $totalInventoryValue = Inventory::sum(\DB::raw('quantity * unit_price'));
    
    // Shipment Metrics
    $totalShipments = Shipment::count();
    $pendingShipments = Shipment::where('status', 'pending')->count();
    $inTransitShipments = Shipment::where('status', 'in_transit')->count();
    $deliveredShipments = Shipment::where('status', 'delivered')->count();
    
    // Recent shipments
    $recentShipments = Shipment::with('supplier')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    
    // Low stock alerts
    $lowStockList = Inventory::where('quantity', '<=', 'reorder_point')
        ->with('supplier')
        ->orderBy('quantity', 'asc')
        ->take(5)
        ->get();
    
    // Top suppliers by inventory value
    $topSuppliers = Supplier::select('vendor_suppliers.id', 'vendor_suppliers.name', 'vendor_suppliers.contact_person')
        ->join('vendor_inventories', 'vendor_suppliers.id', '=', 'vendor_inventories.vendosupplier_id')
        ->selectRaw('SUM(vendor_inventories.quantity * vendor_inventories.unit_price) as total_value')
        ->groupBy('vendor_suppliers.id', 'vendor_suppliers.name', 'vendor_suppliers.contact_person')
        ->orderByDesc('total_value')
        ->take(3)
        ->get();
    
    // Inventory by category
    $inventoryByCategory = Inventory::select('category')
        ->selectRaw('COUNT(*) as item_count')
        ->selectRaw('SUM(quantity * unit_price) as total_value')
        ->groupBy('category')
        ->orderByDesc('total_value')
        ->take(5)
        ->get();

    return view('dashboard', [
        'totalSuppliers' => $totalSuppliers,
        'activeSuppliers' => $activeSuppliers,
        'totalInventoryItems' => $totalInventoryItems,
        'lowStockItems' => $lowStockItems,
        'outOfStockItems' => $outOfStockItems,
        'totalInventoryValue' => $totalInventoryValue,
        'totalShipments' => $totalShipments,
        'pendingShipments' => $pendingShipments,
        'inTransitShipments' => $inTransitShipments,
        'deliveredShipments' => $deliveredShipments,
        'recentShipments' => $recentShipments,
        'lowStockList' => $lowStockList,
        'topSuppliers' => $topSuppliers,
        'inventoryByCategory' => $inventoryByCategory,
    ]);
}

}
