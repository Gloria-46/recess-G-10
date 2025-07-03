<x-app-layout>
    <x-slot name="header">
        <div class="bg-indigo-900 shadow-sm py-6 px-8 flex items-center justify-between rounded-b-lg">
            <h1 class="text-3xl font-extrabold text-white tracking-wide">Uptrend Clothing Store - Warehouse Dashboard</h1>
            <span class="text-base text-indigo-100">Logged in as {{ Auth::user()->name }}</span>
        </div>
    </x-slot>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome, {{ Auth::user()->name }}</h2>
            <p class="text-gray-700 mb-8 text-lg">Manage your inventory, track transfers, and more.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <a href="{{ route('warehouse.inventory') }}" class="bg-white border border-blue-100 hover:bg-blue-50 p-8 rounded-2xl shadow-lg transition flex flex-col items-center">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-4 mb-4">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">View Inventory</h3>
                    <p class="text-gray-600 text-base">Browse and manage all available clothing stock in the system.</p>
                </a>
                <a href="{{ route('warehouse.inventory') }}" class="bg-white border border-green-100 hover:bg-green-50 p-8 rounded-2xl shadow-lg transition flex flex-col items-center">
                    <div class="bg-green-100 text-green-600 rounded-full p-4 mb-4">
                        <i class="fas fa-exchange-alt fa-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Transfer Stock</h3>
                    <p class="text-gray-600 text-base">Move clothing stock between Uptrend branches.</p>
                </a>
                <a href="{{ route('warehouse.inventory.reports') }}" class="bg-white border border-purple-100 hover:bg-purple-50 p-8 rounded-2xl shadow-lg transition flex flex-col items-center">
                    <div class="bg-purple-100 text-purple-600 rounded-full p-4 mb-4">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">View Reports</h3>
                    <p class="text-gray-600 text-base">Monitor stock movement and transfer history.</p>
                </a>
            </div>
            <div class="mt-12 text-center text-gray-400 text-base font-medium"><p>Designed for Uptrend Clothing Store - Inventory Management System</p></div>
        </div>
    </div>
</x-app-layout>
