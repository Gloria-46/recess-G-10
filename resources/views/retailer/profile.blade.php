@extends('layouts.retailer')

@section('title', 'Profile - Retailer Dashboard')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <div class="flex flex-col items-center mb-8">
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center mb-4 shadow-lg">
                <i class="fas fa-user text-white text-4xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $retailer->name ?? 'Retailer Name' }}</h2>
            <p class="text-gray-500">{{ $retailer->email ?? 'retailer@email.com' }}</p>
        </div>
        <form method="POST" action="{{ route('retailer.profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', $retailer->name ?? '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $retailer->email ?? '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $retailer->phone ?? '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 font-semibold">
                    <i class="fas fa-save mr-2"></i>Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 