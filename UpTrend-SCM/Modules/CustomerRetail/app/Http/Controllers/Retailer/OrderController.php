<?php

namespace Modules\CustomerRetail\App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Modules\CustomerRetail\App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class OrderController extends Controller
{
    use AuthorizesRequests;

    // Removed OrderCoordinationService dependency
    public function __construct()
    {
        
        // Share pending orders count with all vendor views
        view()->composer('layouts.retailer', function ($view) {
            $pendingOrdersCount = Order::where('retailer_id', auth('retailer')->id())
                ->where('status', 'pending')
                ->count();
            $view->with('pendingOrdersCount', $pendingOrdersCount);
        });
    }

    public function index()
    {
        $orders = Order::where('retailer_id', Auth::guard('retailer')->id())
            ->with(['warehouseOrder', 'items'])
            ->latest()
            ->paginate(10);

        return view('customerretail::retailer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Get the authenticated retailer
        $retailer = Auth::guard('retailer')->user();
        
        // Debug information
        if (!$retailer) {
            abort(403, 'You must be logged in as a retailer.');
        }
        
        if (!$order) {
            abort(404, 'Order not found.');
        }
        
        // Check if the order belongs to this retailer
        if ($order->retailer_id !== $retailer->id) {
            abort(403, 'This action is unauthorized. Order does not belong to your account.');
        }
        
        
        return view('customerretail::retailer.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        // Get the authenticated retailer
        $retailer = Auth::guard('retailer')->user();
        
        // Check if the order belongs to this retailer
        if ($order->retailer_id !== $retailer->id) {
            abort(403, 'This action is unauthorized.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        // Always reduce inventory when status is set to completed
        if ($validated['status'] === 'completed') {
            $order->load('items.product'); // Reload items and their products
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->current_stock = max(0, $product->current_stock - $item->quantity);
                    $product->save();
                }
            }
        }

        return redirect()->route('retailer.orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    public function pendingCount()
    {
        $count = Order::where('retailer_id', auth('retailer')->id())
            ->where('status', 'pending')
            ->count();
        return response()->json(['count' => $count]);
    }
}
