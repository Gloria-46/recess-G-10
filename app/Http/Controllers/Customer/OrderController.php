<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::guard('customer')->id())
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure the order belongs to the authenticated customer
        if ($order->user_id !== Auth::guard('customer')->id()) {
            abort(403);
        }

        return view('customer.order_details', compact('order'));
    }
} 