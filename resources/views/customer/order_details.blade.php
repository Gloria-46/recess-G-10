@extends('layouts.customer')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('customer.orders') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Back to Orders
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
                <p class="text-gray-600">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                    @elseif($order->status === 'completed') bg-green-100 text-green-800
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Order Information</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-medium">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order Date:</span>
                        <span class="font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Status:</span>
                        <span class="font-medium 
                            @if($order->payment_status === 'paid') text-green-600
                            @elseif($order->payment_status === 'pending') text-yellow-600
                            @else text-red-600
                            @endif">
                            {{ ucfirst($order->payment_status ?? 'pending') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Amount:</span>
                        <span class="font-bold text-lg">UGX {{ number_format($order->total_amount) }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Shipping Information</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping Address:</span>
                        <span class="font-medium">{{ $order->shipping_address ?? 'Not specified' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Phone:</span>
                        <span class="font-medium">{{ $order->phone ?? 'Not specified' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Items</h2>
        
        @if($order->items->count() > 0)
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-full h-full object-cover rounded-lg">
                            @else
                                <i class="fas fa-tshirt text-gray-400 text-xl"></i>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">
                                {{ $item->product->name ?? 'Product not found' }}
                            </h4>
                            <p class="text-sm text-gray-600">
                                Size: {{ $item->size ?? 'N/A' }} | 
                                Color: {{ $item->color ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">UGX {{ number_format($item->price) }}</p>
                            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                            <p class="font-semibold text-gray-900">UGX {{ number_format($item->price * $item->quantity) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-600">
                <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                <p>No items found for this order.</p>
            </div>
        @endif
    </div>
</div>
@endsection 