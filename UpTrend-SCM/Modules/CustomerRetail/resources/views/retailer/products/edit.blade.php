@extends('customerretail::layouts.retailer')

@section('title', 'Edit Product - Retailer Dashboard')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-display font-bold text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-edit mr-3 text-blue-600"></i>Edit Product
                    </h1>
                    <p class="text-gray-600">Update your product information with accurate details</p>
                </div>
                <a href="{{ route('retailer.products.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Products
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2 text-green-600"></i>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('retailer.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Basic Information Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Basic Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all duration-300">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price (UGX)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">UGX</span>
                            <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" 
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all duration-300">
                        </div>
                        @error('price')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                        <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all duration-300">
                            <option value="ladies" {{ old('category', $product->category) == 'ladies' ? 'selected' : '' }}>Ladies</option>
                            <option value="gentlemen" {{ old('category', $product->category) == 'gentlemen' ? 'selected' : '' }}>Gentlemen</option>
                        </select>
                        @error('category')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all duration-300 resize-none">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Product Details Card -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-tags mr-2 text-purple-600"></i>
                    Product Details
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Colors</label>
                        <input type="text" name="color" value="{{ old('color', $product->color) }}" 
                               placeholder="e.g., Red, Blue, Green"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm transition-all duration-300">
                        @error('color')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sizes</label>
                        <input type="text" name="size" value="{{ old('size', $product->size) }}" 
                               placeholder="e.g., S, M, L, XL"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm transition-all duration-300">
                        @error('size')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="is_active" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm transition-all duration-300">
                        <option value="1" {{ old('is_active', $product->is_active) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $product->is_active) ? '' : 'selected' }}>Inactive</option>
                    </select>
                    @error('is_active')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Product Image Card -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-image mr-2 text-green-600"></i>
                    Product Image
                </h3>
                
                @if($product->image)
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Current Image</label>
                        <div class="relative inline-block">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                 class="h-32 w-32 object-cover rounded-xl shadow-lg border-2 border-gray-200 cursor-pointer hover:opacity-90 transition-opacity duration-300"
                                 onclick="openImageModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}')">
                            <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-300 rounded-xl flex items-center justify-center">
                                <i class="fas fa-eye text-white opacity-0 hover:opacity-100 transition-opacity duration-300"></i>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        {{ $product->image ? 'Update Image' : 'Upload Image' }}
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-green-400 transition-colors duration-300">
                        <div class="space-y-4">
                            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-green-600 text-2xl"></i>
                            </div>
                            <div class="space-y-2">
                                <label for="image" class="cursor-pointer">
                                    <span class="text-green-600 hover:text-green-700 font-semibold transition-colors duration-300">
                                        Click to upload
                                    </span>
                                    <span class="text-gray-500"> or drag and drop</span>
                                </label>
                                <input id="image" name="image" type="file" class="hidden" accept="image/*">
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('retailer.products.index') }}" 
                   class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 font-semibold">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 font-semibold">
                    <i class="fas fa-save mr-2"></i>Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // File upload preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.className = 'h-32 w-32 object-cover rounded-xl shadow-lg border-2 border-gray-200 mt-4';
                preview.alt = 'Preview';
                
                const container = document.querySelector('.border-dashed').parentElement;
                const existingPreview = container.querySelector('img[alt="Preview"]');
                if (existingPreview) {
                    existingPreview.remove();
                }
                container.appendChild(preview);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection 