@extends('customerretail::layouts.retailer')

@section('content')
<main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Inventory for: <span class="text-blue-700">{{ $product->name }}</span></h2>
        <p class="text-gray-600">All inventory batches for this product</p>
        <a href="{{ route('retailer.inventory') }}" class="inline-block mt-4 text-blue-600 hover:underline">&larr; Back to Inventory</a>
    </div>
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-blue-50 to-purple-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Batch No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Quantity Added</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Received At</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($batches as $batch)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $batch->batch_no }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-700">{{ $batch->quantity_added }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $batch->received_at ? \Carbon\Carbon::parse($batch->received_at)->format('Y-m-d H:i') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-400">No inventory batches found for this product.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection 