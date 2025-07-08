<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;

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
            ->latest()
            ->paginate(10);

        return view('retailer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('retailer.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        // Update payment_status based on order status
        if ($validated['status'] === 'completed') {
            $order->payment_status = 'paid';
            $order->save();
        } elseif ($validated['status'] === 'pending') {
            $order->payment_status = 'pending';
            $order->save();
        }

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
