<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <h2 class="text-2xl font-bold text-gray-800">Vendor Panel</h2>
            </div>
            <nav class="mt-4">
                <a href="{{ route('vendor.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('vendor.dashboard') ? 'bg-gray-100 border-r-4 border-blue-500' : '' }}">
                    <i class="fas fa-chart-line w-5"></i>
                    <span class="mx-4">Dashboard</span>
                </a>
                <a href="{{ route('vendor.orders') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('vendor.orders') ? 'bg-gray-100 border-r-4 border-blue-500' : '' }}">
                    <i class="fas fa-shopping-cart w-5"></i>
                    <span class="mx-4">Orders</span>
                </a>
                <a href="{{ route('vendor.products') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('vendor.products') ? 'bg-gray-100 border-r-4 border-blue-500' : '' }}">
                    <i class="fas fa-box w-5"></i>
                    <span class="mx-4">Products</span>
                </a>
                <a href="{{ route('vendor.profile') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('vendor.profile') ? 'bg-gray-100 border-r-4 border-blue-500' : '' }}">
                    <i class="fas fa-user w-5"></i>
                    <span class="mx-4">Profile</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto">
            <header class="bg-white shadow">
                <div class="px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        @yield('header')
                    </h2>
                </div>
            </header>

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html> 