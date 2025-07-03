<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="bg-white bg-opacity-90 rounded-lg shadow-lg p-10 max-w-xl w-full text-center">
            <h1 class="font-bold text-3xl text-gray-800 mb-4">Welcome to Uptrend Warehouse System</h1>
            <h2 class="text-2xl font-semibold mb-2">Efficient Inventory & Warehouse Management</h2>
            <p class="text-gray-600 mb-6">Welcome to the Uptrend Clothing Store Warehouse System. Easily manage your inventory, track stock transfers, and generate insightful reports—all in one place.</p>
            <div class="flex flex-col gap-4 md:flex-row md:justify-center">
                <a href="/dashboard" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition">Dashboard</a>
                <a href="/inventory" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition">Inventory</a>
                <a href="/warehouse/reports" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded transition">Reports</a>
                <a href="/warehouse/transfer" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded transition">Transfer Stocks</a>
            </div>
            <div class="mt-8">
                <a href="/login" class="text-blue-600 hover:underline mr-4">Login</a>
                <a href="/register" class="text-blue-600 hover:underline">Register</a>
            </div>
        </div>
    </div>
</x-app-layout> 