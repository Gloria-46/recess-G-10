@extends('customerretail::layouts.customer')

@section('content')
<div class="max-w-5xl mx-auto py-10">
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl shadow-2xl p-10 flex flex-col md:flex-row gap-10 border border-blue-100 items-start">
        <!-- Product Image -->
        <div class="md:w-1/2 flex-shrink-0 flex mb-8 md:mb-0">
            @if($product->image)
                <div class="bg-white rounded-2xl shadow-lg p-4 flex items-center justify-center border border-gray-100">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-80 w-80 rounded-xl transition-transform duration-300 hover:scale-105">
                </div>
            @else
                <span class="inline-block h-60 w-60 rounded-full overflow-hidden bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                    <svg class="h-28 w-28 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 24H0V0h24v24z" fill="none"/>
                        <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                    </svg>
                </span>
            @endif
        </div>
        <!-- Product Info and Actions -->
        <div class="flex-1 min-w-0 flex flex-col justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2 text-blue-900 leading-tight">{{ $product->name }}</h1>
                <p class="text-gray-700 mb-4 text-lg">{{ $product->description }}</p>
                <div class="mb-4">
                    <span class="font-bold text-2xl text-blue-700 bg-gradient-to-r from-blue-50 to-blue-100 px-4 py-2 rounded-xl inline-block">PRICE: UGX {{ number_format($product->price, 2) }}</span>
                </div>
                <div class="mb-2">
                    <span class="font-semibold text-gray-700 text-lg">Available Stock:</span>
                    <span class="inline-block bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 rounded-full px-3 py-1 text-base font-medium border border-yellow-200 ml-2">{{ $product->current_stock }} in stock</span>
                </div>
                <div class="mb-2">
                    <span class="font-semibold text-gray-700 text-base">Available Colors:</span>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach(array_filter(preg_split('/[ ,]+/', $product->color)) as $color)
                            <span class="inline-block bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 rounded-full px-3 py-1 text-xs font-medium border border-blue-200">{{ trim($color) }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="mb-2">
                    <span class="font-semibold text-gray-700 text-base">Available Sizes:</span>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach(array_filter(preg_split('/[ ,]+/', $product->size)) as $size)
                            <span class="inline-block bg-gradient-to-r from-green-100 to-green-200 text-green-800 rounded-full px-3 py-1 text-xs font-medium border border-green-200">{{ trim($size) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 shadow-sm">{!! session('success') !!}</div>
            @endif

            <!-- Bulk Add to Cart Form (Grid Format) -->
            <form action="{{ route('customer.cart.bulkAdd', $product->id) }}" method="POST" class="mt-8">
                @csrf
                <div class="w-full max-w-3xl mx-auto mb-4 overflow-x-auto">
                    <table class="w-full table-fixed bg-white rounded-xl shadow border border-gray-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-2 py-2 text-left text-blue-900 font-semibold w-24">Size \ Color</th>
                                @php
                                    $sizes = array_filter(preg_split('/[ ,]+/', $product->size));
                                    $colors = array_filter(preg_split('/[ ,]+/', $product->color));
                                @endphp
                                @foreach($colors as $color)
                                    <th class="px-2 py-2 text-center text-blue-900 font-semibold">{{ trim($color) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sizes as $size)
                                <tr>
                                    <td class="px-2 py-2 font-semibold text-green-800">{{ trim($size) }}</td>
                                    @foreach($colors as $color)
                                        <td class="px-2 py-2 text-center">
                                            <input type="number" name="quantities[{{ trim($size) }}][{{ trim($color) }}]" min="0" value="0" class="w-16 px-1 py-1 border rounded text-center" style="max-width: 60px;">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="w-full max-w-3xl mx-auto">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-8 rounded-xl w-full mt-2 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-lg" @if($product->current_stock <= 0) disabled style="opacity:0.5;cursor:not-allowed;" @endif>
                        Add Selected to Cart
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 