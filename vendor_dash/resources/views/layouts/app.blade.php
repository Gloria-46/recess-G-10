<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Supply Dashboard') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen font-sans bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="flex items-center gap-8 px-4 py-4 shadow bg-indigo-950 ">
        <div class="fas fa-tshirt mr-2 text-2xl text-white font-bold">Uptrend clothing store</div>
        <ul class="flex gap-6 text-white">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-medium text-white">
                    <span>📊</span> DASHBOARD
                </a>
            </li>
            <li>
                <a href="{{ route('suppliers.index') }}" class="flex items-center gap-2 text-white hover:text-blue-500">
                    <span>📦</span> SUPPLIERS
                </a>
            </li>
            <li>
                <a href="{{ route('orders.index') }}" class="flex items-center gap-2 text-white hover:text-blue-500">
                    <span>🛒</span> ORDERS
                </a>
            </li>
            <li>
                <a href="{{ route('materials.index') }}" class="flex items-center gap-2 text-white hover:text-blue-500">
                    <span>💳</span> MATERIALS
                </a>
            </li>
            <li>
                <a href="{{ route('performance.index')}}" class="flex items-center gap-2 text-white hover:text-blue-500">
                    <span>📈</span> PERFOMANCE
                </a>
            </li>
        </ul>

    </nav>
    <!-- Main Content -->
    <div class="p-6">
        @yield('content')
    </div>
</body>
</html>
