@extends('layouts.app')

@section('title', 'All Retailer Orders')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-blue-900">All Retailer Orders</h1>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-900 uppercase tracking-wider">Order #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-900 uppercase tracking-wider">Retailer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-900 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-900 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-blue-900 uppercase tracking-wider">Total (UGX)</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-blue-800">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->retailer_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->order_date ? $order->order_date->format('M d, Y') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{
                                    $order->status === 'delivered' ? 'bg-green-100 text-green-800' :
                                    ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                    ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800'))
                                }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-semibold">{{ number_format($order->total, 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('orders.show', $order) }}" class="inline-block bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded-lg font-semibold text-sm transition">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 