@extends('layouts.vendor')

@section('title', 'Products - Vendor Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div id="products-animate" class="opacity-0 translate-y-8 transition-all duration-700">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-display font-bold text-gray-900 mb-2">Product Management</h1>
                    <p class="text-gray-600">Manage your product catalog and inventory</p>
                </div>
                <a href="{{ route('vendor.products.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 font-semibold">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Product
                </a>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" placeholder="Search products by name, category, or SKU..." 
                            class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <select class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Categories</option>
                        <option>Clothing</option>
                        <option>Accessories</option>
                        <option>Shoes</option>
                    </select>
                    <select class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Status</option>
                        <option>In Stock</option>
                        <option>Low Stock</option>
                        <option>Out of Stock</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Sample Product Cards -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden group">
                <div class="relative">
                    <div class="aspect-w-1 aspect-h-1 bg-gradient-to-br from-gray-100 to-gray-200">
                        <img src="https://via.placeholder.com/400x400/667eea/ffffff?text=Product" alt="Product" class="object-cover w-full h-48 group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                            In Stock
                        </span>
                    </div>
                    <div class="absolute top-3 left-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="flex gap-2">
                            <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-colors">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Premium Cotton T-Shirt</h3>
                    <p class="text-gray-600 text-sm mb-3">High-quality cotton t-shirt with modern design</p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-gray-900">UGX 25,000</span>
                        <span class="text-sm text-gray-500">Stock: 45</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Category: Clothing</span>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star text-sm"></i>
                            <i class="fas fa-star text-sm"></i>
                            <i class="fas fa-star text-sm"></i>
                            <i class="fas fa-star text-sm"></i>
                            <i class="far fa-star text-sm"></i>
                            <span class="text-xs text-gray-500 ml-1">(4.0)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden group">
                <div class="relative">
                    <div class="aspect-w-1 aspect-h-1 bg-gradient-to-br from-gray-100 to-gray-200">
                        <img src="https://via.placeholder.com/400x400/764ba2/ffffff?text=Product" alt="Product" class="object-cover w-full h-48 group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">
                            Low Stock
                        </span>
                    </div>
                    <div class="absolute top-3 left-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="flex gap-2">
                            <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-colors">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Denim Jeans</h3>
                    <p class="text-gray-600 text-sm mb-3">Classic denim jeans with perfect fit</p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-gray-900">UGX 45,000</span>
                        <span class="text-sm text-red-600 font-semibold">Stock: 3</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Category: Clothing</span>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star text-sm"></i>
                            <i class="fas fa-star text-sm"></i>
                            <i class="fas fa-star text-sm"></i>
                            <i class="fas fa-star text-sm"></i>
                            <i class="fas fa-star text-sm"></i>
                            <span class="text-xs text-gray-500 ml-1">(4.8)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden group">
                <div class="relative">
                    <div class="aspect-w-1 aspect-h-1 bg-gradient-to-br from-gray-100 to-gray-200">
                        <img src="https://via.placeholder.com/400x400/f093fb/ffffff?text=Product" alt="Product" class="object-cover w-full h-48 group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                            Out of Stock
                        </span>
                    </div>
                    <div class="absolute top-3 left-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="flex gap-2">
                            <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-colors">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Leather Wallet</h3>
                    <p class="text-gray-600 text-sm mb-3">Premium leather wallet with card slots</p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-gray-900">UGX 15,000</span>
                        <span class="text-sm text-red-600 font-semibold">Stock: 0</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Category: Accessories</span>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star text-sm"></i>
                            <i class="fas fa-star text-sm"></i>
                            <i class="fas fa-star text-sm"></i>
                            <i class="fas fa-star text-sm"></i>
                            <i class="far fa-star text-sm"></i>
                            <span class="text-xs text-gray-500 ml-1">(4.2)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Product Card -->
            <div class="border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center h-80 hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 group cursor-pointer">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-plus text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2 group-hover:text-blue-600 transition-colors">Add New Product</h3>
                    <p class="text-sm text-gray-500 mb-4">Create a new product listing</p>
                    <a href="{{ route('vendor.products.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                        <i class="fas fa-plus mr-2"></i>
                        Add Product
                    </a>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row items-center justify-between">
                <div class="text-sm text-gray-600 mb-4 sm:mb-0">
                    Showing <span class="font-semibold">1</span> to <span class="font-semibold">3</span> of <span class="font-semibold">3</span> products
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors" disabled>
                        <i class="fas fa-chevron-left mr-2"></i>Previous
                    </button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Next<i class="fas fa-chevron-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('products-animate');
        if (el) {
            el.classList.remove('opacity-0', 'translate-y-8');
            el.classList.add('opacity-100', 'translate-y-0');
        }
    });
</script>
@endsection 