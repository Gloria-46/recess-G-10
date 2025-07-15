<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderReceivedMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems')->latest()->paginate(10);
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
        ];
        
        return view('warehouse.orders.index', compact('orders', 'stats'));
    }

    public function create()
    {
        $products = Product::where('status', 'Active')->get();
        return view('warehouse.orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $isDraft = $request->input('action') === 'draft';
        
        $validationRules = [
            'retailer_name' => 'required|string|max:255',
            'retailer_email' => 'required|email',
            'retailer_phone' => 'required|string|max:20',
            'retailer_address' => 'required|string',
            'retailer_city' => 'required|string|max:100',
            'retailer_state' => 'required|string|max:100',
            'retailer_zip' => 'required|string|max:20',
            'shipping_method' => 'required|string|max:100',
            'notes' => 'nullable|string',
        ];
        
        // If not a draft, add additional validation
        if (!$isDraft) {
            $validationRules['expected_delivery'] = 'required|date|after:today';
            $validationRules['items'] = 'required|array|min:1';
            $validationRules['items.*.product_id'] = 'required|exists:products,product_id';
            $validationRules['items.*.quantity'] = 'required|integer|min:1';
        }
        
        $request->validate($validationRules);

        try {
            DB::beginTransaction();

            // Create order
            $orderData = [
                'order_number' => Order::generateOrderNumber(),
                'retailer_name' => $request->retailer_name,
                'retailer_email' => $request->retailer_email,
                'retailer_phone' => $request->retailer_phone,
                'retailer_address' => $request->retailer_address,
                'retailer_city' => $request->retailer_city,
                'retailer_state' => $request->retailer_state,
                'retailer_zip' => $request->retailer_zip,
                'status' => $isDraft ? 'draft' : 'pending',
                'order_date' => now(),
                'shipping_method' => $request->shipping_method,
                'notes' => $request->notes,
            ];
            
            // Add expected delivery only if not a draft
            if (!$isDraft) {
                $orderData['expected_delivery'] = $request->expected_delivery;
            }
            
            $order = Order::create($orderData);

            $subtotal = 0;

            // Create order items (only for non-draft orders)
            if (!$isDraft && $request->has('items')) {
                foreach ($request->items as $item) {
                    $product = Product::find($item['product_id']);
                    
                    if ($product->quantity < $item['quantity']) {
                        throw new \Exception("Insufficient stock for {$product->name}. Available: {$product->quantity}");
                    }

                    $unitPrice = $product->price ?? 0;
                    $totalPrice = $unitPrice * $item['quantity'];
                    $subtotal += $totalPrice;

                    OrderItem::create([
                        'order_id' => $order->order_id,
                        'product_id' => $product->product_id,
                        'product_name' => $product->name,
                        'product_description' => $product->description,
                        'quantity' => $item['quantity'],
                        'unit_price' => $unitPrice,
                        'total_price' => $totalPrice,
                        'product_category' => $product->category,
                        'product_color' => $item['color'] ?? null,
                        'product_size' => $item['size'] ?? null,
                    ]);

                    // Update product stock
                    $product->decrement('quantity', $item['quantity']);
                }
            }

            // Calculate totals
            $tax = $subtotal * 0.15; // 15% tax
            $shipping = 50.00; // Fixed shipping cost
            $total = $subtotal + $tax + $shipping;

            $order->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
            ]);

            DB::commit();

            // After order is created and before redirect, send email if not draft
            if (!$isDraft) {
                Mail::to($order->retailer_email)->send(new OrderReceivedMail($order->fresh('orderItems')));
            }

            $message = $isDraft ? 'Order draft saved successfully!' : 'Order created successfully!';
            return redirect()->route('orders.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating order: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Order $order)
    {
        $order->load('orderItems.product');
        return view('warehouse.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $products = Product::where('status', 'Active')->get();
        $order->load('orderItems');
        return view('warehouse.orders.edit', compact('order', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:100',
            'actual_delivery' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $order->update($request->only(['status', 'tracking_number', 'actual_delivery', 'notes']));

        return redirect()->route('orders.show', $order)->with('success', 'Order updated successfully!');
    }

    public function destroy(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        try {
            DB::beginTransaction();

            // Restore product stock
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('quantity', $item->quantity);
                }
            }

            // Delete order items and order
            $order->orderItems()->delete();
            $order->delete();

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Order cancelled successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error cancelling order: ' . $e->getMessage());
        }
    }

    public function processOrder(Order $order)
    {
        if ($order->status === 'pending') {
            $order->update(['status' => 'confirmed']);
            return back()->with('success', 'Order confirmed successfully!');
        }

        return back()->with('error', 'Order cannot be processed in its current status.');
    }

    public function shipOrder(Order $order)
    {
        if ($order->status === 'confirmed' || $order->status === 'processing') {
            $order->update(['status' => 'shipped']);
            return back()->with('success', 'Order marked as shipped!');
        }

        return back()->with('error', 'Order cannot be shipped in its current status.');
    }

    public function deliverOrder(Order $order)
    {
        if ($order->status === 'shipped') {
            $order->update([
                'status' => 'delivered',
                'actual_delivery' => now(),
            ]);
            return back()->with('success', 'Order marked as delivered!');
        }

        return back()->with('error', 'Order cannot be delivered in its current status.');
    }

    public function retailers()
    {
        $orders = \App\Models\Order::orderByDesc('created_at')->get();
        return view('warehouse.orders.retailers', compact('orders'));
    }

    public function myRetailerOrders()
    {
        $orders = \App\Models\Order::where('staff_id', auth()->id())->orderByDesc('created_at')->get();
        return view('warehouse.orders.my_retailer_orders', compact('orders'));
    }
}
