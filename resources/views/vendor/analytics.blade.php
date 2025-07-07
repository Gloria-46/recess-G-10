@extends('layouts.vendor')

@section('title', 'Analytics - Vendor Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div id="analytics-animate" class="opacity-0 translate-y-8 transition-all duration-700">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="text-center">
                <h1 class="text-3xl font-display font-bold text-gray-900 mb-4">Analytics Overview</h1>
                <p class="text-xl text-gray-600">Key performance indicators for your business</p>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Total Orders -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-shopping-cart text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders) }}</p>
                </div>
            </div>
            <!-- Completed Orders -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Completed Orders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($completedOrders) }}</p>
                </div>
            </div>
            <!-- Pending Orders -->
            <a href="{{ route('vendor.orders.index') }}?status=pending" title="View Pending Orders" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex items-center hover:bg-yellow-50 transition cursor-pointer">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-hourglass-half text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600 flex items-center">Pending Orders <span class="ml-2 text-xs text-yellow-600">(View)</span></p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($pendingOrders) }}</p>
                </div>
            </a>
            <!-- Total Revenue -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-coins text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">UGX {{ number_format($totalRevenue) }}</p>
                </div>
            </div>
            <!-- Total Products -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-boxes text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
                </div>
            </div>
            <!-- Total Inventory -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-green-400 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-warehouse text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Inventory</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalInventory) }}</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Sales Per Month Chart -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                    Sales Per Month
                </h3>
                <canvas id="salesPerMonthChart" height="220"></canvas>
            </div>
            <!-- Revenue Per Month Chart -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-coins mr-2 text-orange-500"></i>
                    Revenue Per Month
                </h3>
                <canvas id="revenuePerMonthChart" height="220"></canvas>
            </div>
        </div>

        <!-- Simple Trends Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <!-- Sales Trend Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-area mr-2 text-blue-600"></i>
                    Sales Trend (Last 6 Months)
                </h3>
                <ul id="sales-trend-list" class="space-y-2"></ul>
            </div>
            <!-- Orders Trend Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-list-ol mr-2 text-purple-600"></i>
                    Orders Trend (Last 6 Months)
                </h3>
                <ul id="orders-trend-list" class="space-y-2"></ul>
            </div>
        </div>

        <!-- Sales Per Product Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-10">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-box mr-2 text-green-600"></i>
                Sales Per Product (Stock Sold)
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Units Sold</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($salesPerProduct as $row)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row['name'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-700">{{ $row['sold'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-700">UGX {{ number_format($row['revenue'], 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-400">No sales data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Total Stock Per Product Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-10">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-warehouse mr-2 text-blue-600"></i>
                Total Stock Per Product
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Current Stock</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($stockLabels as $i => $name)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-700">{{ $stockData[$i] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-400">No stock data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Use real data from backend for charts
    const months = @json($monthlySalesLabels);
    const salesData = @json($monthlySalesTotals);
    const revenueData = @json($monthlySalesTotals); // For now, revenue = sales (adjust if needed)

    // Sales Per Month Chart
    const salesPerMonthCtx = document.getElementById('salesPerMonthChart').getContext('2d');
    new Chart(salesPerMonthCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Sales',
                data: salesData,
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) { return 'UGX ' + value.toLocaleString(); }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: { grid: { color: 'rgba(0,0,0,0.05)' } }
            }
        }
    });

    // Revenue Per Month Chart
    const revenuePerMonthCtx = document.getElementById('revenuePerMonthChart').getContext('2d');
    new Chart(revenuePerMonthCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue',
                data: revenueData,
                backgroundColor: 'rgba(251, 191, 36, 0.7)',
                borderColor: 'rgba(251, 191, 36, 1)',
                borderWidth: 2,
                borderRadius: 8,
                maxBarThickness: 32
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) { return 'UGX ' + value.toLocaleString(); }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: { grid: { color: 'rgba(0,0,0,0.05)' } }
            }
        }
    });

    // Real-time update for Sales and Orders Trend
    function updateTrends() {
        fetch('/vendor/analytics/trends')
            .then(res => res.json())
            .then(data => {
                // Sales
                const salesList = document.getElementById('sales-trend-list');
                salesList.innerHTML = '';
                data.months.forEach((month, i) => {
                    salesList.innerHTML += `<li class="flex justify-between text-sm"><span>${month}</span><span>UGX ${Number(data.sales[i]).toLocaleString()}</span></li>`;
                });
                // Orders
                const ordersList = document.getElementById('orders-trend-list');
                ordersList.innerHTML = '';
                data.months.forEach((month, i) => {
                    ordersList.innerHTML += `<li class="flex justify-between text-sm"><span>${month}</span><span>${data.orders[i]}</span></li>`;
                });
            });
    }
    updateTrends();
    setInterval(updateTrends, 10000);

    // Animate page in
    window.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('analytics-animate');
        if (el) {
            el.classList.remove('opacity-0', 'translate-y-8');
            el.classList.add('opacity-100', 'translate-y-0');
        }
    });
</script>
@endsection
