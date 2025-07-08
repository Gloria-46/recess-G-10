@extends('layouts.customer')

@section('content')
<!-- Floating clothing background images -->
<div class="pointer-events-none select-none fixed inset-0 z-0">
    <img src="https://img.freepik.com/free-photo/white-tshirt_1203-7554.jpg?w=400" class="absolute top-10 left-10 w-64 opacity-5 rotate-12" alt="Floating Shirt">
    <img src="https://img.freepik.com/free-photo/black-tshirt_1203-7555.jpg?w=400" class="absolute bottom-20 right-20 w-72 opacity-5 -rotate-6" alt="Floating Shirt">
    <img src="https://img.freepik.com/free-photo/blue-jeans_1203-7556.jpg?w=400" class="absolute top-1/2 left-1/4 w-56 opacity-5 -translate-y-1/2 -rotate-3" alt="Floating Jeans">
    <img src="https://img.freepik.com/free-photo/hoodie_1203-7557.jpg?w=400" class="absolute bottom-10 left-1/2 w-64 opacity-5 -translate-x-1/2 rotate-3" alt="Floating Hoodie">
</div>
@php $showSearchBar = true; @endphp
@php $lastAddedProductId = session('last_added_product_id'); @endphp
<div class="max-w-7xl mx-auto py-8 relative z-10">
    @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{!! session('success') !!}</div>
    @endif
    
    <!-- Charming Introduction Section -->
    <div class="text-center mb-12 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-3xl p-8 shadow-lg border border-blue-100">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-blue-900 to-indigo-900 bg-clip-text text-transparent">
                @if(isset($category) && $category === 'ladies')
                    ✨ Ladies' Fashion Collection ✨
                @elseif(isset($category) && $category === 'gentlemen')
                    🎩 Gentlemen's Style Collection 🎩
                @else
                    🛍️ Discover Your Perfect Style 🛍️
                @endif
            </h1>
            
            <p class="text-lg md:text-xl text-gray-700 mb-6 leading-relaxed">
                @if(isset($category) && $category === 'ladies')
                    Step into elegance with our curated ladies' collection. From casual comfort to sophisticated style, 
                    find pieces that reflect your unique personality and make you feel confident every day.
                @elseif(isset($category) && $category === 'gentlemen')
                    Elevate your wardrobe with our premium gentlemen's collection. Quality craftsmanship meets 
                    contemporary design for the modern man who values both style and substance.
                @else
                    Welcome to our fashion paradise! Explore our carefully curated collection of trendy apparel 
                    that combines comfort, style, and quality. Whether you're looking for casual wear or statement pieces, 
                    we've got something special just for you.
                @endif
            </p>
            
            <div class="flex flex-wrap justify-center gap-4 text-sm text-gray-600">
                <span class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    Premium Quality
                </span>
                <span class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    Trendy Designs
                </span>
                <span class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm">
                    <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                    Fast Delivery
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden group relative flex flex-col h-full min-h-[600px]">
                @if($product->current_stock <= 0)
                    <div class="absolute top-4 right-4 bg-gradient-to-r from-red-600 to-red-400 text-white text-xs font-bold px-4 py-1 rounded-full shadow z-20">
                        OUT OF STOCK
                    </div>
                @endif
                <div class="flex-1 p-6 pt-10 flex flex-col">
                    <div class="h-72 w-72 mx-auto flex items-center justify-center mb-4 bg-gradient-to-br from-gray-50 to-white rounded-2xl overflow-hidden border border-gray-100 group-hover:shadow-lg transition-shadow duration-300">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-72 w-72 rounded-2xl bg-white group-hover:scale-105 transition-transform duration-300">
                        @else
                            <span class="inline-block h-40 w-40 rounded-full overflow-hidden bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                <svg class="h-20 w-20 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 24H0V0h24v24z" fill="none"/>
                                    <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                    <h3 class="font-bold text-xl text-blue-900 mb-3 group-hover:text-blue-700 transition-colors duration-300">{{ $product->name }}</h3>
                    <p class="text-gray-600 mb-3 text-sm leading-relaxed">{{ Str::limit($product->description, 60) }}</p>
                    <div class="mb-3 font-bold text-2xl text-blue-700 bg-gradient-to-r from-blue-50 to-blue-100 px-3 py-2 rounded-xl">
                        PRICE: UGX {{ number_format($product->price, 2) }}
                    </div>
                    <div class="mb-3">
                        <span class="font-semibold text-gray-700 text-sm">Available Colors:</span>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach(array_filter(preg_split('/[ ,]+/', $product->color)) as $color)
                                <span class="inline-block bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 rounded-full px-3 py-1 text-xs font-medium border border-blue-200">{{ trim($color) }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700 text-sm">Available Sizes:</span>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach(array_filter(preg_split('/[ ,]+/', $product->size)) as $size)
                                <span class="inline-block bg-gradient-to-r from-green-100 to-green-200 text-green-800 rounded-full px-3 py-1 text-xs font-medium border border-green-200">{{ trim($size) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @if(session('success') && $lastAddedProductId == $product->id)
                        <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-3 shadow-sm">{!! session('success') !!}<div class="mt-2 text-blue-900 font-semibold text-sm">Want to add another color or size? Select options and add again.</div></div>
                    @endif
                    <form action="{{ route('customer.cart.add', $product->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="flex gap-3 mb-3 flex-col md:flex-row">
                            <div class="flex-1">
                                <label class="block font-semibold text-gray-700 mb-2 text-sm">Select Size</label>
                                <select name="size" required class="px-3 py-2 border border-gray-300 rounded-xl w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                    <option value="">Select Size</option>
                                    @foreach(preg_split('/[ ,]+/', $product->size) as $size)
                                        @if(trim($size) !== '')
                                            <option value="{{ trim($size) }}">{{ trim($size) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-1">
                                <label class="block font-semibold text-gray-700 mb-2 text-sm">Select Color</label>
                                <select name="color" required class="px-3 py-2 border border-gray-300 rounded-xl w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                    <option value="">Select Color</option>
                                    @foreach(preg_split('/[ ,]+/', $product->color) as $color)
                                        @if(trim($color) !== '')
                                            <option value="{{ trim($color) }}">{{ trim($color) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-xl w-full mt-3 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl" @if($product->current_stock <= 0) disabled style="opacity:0.5;cursor:not-allowed;" @endif>
                            Add to Cart
                        </button>
                    </form>
                </div>
                <a href="{{ route('customer.products.show', $product->id) }}" class="block bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 text-blue-900 font-bold py-4 px-6 text-center transition-all duration-300 border-t border-blue-200 hover:shadow-inner group-hover:bg-gradient-to-r group-hover:from-blue-100 group-hover:to-indigo-100 mt-auto">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Details / Multi-Order
                    </span>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection 