<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>
</head>
<body>
    @extends('vendor::layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Purchase Orders Management</h1>
        <p class="text-gray-600 mb-8">View and manage all purchase orders with suppliers</p>
        
        <div class="flex justify-center space-x-4">
            <a href="{{ route('orders.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
                View All Orders
            </a>
            <a href="{{ route('orders.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
                Create New Order
            </a>
        </div>
    </div>
</div>
@endsection
</body>
</html>