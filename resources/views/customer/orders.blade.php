@extends('layouts.customer')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Orders</h1>
        <p class="text-gray-600">Track your order history and status</p>
    </div>

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
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
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Amount</p>
                            <p class="text-lg font-semibold text-gray-900">UGX {{ number_format($order->total_amount) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Items</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $order->items->count() }} items</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Payment Status</p>
                            <p class="text-lg font-semibold 
                                @if($order->payment_status === 'paid') text-green-600
                                @elseif($order->payment_status === 'pending') text-yellow-600
                                @else text-red-600
                                @endif">
                                {{ ucfirst($order->payment_status ?? 'pending') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            <p><strong>Shipping Address:</strong> {{ $order->shipping_address ?? 'Not specified' }}</p>
                            <p><strong>Phone:</strong> {{ $order->phone ?? 'Not specified' }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('customer.orders.show', $order) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shopping-bag text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Orders Yet</h3>
            <p class="text-gray-600 mb-6">You haven't placed any orders yet. Start shopping to see your order history here.</p>
            <a href="{{ route('customer.products') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection 