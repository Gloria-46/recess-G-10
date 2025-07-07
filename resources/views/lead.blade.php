@extends('layouts.customer')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center py-16">
    <h1 class="text-4xl md:text-5xl font-extrabold text-blue-900 mb-4 text-center">Welcome to Uptrend Clothing Store</h1>
    <p class="text-lg text-gray-700 mb-10 text-center max-w-2xl">Whether you're a customer looking for the latest trends or a vendor ready to manage your inventory and sales, get started below!</p>
    <div class="flex flex-col md:flex-row gap-8 mt-6">
        <a href="{{ route('customer.home') }}" class="px-10 py-6 bg-blue-700 hover:bg-blue-900 text-white text-2xl font-bold rounded-2xl shadow-lg flex flex-col items-center transition-all duration-200">
            <i class="fas fa-shopping-bag text-4xl mb-2"></i>
            Shop as Customer
        </a>
        <a href="{{ route('vendor.login') }}" class="px-10 py-6 bg-purple-700 hover:bg-purple-900 text-white text-2xl font-bold rounded-2xl shadow-lg flex flex-col items-center transition-all duration-200">
            <i class="fas fa-store text-4xl mb-2"></i>
            Login as Vendor
        </a>
    </div>
</div>
@endsection 