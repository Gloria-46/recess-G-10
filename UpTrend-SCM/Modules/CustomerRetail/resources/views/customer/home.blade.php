@extends('customerretail::layouts.customer')

@section('content')
@php $showSearchBar = true; @endphp

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/customer/recommendations', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization': 'Bearer ' + (localStorage.getItem('token') || '')
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('recommendations-loading').style.display = 'none';
        const lists = document.getElementById('recommendations-lists');
        const empty = document.getElementById('recommendations-empty');
        let hasAny = false;

        // Helper to render a product grid
        function renderGrid(products, title, iconClass, colorClass) {
            if (!products || products.length === 0) return '';
            hasAny = true;
            let html = `<h3 class="text-xl font-bold mb-2 mt-6 flex items-center ${colorClass}"><i class="${iconClass} mr-2"></i> ${title}</h3>`;
            html += '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-4">';
            products.forEach(product => {
                html += `
                <div class="bg-white rounded-2xl shadow p-4 flex flex-col">
                    <div class="flex-1">
                        <div class="h-72 w-72 mx-auto flex items-center justify-center mb-3 bg-white rounded-xl overflow-hidden">
                            ${product.image ? `<img src='/storage/${product.image}' alt='${product.name}' class='object-contain h-72 w-72 rounded-xl bg-white'>` : `<span class='inline-block h-40 w-40 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center'><svg class='h-20 w-20 text-gray-400' fill='currentColor' viewBox='0 0 24 24'><path d='M24 24H0V0h24v24z' fill='none'/><path d='M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z'/></svg></span>`}
                        </div>
                        <h3 class="font-bold text-lg text-blue-900 mb-2">${product.name}</h3>
                        <p class="text-gray-600 mb-2">${product.description ? product.description.substring(0, 60) : ''}</p>
                        <div class="font-bold text-blue-700">UGX ${Number(product.price).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                        <div class="mb-2">
                            <span class="font-semibold text-gray-700 text-sm">Available Stock:</span>
                            <span class="inline-block bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 rounded-full px-3 py-1 text-xs font-medium border border-yellow-200 ml-2">${product.current_stock} in stock</span>
                        </div>
                    </div>
                    <a href="/customer/products/${product.id}" class="mt-4 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white font-bold py-3 px-6 rounded-lg text-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-star mr-2"></i>View Details
                    </a>
                </div>
                `;
            });
            html += '</div>';
            return html;
        }

        let html = '';
        html += renderGrid(data.recommendations, 'Recommended For You', 'fas fa-star', 'text-yellow-700');
        if (data.favourites) {
            html += renderGrid(data.favourites.most_ordered, 'Customer Favourites: Most Ordered', 'fas fa-shopping-cart', 'text-green-700');
            html += renderGrid(data.favourites.most_viewed, 'Customer Favourites: Most Viewed', 'fas fa-eye', 'text-blue-700');
        }
        lists.innerHTML = html;
        if (!hasAny) {
            empty.classList.remove('hidden');
        }
    })
    .catch(() => {
        document.getElementById('recommendations-loading').textContent = 'Could not load recommendations.';
    });
});
</script>

@if(session('success'))
    <div class="max-w-2xl mx-auto mb-6 p-3 bg-green-100 text-green-800 rounded shadow text-center font-semibold">
        {{ session('success') }}
    </div>
@endif

{{-- Recommendations Grid --}}
@if($recommendations->count())
    <div class="container py-6">
        <h2 class="text-2xl font-semibold mb-6 text-blue-800 flex items-center">
            <i class="fas fa-star mr-2"></i> Recommended for you
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach($recommendations as $product)
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
            @endforeach
        </div>
    </div>
@endif

{{-- Remove the View Order History button --}}

<div class="max-w-7xl mx-auto py-8">
    <!-- Improved Introduction -->
    <div class="bg-gradient-to-r from-[#23235b] to-blue-900 rounded-2xl shadow-lg p-8 mb-12 flex flex-col items-center text-center relative overflow-hidden">
        <h1 class="text-5xl font-extrabold text-white mb-4 drop-shadow">Uptrend Clothing: Elevate Your Style</h1>
        <p class="text-2xl font-semibold text-yellow-300 mb-3 italic">Trendy. Comfortable. Uniquely You.</p>
        <p class="text-lg text-blue-100 max-w-2xl mb-6">
            Discover the latest in fashion for ladies and gentlemen. At <span class="font-bold text-yellow-200">Uptrend Clothing</span>, we believe everyone deserves to look and feel their best. Our curated collection features quality fabrics, inclusive sizing, and designs that fit every personality. Shop with us for a seamless, unforgettable experience and let your wardrobe speak for you!
        </p>
        <a href="{{ route('customer.products') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-[#23235b] font-bold py-3 px-8 rounded-full text-lg shadow transition duration-200">Shop Now</a>
        <div class="absolute -top-8 -right-8 opacity-10 pointer-events-none select-none hidden md:block">
            <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=300&q=80" alt="Clothing" class="w-40 h-40 object-cover rounded-full shadow-lg">
        </div>
        <div class="absolute -bottom-8 -left-8 opacity-10 pointer-events-none select-none hidden md:block">
            <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=300&q=80" alt="Clothing" class="w-40 h-40 object-cover rounded-full shadow-lg">
        </div>
    </div>
    <!-- End Improved Introduction -->

    <!-- FOR YOU: Previously Ordered Products -->
    @if(isset($previouslyOrdered) && count($previouslyOrdered) > 0)
        <div class="mb-10">
            <h2 class="text-2xl font-semibold mb-4 text-blue-900 flex items-center"><i class="fas fa-history mr-2"></i> FOR YOU</h2>
            <p class="text-blue-800 mb-6 max-w-3xl font-medium">Products you've previously ordered. Order again or explore similar items!</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($previouslyOrdered as $product)
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
                            <div class="mb-2">
                                <span class="font-semibold text-gray-700 text-sm">Available Stock:</span>
                                <span class="inline-block bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 rounded-full px-3 py-1 text-xs font-medium border border-yellow-200 ml-2">{{ $product->current_stock }} in stock</span>
                            </div>
                        </div>
                        <a href="{{ route('customer.products.show', $product->id) }}" class="mt-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-3 px-6 rounded-lg text-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-history mr-2"></i>View Details
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Most Viewed Products -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold mb-4 text-blue-900 flex items-center"><i class="fas fa-eye mr-2"></i> Most Viewed Products</h2>
        <p class="text-blue-800 mb-6 max-w-3xl font-medium">Discover what's catching everyone's eye! These trending pieces have been viewed the most by our fashion-forward community. From statement pieces to everyday essentials, these products are making waves in our store.</p>
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
                        <div class="mb-2">
                            <span class="font-semibold text-gray-700 text-sm">Available Stock:</span>
                            <span class="inline-block bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 rounded-full px-3 py-1 text-xs font-medium border border-yellow-200 ml-2">{{ $product->current_stock }} in stock</span>
                        </div>
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
                        <div class="mb-2">
                            <span class="font-semibold text-gray-700 text-sm">Available Stock:</span>
                            <span class="inline-block bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 rounded-full px-3 py-1 text-xs font-medium border border-yellow-200 ml-2">{{ $product->current_stock }} in stock</span>
                        </div>
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
                        <div class="mb-2">
                            <span class="font-semibold text-gray-700 text-sm">Available Stock:</span>
                            <span class="inline-block bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 rounded-full px-3 py-1 text-xs font-medium border border-yellow-200 ml-2">{{ $product->current_stock }} in stock</span>
                        </div>
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