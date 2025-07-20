<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vendor Dashboard - Supply Chain Management</title>
      
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
      </head>
<body class="min-h-screen font-sans bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="flex items-center justify-between px-6 py-4 bg-indigo-950 text-white shadow-sm border-b">
        <div class="flex items-center gap-6 text-white">
          <div class="text-2xl font-bold ">
            <i class="fas fa-tshirt mr-2 "></i>
            UpTrend Clothing Store
          </div>
          <ul class="flex gap-8">
            <li>
              <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white font-medium text-blue-600 border-b-2 border-blue-600 pb-1">
                <i class="fas fa-chart-line"></i> DASHBOARD
            </a>
          </li>
          <li>
            <a href="{{ route('suppliers.index') }}" class="flex items-center gap-2 text-white hover:text-blue-500 transition-colors">
                <i class="fas fa-truck"></i> SUPPLIERS
            </a>
          </li>
          <li>
              <a href="{{ route('orders.index') }}" class="flex items-center gap-2 text-white hover:text-blue-500 transition-colors">
                <i class="fas fa-shopping-cart"></i> ORDERS
            </a>
          </li>
          <li>
              <a href="{{ route('materials.index') }}" class="flex items-center gap-2 text-white hover:text-blue-500 transition-colors">
                <i class="fas fa-boxes"></i> MATERIALS
            </a>
          </li>
          <li>
              <a href="{{ route('performance.index') }}" class="flex items-center gap-2 text-white hover:text-blue-500 transition-colors">
                <i class="fas fa-chart-bar"></i> PERFORMANCE
            </a>
          </li>
        </ul>
        </div>
        <div class="flex items-center gap-4">
          <div x-data="{ open: false }" class="relative text-sm text-white cursor-pointer select-none">
            <div @click="open = !open" class="flex items-center">
              <a href="{{ route('vendor.chat.index') }}">
              <i class="fas fa-comment mr-1" style="margin-right: 15px"></i> 
              </a>
              <span></span>
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
