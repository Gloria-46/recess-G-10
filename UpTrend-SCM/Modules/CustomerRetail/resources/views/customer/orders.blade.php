@extends('customerretail::layouts.customer')

@section('content')
    <h1 class="text-3xl font-bold mb-8 text-yellow-300">Order History</h1>
    <div class="max-w-4xl mx-auto">
        @if($orders->isEmpty())
            <div class="bg-gradient-to-r from-[#23235b] to-blue-900 rounded-xl shadow p-8 text-center text-blue-100">
                You have no orders yet.
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-6">
                <table class="min-w-full w-full text-sm text-left">
                    <thead>
                        <tr class="bg-blue-900 text-white">
                            <th class="px-4 py-3 font-semibold">Order #</th>
                            <th class="px-4 py-3 font-semibold">Date</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold">Total</th>
                            <th class="px-4 py-3 font-semibold">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="@if($loop->even) bg-blue-50 @else bg-white @endif hover:bg-blue-100 transition">
                            <td class="px-4 py-3">{{ $order->order_number }}</td>
                            <td class="px-4 py-3">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-100 text-amber-700 border border-amber-300',
                                        'completed' => 'bg-green-100 text-green-700 border border-green-300',
                                        'cancelled' => 'bg-red-100 text-red-700 border border-red-300',
                                    ];
                                    $status = strtolower($order->status);
                                @endphp
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800 border border-gray-300' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">UGX {{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('customer.orders.show', $order->id) }}"
                                   class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-2 rounded-lg transition font-semibold text-xs shadow">
                                    View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection 