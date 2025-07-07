@extends('layouts.customer')

@section('content')
    @php $showSearchBar = true; @endphp
    <div class="max-w-5xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-blue-900">Your Cart</h1>
        @if(session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{!! session('success') !!}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif
        @if($cartItems->isEmpty())
            <div class="bg-white rounded-2xl shadow p-8 text-center text-gray-500">Your cart is empty.</div>
        @else
            <div class="overflow-x-auto mb-8">
                <table class="min-w-full w-full max-w-6xl mx-auto bg-white rounded-2xl shadow border border-gray-200">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-blue-900 font-semibold">Image</th>
                            <th class="px-6 py-3 text-left text-blue-900 font-semibold">Product</th>
                            <th class="px-6 py-3 text-right text-blue-900 font-semibold">Price</th>
                            <th class="px-6 py-3 text-left text-blue-900 font-semibold">Size</th>
                            <th class="px-6 py-3 text-left text-blue-900 font-semibold">Color</th>
                            <th class="px-6 py-3 text-center text-blue-900 font-semibold">Quantity</th>
                            <th class="px-6 py-3 text-right text-blue-900 font-semibold">Total</th>
                            <th class="px-6 py-3 text-center text-blue-900 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach($cartItems as $item)
                            @php
                                $product = $item->product;
                                $total = $product ? $product->price * $item->quantity : 0;
                                $grandTotal += $total;
                            @endphp
                            <tr class="border-b last:border-b-0">
                                <td class="px-6 py-3 align-middle">
                                    @if($product && $product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 object-cover rounded">
                                    @endif
                                </td>
                                <td class="px-6 py-3 align-middle font-semibold text-blue-900">{{ $product->name ?? 'Product not found' }}</td>
                                <td class="px-6 py-3 align-middle text-right">UGX {{ $product ? number_format($product->price, 2) : '-' }}</td>
                                <td class="px-6 py-3 align-middle">{{ $item->size ?? '-' }}</td>
                                <td class="px-6 py-3 align-middle">{{ $item->color ?? '-' }}</td>
                                <td class="px-6 py-3 align-middle text-center">
                                    <form action="{{ route('customer.cart.update', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <div class="flex items-center gap-2 justify-center">
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 px-2 py-1 border rounded">
                                            <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded">Update</button>
                                        </div>
                                    </form>
                                </td>
                                <td class="px-6 py-3 align-middle text-right">UGX {{ number_format($total, 2) }}</td>
                                <td class="px-6 py-3 align-middle text-center">
                                    <form action="{{ route('customer.cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Remove this item from cart?');">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6" class="text-right font-bold px-6 py-3 text-blue-900">Grand Total:</td>
                            <td class="font-bold px-6 py-3 text-blue-900 text-right">UGX {{ number_format($grandTotal, 2) }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Payment and Delivery Details Form -->
            <div class="bg-white rounded-2xl shadow p-6 mt-6">
                <h2 class="text-xl font-semibold mb-4 text-blue-900">Delivery & Payment Details</h2>
                <form action="{{ route('customer.cart.checkout') }}" method="POST" class="max-w-xl mx-auto">
                    @csrf
                    <div class="mb-4">
                        <label for="customer_name" class="block font-semibold text-gray-700">Your Name</label>
                        <input type="text" name="customer_name" id="customer_name" required class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="mb-4">
                        <label for="customer_email" class="block font-semibold text-gray-700">Your Email</label>
                        <input type="email" name="customer_email" id="customer_email" required class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="mb-4">
                        <label for="shipping_address" class="block font-semibold text-gray-700">Delivery Address</label>
                        <input type="text" name="shipping_address" id="shipping_address" required class="w-full border rounded px-3 py-2">
                    </div>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition w-full font-semibold">Proceed to Payment</button>
                </form>
            </div>
        @endif
    </div>
@endsection 