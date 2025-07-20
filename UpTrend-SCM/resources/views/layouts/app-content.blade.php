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
                <a href="{{ route('orders.index') }}"  
                class="flex items-center gap-2 text-white hover:text-blue-500">
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
        <div class="flex items-center gap-4">
            <div x-data="{ open: false }" class="relative text-sm text-white cursor-pointer select-none">
              <div @click="open = !open" class="flex items-center">
                <a href="{{ route('vendor.chat.index') }}">
                <i class="fas fa-comment mr-1" style="margin-right: 15px"></i> 
                </a>
                <i class="fas fa-user-circle mr-1"></i>
                {{ Auth::user()->name ?? 'Admin' }}
              </div>
              <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white rounded shadow-lg z-50" style="display: none;">
                <form method="POST" action="{{ route('logout') }}" class="block">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                </form>
              </div>
            </div>
          </div>
    </nav>
    <!-- Main Content -->
    <div class="p-6">
        @yield('content')
    </div>
</body>
</html>
