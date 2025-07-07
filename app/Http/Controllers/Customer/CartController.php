<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::guard('customer')->user();
        $cartItems = CartItem::with('product')
            ->where('user_id', $user->id)
            ->get();
        return view('customer.cart', compact('cartItems'));
    }

    public function add(Request $request, $id)
    {
        $user = Auth::guard('customer')->user();
        if (!$user) {
            return redirect()->back()->with('error', 'Please sign up or log in to add items to your cart.');
        }
        $product = Product::findOrFail($id);
        $size = $request->input('size');
        $color = $request->input('color');
        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('size', $size)
            ->where('color', $color)
            ->first();
        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'size' => $size,
                'color' => $color,
                'quantity' => 1,
            ]);
        }
        return redirect()->back()->with('success', 'Product added to cart! <a href="' . route('customer.cart') . '" class="underline text-blue-700 ml-2">View Cart</a>');
    }

    public function update(Request $request, $cartItemId)
    {
        $user = Auth::guard('customer')->user();
        $cartItem = CartItem::where('user_id', $user->id)->where('id', $cartItemId)->firstOrFail();
        $cartItem->quantity = max(1, (int)$request->input('quantity', 1));
        $cartItem->save();
        return redirect()->route('customer.cart')->with('success', 'Cart updated!');
    }

    public function remove($cartItemId)
    {
        $user = Auth::guard('customer')->user();
        $cartItem = CartItem::where('user_id', $user->id)->where('id', $cartItemId)->first();
        if ($cartItem) {
            $cartItem->delete();
        }
        return redirect()->route('customer.cart')->with('success', 'Item removed from cart.');
    }

    public function checkout(Request $request)
    {
        $user = Auth::guard('customer')->user();
        $cartItems = \App\Models\CartItem::with('product')->where('user_id', $user->id)->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'customer_email' => 'required|email',
        ]);

        $customerName = $request->input('customer_name');
        $shippingAddress = $request->input('shipping_address');
        $customerEmail = $request->input('customer_email');

        // Group cart items by vendor
        $itemsByVendor = [];
        foreach ($cartItems as $item) {
            $product = $item->product;
            if (!$product) continue;
            $vendorId = $product->vendor_id;
            $itemsByVendor[$vendorId][] = [
                'product' => $product,
                'item' => $item,
            ];
        }

        $orders = [];
        foreach ($itemsByVendor as $vendorId => $items) {
            $total = array_sum(array_map(function($entry) {
                return $entry['product']->price * $entry['item']->quantity;
            }, $items));

            $order = \App\Models\Order::create([
                'vendor_id' => $vendorId,
                'user_id' => $user->id,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'shipping_address' => $shippingAddress,
                'order_number' => strtoupper(uniqid('ORD-')),
                'total_amount' => $total,
                'status' => 'pending',
            ]);

            foreach ($items as $entry) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $entry['product']->id,
                    'quantity' => $entry['item']->quantity,
                    'price' => $entry['product']->price,
                    'size' => $entry['item']->size ?? null,
                    'color' => $entry['item']->color ?? null,
                ]);
            }

            $orders[] = $order;
        }

        // Clear the cart
        \App\Models\CartItem::where('user_id', $user->id)->delete();

        // Redirect to payment page with the first order
        return redirect()->route('customer.payment.form', ['order_id' => $orders[0]->id])
            ->with('success', 'Order created successfully! Please complete your payment.');
    }

    public function bulkAdd(Request $request, $productId)
    {
        $user = Auth::guard('customer')->user();
        $product = \App\Models\Product::findOrFail($productId);
        $quantities = $request->input('quantities', []);
        $added = 0;
        foreach ($quantities as $size => $colorArr) {
            foreach ($colorArr as $color => $qty) {
                $qty = (int)$qty;
                if ($qty > 0) {
                    $cartItem = \App\Models\CartItem::where('user_id', $user->id)
                        ->where('product_id', $product->id)
                        ->where('size', $size)
                        ->where('color', $color)
                        ->first();
                    if ($cartItem) {
                        $cartItem->quantity += $qty;
                        $cartItem->save();
                    } else {
                        \App\Models\CartItem::create([
                            'user_id' => $user->id,
                            'product_id' => $product->id,
                            'size' => $size,
                            'color' => $color,
                            'quantity' => $qty,
                        ]);
                    }
                    $added++;
                }
            }
        }
        if ($added > 0) {
            return redirect()->back()->with('success', 'Selected items added to cart! <a href="' . route('customer.cart') . '" class="underline text-blue-700 ml-2">View Cart</a>');
        } else {
            return redirect()->back()->with('error', 'Please enter a quantity for at least one combination.');
        }
    }
} 