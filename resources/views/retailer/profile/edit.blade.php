@extends('layouts.retailer')

@section('title', 'Edit Profile - Retailer Dashboard')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-display font-bold text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-user-edit mr-3 text-blue-600"></i>Edit Profile
                    </h1>
                    <p class="text-gray-600">Update your account information and business details</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Current User</p>
                        <p class="font-semibold text-gray-900">{{ $retailer->business_name ?? 'Retailer' }}</p>
                    </div>
                </div>
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

        <!-- Error Messages -->
        @if (session('error'))
            <div class="mb-8 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>
                    <span class="block sm:inline font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-8 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle mr-2 text-red-600 mt-0.5"></i>
                    <div>
                        <p class="font-medium mb-2">Please fix the following errors:</p>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Profile Form -->
        <form action="{{ route('retailer.profile.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Business Information Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-building mr-2 text-blue-600"></i>
                    Business Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Business Name</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $retailer->business_name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all duration-300"
                               placeholder="Enter your business name">
                        @error('business_name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $retailer->email) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all duration-300"
                               placeholder="your@email.com">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone', $retailer->phone) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all duration-300"
                           placeholder="+256 740 847 026">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Address Information Card -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-map-marker-alt mr-2 text-purple-600"></i>
                    Address Information
                </h3>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Business Address</label>
                    <textarea name="address" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm transition-all duration-300 resize-none"
                              placeholder="Enter your complete business address">{{ old('address', $retailer->address) }}</textarea>
                    @error('address')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Account Statistics Card -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-green-600"></i>
                    Account Overview
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-green-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-box text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Products</p>
                                <p class="text-lg font-bold text-gray-900">{{ \App\Models\Product::where('retailer_id', $retailer->id)->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Orders</p>
                                <p class="text-lg font-bold text-gray-900">{{ \App\Models\Order::where('retailer_id', $retailer->id)->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-purple-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-alt text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Member Since</p>
                                <p class="text-lg font-bold text-gray-900">{{ $retailer->created_at->format('M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('retailer.dashboard') }}" 
                   class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 font-semibold">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 font-semibold">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 