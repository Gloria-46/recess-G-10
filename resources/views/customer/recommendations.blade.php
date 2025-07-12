@extends('layouts.customer')

@section('content')
<div class="container py-6">
    <h2 class="text-2xl font-semibold mb-6 text-blue-800 flex items-center">
        <i class="fas fa-star mr-2"></i> Your Recommended Products
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @forelse($recommendations as $product)
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col hover:shadow-xl transition-shadow">
                <div class="flex-1 flex flex-col items-center">
                    <div class="h-48 w-48 mb-3 bg-gray-100 rounded-xl overflow-hidden flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-48 w-48">
                        @else
                            <span class="inline-block h-40 w-40 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                                <svg class="h-20 w-20 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 24H0V0h24v24z" fill="none"/>
                                    <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                    <h3 class="font-bold text-lg text-blue-900 mb-1 text-center">{{ $product->name }}</h3>
                    <p class="text-gray-600 mb-2 text-center">{{ Str::limit($product->description, 60) }}</p>
                    <div class="font-bold text-blue-700 mb-2">UGX {{ number_format($product->price, 2) }}</div>
                    <div class="mb-2 text-center">
                        <span class="font-semibold text-gray-700 text-sm">Available Stock:</span>
                        <span class="inline-block bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 rounded-full px-3 py-1 text-xs font-medium border border-yellow-200 ml-2">{{ $product->current_stock }} in stock</span>
                    </div>
                </div>
                <a href="{{ route('customer.products.show', $product->id) }}" class="mt-4 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white font-bold py-3 px-6 rounded-lg text-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-star mr-2"></i>View Details
                </a>
            </div>
        @empty
            <p>No recommendations available at this time.</p>
        @endforelse
    </div>
</div>
@endsection 