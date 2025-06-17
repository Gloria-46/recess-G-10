@extends('vendor.layouts.app')

@section('header')
    Products
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <!-- Header with Add Product Button -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" placeholder="Search products..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i> Add Product
                </button>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Sample Product Card -->
                <div class="bg-white border rounded-lg overflow-hidden">
                    <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                        <img src="https://via.placeholder.com/300" alt="Product" class="object-cover w-full h-48">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">Sample Product</h3>
                        <p class="text-gray-600 text-sm mt-1">$99.99</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                In Stock
                            </span>
                            <div class="flex gap-2">
                                <button class="p-2 text-blue-500 hover:bg-blue-50 rounded">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-2 text-red-500 hover:bg-red-50 rounded">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Product Card -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center h-64">
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-plus text-4xl mb-2"></i>
                        <p>Add New Product</p>
                    </button>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Showing 0 to 0 of 0 products
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 border rounded-lg disabled:opacity-50" disabled>Previous</button>
                    <button class="px-4 py-2 border rounded-lg disabled:opacity-50" disabled>Next</button>
                </div>
            </div>
        </div>
    </div>
@endsection 