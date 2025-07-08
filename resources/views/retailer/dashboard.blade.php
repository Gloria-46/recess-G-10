@extends('layouts.retailer')

@section('title', 'Dashboard - Retailer Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div id="dashboard-animate" class="opacity-0 translate-y-8 transition-all duration-700">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="text-center">
                <h1 class="text-4xl font-display font-bold text-gray-900 mb-4">Welcome Back!</h1>
                <p class="text-xl text-gray-600">Here's what's happening with your business today</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Total Products Card -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-box text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Total Products</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-3">
                    <a href="{{ route('retailer.products.index') }}" class="text-sm font-medium text-blue-700 hover:text-blue-800 flex items-center">
                        View all products
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Total Orders Card -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Total Orders</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-3">
                    <a href="{{ route('retailer.orders.index') }}" class="text-sm font-medium text-green-700 hover:text-green-800 flex items-center">
                        View all orders
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl flex items-center justify-center">
                                <i class="fas fa-hourglass-half text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 px-6 py-3">
                    <a href="{{ route('retailer.orders.index', ['status' => 'pending']) }}" class="text-sm font-medium text-yellow-700 hover:text-yellow-800 flex items-center">
                        View pending orders
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Total Revenue Card -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                            <p class="text-3xl font-bold text-gray-900">UGX {{ number_format($stats['total_revenue'], 0) }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-3">
                    <a href="{{ route('retailer.analytics') }}" class="text-sm font-medium text-purple-700 hover:text-purple-800 flex items-center">
                        View analytics
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-clock mr-3 text-blue-600"></i>
                        Recent Orders
                    </h3>
                    <a href="{{ route('retailer.orders.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 flex items-center">
                        View all
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-2"></i>Order #
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-user mr-2"></i>Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-money-bill mr-2"></i>Amount
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-info-circle mr-2"></i>Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2"></i>Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-cogs mr-2"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recent_orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-shopping-bag text-blue-600 text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold text-blue-600">{{ $order->order_number }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $order->customer_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    UGX {{ number_format($order->total_amount, 0) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                           'bg-gray-100 text-gray-800')) }}">
                                        <i class="fas fa-circle mr-1 text-xs"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                        {{ $order->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('retailer.orders.show', $order) }}" class="inline-flex items-center px-3 py-2 text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-eye mr-1"></i>
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No recent orders</h3>
                                        <p class="text-gray-500 mb-4">Orders will appear here once customers start placing them</p>
                                        <a href="{{ route('retailer.products.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-plus mr-2"></i>
                                            Add Products
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('dashboard-animate');
        if (el) {
            el.classList.remove('opacity-0', 'translate-y-8');
            el.classList.add('opacity-100', 'translate-y-0');
        }
    });
</script>
@endsection 