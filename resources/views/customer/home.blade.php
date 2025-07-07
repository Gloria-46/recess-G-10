@extends('layouts.customer')

@section('content')
@php $showSearchBar = true; @endphp

@if(session('success'))
    <div class="max-w-2xl mx-auto mb-6 p-3 bg-green-100 text-green-800 rounded shadow text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-7xl mx-auto py-8">
    <!-- Improved Introduction -->
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl shadow-lg p-8 mb-12 flex flex-col items-center text-center relative overflow-hidden">
        <h1 class="text-5xl font-extrabold text-blue-900 mb-4 drop-shadow">Uptrend Clothing: Elevate Your Style</h1>
        <p class="text-2xl font-semibold text-blue-700 mb-3 italic">Trendy. Comfortable. Uniquely You.</p>
        <p class="text-lg text-gray-700 max-w-2xl mb-6">
            Discover the latest in fashion for ladies and gentlemen. At <span class="font-bold text-blue-800">Uptrend Clothing</span>, we believe everyone deserves to look and feel their best. Our curated collection features quality fabrics, inclusive sizing, and designs that fit every personality. Shop with us for a seamless, unforgettable experience and let your wardrobe speak for you!
        </p>
        <a href="{{ route('customer.products') }}" class="inline-block bg-blue-700 hover:bg-blue-900 text-white font-bold py-3 px-8 rounded-full text-lg shadow transition duration-200">Shop Now</a>
        <div class="absolute -top-8 -right-8 opacity-10 pointer-events-none select-none hidden md:block">
            <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=300&q=80" alt="Clothing" class="w-40 h-40 object-cover rounded-full shadow-lg">
        </div>
        <div class="absolute -bottom-8 -left-8 opacity-10 pointer-events-none select-none hidden md:block">
            <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=300&q=80" alt="Clothing" class="w-40 h-40 object-cover rounded-full shadow-lg">
        </div>
    </div>
    <!-- End Improved Introduction -->

    <!-- Most Viewed Products -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold mb-4 text-blue-800 flex items-center"><i class="fas fa-eye mr-2"></i> Most Viewed Products</h2>
        <p class="text-gray-600 mb-6 max-w-3xl">Discover what's catching everyone's eye! These trending pieces have been viewed the most by our fashion-forward community. From statement pieces to everyday essentials, these products are making waves in our store.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($mostViewed as $product)
                <div class="bg-white rounded-2xl shadow p-4 flex flex-col">
                    <div class="flex-1">
                        <div class="h-72 w-72 mx-auto flex items-center justify-center mb-3 bg-white rounded-xl overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-72 w-72 rounded-xl bg-white">
                            @else
                                <span class="inline-block h-40 w-40 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                                    <svg class="h-20 w-20 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 24H0V0h24v24z" fill="none"/>
                                        <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                                    </svg>
                                </span>
                            @endif
                        </div>
                        <h3 class="font-bold text-lg text-blue-900 mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 mb-2">{{ Str::limit($product->description, 60) }}</p>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <span class="mr-2"><i class="fas fa-eye"></i> {{ $product->views }} views</span>
                        </div>
                        <div class="font-bold text-blue-700">UGX {{ number_format($product->price, 2) }}</div>
                    </div>
                    <a href="{{ route('customer.products.show', $product->id) }}" class="mt-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg text-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-eye mr-2"></i>View Details
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Most Ordered Products -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold mb-4 text-blue-800 flex items-center"><i class="fas fa-shopping-cart mr-2"></i> Most Ordered Products</h2>
        <p class="text-gray-600 mb-6 max-w-3xl">Customer favorites that fly off our shelves! These are the products our customers love and keep coming back for. Quality, style, and comfort come together in these best-selling items that have earned their popularity.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($mostOrdered as $product)
                <div class="bg-white rounded-2xl shadow p-4 flex flex-col">
                    <div class="flex-1">
                        <div class="h-72 w-72 mx-auto flex items-center justify-center mb-3 bg-white rounded-xl overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-72 w-72 rounded-xl bg-white">
                            @else
                                <span class="inline-block h-40 w-40 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                                    <svg class="h-20 w-20 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 24H0V0h24v24z" fill="none"/>
                                        <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                                    </svg>
                                </span>
                            @endif
                        </div>
                        <h3 class="font-bold text-lg text-blue-900 mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 mb-2">{{ Str::limit($product->description, 60) }}</p>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <span class="mr-2"><i class="fas fa-shopping-cart"></i> {{ $product->orders_count }} orders</span>
                        </div>
                        <div class="font-bold text-blue-700">UGX {{ number_format($product->price, 2) }}</div>
                    </div>
                    <a href="{{ route('customer.products.show', $product->id) }}" class="mt-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg text-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-shopping-cart mr-2"></i>View Details
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- All Products -->
    <div>
        <h2 class="text-2xl font-semibold mb-4 text-blue-800 flex items-center"><i class="fas fa-th-large mr-2"></i> All Products</h2>
        <p class="text-gray-600 mb-6 max-w-3xl">Explore our complete collection! From casual wear to elegant pieces, we have something for every occasion and style preference. Browse through our full range of clothing and find your perfect match.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl shadow p-4 flex flex-col">
                    <div class="flex-1">
                        <div class="h-72 w-72 mx-auto flex items-center justify-center mb-3 bg-white rounded-xl overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-72 w-72 rounded-xl bg-white">
                            @else
                                <span class="inline-block h-40 w-40 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                                    <svg class="h-20 w-20 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 24H0V0h24v24z" fill="none"/>
                                        <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                                    </svg>
                                </span>
                            @endif
                        </div>
                        <h3 class="font-bold text-lg text-blue-900 mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 mb-2">{{ Str::limit($product->description, 60) }}</p>
                        <div class="font-bold text-blue-700">UGX {{ number_format($product->price, 2) }}</div>
                    </div>
                    <a href="{{ route('customer.products.show', $product->id) }}" class="mt-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-3 px-6 rounded-lg text-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-th-large mr-2"></i>View Details
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 