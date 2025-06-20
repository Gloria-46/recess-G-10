<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vendor Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-extrabold text-blue-800 mr-8">UPTREND CLOTHING STORE LTD</span>
                    <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'text-blue-600' : 'text-gray-700' }} px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    <a href="{{ route('vendor.products.index') }}" class="{{ request()->routeIs('vendor.products.*') ? 'text-blue-600' : 'text-gray-700' }} px-3 py-2 rounded-md text-sm font-medium">Products</a>
                    <a href="{{ route('vendor.orders.index') }}" class="{{ request()->routeIs('vendor.orders.*') ? 'text-blue-600' : 'text-gray-700' }} px-3 py-2 rounded-md text-sm font-medium">Orders</a>
                    <a href="{{ route('vendor.profile.edit') }}" class="{{ request()->routeIs('vendor.profile.*') ? 'text-blue-600' : 'text-gray-700' }} px-3 py-2 rounded-md text-sm font-medium">Profile</a>
                </div>
                <form method="POST" action="{{ route('vendor.logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 px-3 py-2 rounded-md text-sm font-medium">Logout</button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html> 