@extends('customerretail::layouts.retailer')

@section('title', 'Analytics - Retailer Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-10">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('retailer.analytics') }}" class="mb-6 flex items-center gap-4">
            <label for="month" class="font-semibold text-blue-900">Select Month:</label>
            <input type="month" id="month" name="month" value="{{ request('month', now()->format('Y-m')) }}" class="border rounded px-3 py-2">
            <button type="submit" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded">Filter</button>
        </form>
        <div id="analytics-animate" class="opacity-0 translate-y-8 transition-all duration-700">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col items-center justify-center">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">Analytics Overview</h1>
                <p class="text-lg text-gray-500 mb-4">Key performance indicators for your business</p>
                <button class="fixed bottom-8 right-8 z-50 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full shadow-lg p-4 hover:scale-105 transition-transform flex items-center gap-2" title="Export Analytics (Coming Soon)">
                    <i class="fas fa-download"></i>
                </button>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                <!-- Card Example -->
                @php $cardClasses = 'bg-white rounded-3xl shadow-xl border border-gray-100 p-8 flex items-center hover:shadow-2xl hover:-translate-y-1 transition-all duration-300'; @endphp
                <div class="{{ $cardClasses }}">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mr-5">
                        <i class="fas fa-shopping-cart text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-500">Total Orders</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ number_format($totalOrders) }}</p>
                    </div>
                </div>
                <div class="{{ $cardClasses }}">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mr-5">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-500">Completed Orders</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ number_format($completedOrders) }}</p>
                    </div>
                </div>
                <a href="{{ route('retailer.orders.index') }}?status=pending" title="View Pending Orders" class="{{ $cardClasses }} hover:bg-yellow-50 cursor-pointer">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center mr-5">
                        <i class="fas fa-hourglass-half text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-500 flex items-center">Pending Orders <span class="ml-2 text-xs text-yellow-600">(View)</span></p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ number_format($pendingOrders) }}</p>
                    </div>
                </a>
                <div class="{{ $cardClasses }}">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mr-5">
                        <i class="fas fa-coins text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-500">Total Revenue</p>
                        <p class="text-3xl font-extrabold text-gray-900">UGX {{ number_format($totalRevenue) }}</p>
                    </div>
                </div>
                <div class="{{ $cardClasses }}">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-5">
                        <i class="fas fa-boxes text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-500">Total Products</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ number_format($totalProducts) }}</p>
                    </div>
                </div>
                <div class="{{ $cardClasses }}">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-green-400 rounded-2xl flex items-center justify-center mr-5">
                        <i class="fas fa-warehouse text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-base font-medium text-gray-500">Total Inventory</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ number_format($totalInventory) }}</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-10">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-chart-line text-blue-600"></i> Sales Per Month
                    </h3>
                    <canvas id="salesPerMonthChart" height="220"></canvas>
                </div>
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-coins text-orange-500"></i> Revenue Per Month
                    </h3>
                    <canvas id="revenuePerMonthChart" height="220"></canvas>
                </div>
            </div>

            <!-- Simple Trends Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-chart-area text-blue-600"></i> Sales Trend (Last 6 Months)
                    </h3>
                    <ul id="sales-trend-list" class="space-y-3"></ul>
                </div>
                <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-list-ol text-purple-600"></i> Orders Trend (Last 6 Months)
                    </h3>
                    <ul id="orders-trend-list" class="space-y-3"></ul>
                </div>
            </div>

            <!-- Sales Per Product Table -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <i class="fas fa-box text-green-600 mr-2"></i>
                    Sales Per Product (Stock Sold)
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full w-full text-sm text-left">
                        <thead>
                            <tr class="bg-blue-50 text-blue-900">
                                <th class="px-4 py-3 font-semibold">Product</th>
                                <th class="px-4 py-3 font-semibold">Units Sold</th>
                                <th class="px-4 py-3 font-semibold">Stock Remaining</th>
                                <th class="px-4 py-3 font-semibold">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesPerProduct as $product)
                            <tr class="@if($loop->even) bg-blue-50 @endif hover:bg-blue-100 transition">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $product['name'] }}</td>
                                <td class="px-4 py-3 font-bold text-green-700">{{ $product['sold'] }}</td>
                                <td class="px-4 py-3 font-bold text-blue-900">{{ $product['stock_remaining'] }}</td>
                                <td class="px-4 py-3 font-bold text-blue-700">
                                    UGX {{ number_format($product['revenue'], 0) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <h2 class="text-xl font-bold mt-8 mb-2">Weekly Demand Forecast (Next 12 Weeks)</h2>
            <form method="GET" action="" class="mb-4">
                <label for="product_id" class="font-semibold">Select Product:</label>
                <select name="product_id" id="product_id" class="border rounded px-2 py-1" onchange="this.form.submit()">
                    <option value="">All Products (Overall Demand)</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" @if($selected_product_id == $product->id) selected @endif>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </form>
            @if($selected_product_id)
                <h3 class="text-lg font-semibold mb-2">Forecast for: {{ $products->where('id', $selected_product_id)->first()->name ?? 'Product' }}</h3>
            @endif
            @if(isset($forecasts) && count($forecasts))
                <table class="min-w-full bg-white border mb-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Week Ending</th>
                            <th class="px-4 py-2 border">Predicted Demand</th>
                            <th class="px-4 py-2 border">Lower Bound</th>
                            <th class="px-4 py-2 border">Upper Bound</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($forecasts as $forecast)
                        <tr>
                            <td class="border px-4 py-2">{{ $forecast->forecast_date }}</td>
                            <td class="border px-4 py-2">{{ number_format($forecast->predicted_sales) }}</td>
                            <td class="border px-4 py-2">{{ number_format($forecast->lower_bound) }}</td>
                            <td class="border px-4 py-2">{{ number_format($forecast->upper_bound) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <canvas id="forecastChart" height="100"></canvas>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const forecastLabels = @json(collect($forecasts)->pluck('forecast_date'));
                    const forecastData = @json(collect($forecasts)->pluck('predicted_sales'));
                    const lowerData = @json(collect($forecasts)->pluck('lower_bound'));
                    const upperData = @json(collect($forecasts)->pluck('upper_bound'));
                    const ctx = document.getElementById('forecastChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: forecastLabels,
                            datasets: [
                                {
                                    label: 'Predicted Demand',
                                    data: forecastData,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.15)',
                                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                                    pointRadius: 4,
                                    fill: true,
                                    tension: 0.3,
                                    order: 1,
                                },
                                {
                                    label: 'Lower Bound',
                                    data: lowerData,
                                    borderColor: 'rgba(255, 99, 132, 0.5)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.08)',
                                    borderDash: [5,5],
                                    fill: '-1',
                                    pointRadius: 0,
                                    tension: 0.3,
                                    order: 2,
                                },
                                {
                                    label: 'Upper Bound',
                                    data: upperData,
                                    borderColor: 'rgba(75, 192, 192, 0.5)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.08)',
                                    borderDash: [5,5],
                                    fill: '-1',
                                    pointRadius: 0,
                                    tension: 0.3,
                                    order: 2,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'top' },
                                title: { display: true, text: 'Weekly Demand Forecast (Next 12 Weeks)' },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) label += ': ';
                                            if (context.parsed.y !== null) {
                                                label += context.parsed.y.toLocaleString('en-US') + ' units';
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            interaction: {
                                mode: 'nearest',
                                axis: 'x',
                                intersect: false
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: { display: true, text: 'Units Sold' },
                                    grid: { display: true }
                                },
                                x: {
                                    title: { display: true, text: 'Week Ending' },
                                    grid: { display: true },
                                    ticks: {
                                        callback: function(value, index, ticks) {
                                            // Format date as e.g. 'Jul 14'
                                            const date = new Date(this.getLabelForValue(value));
                                            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>
            @else
                <p>No forecast data available.</p>
            @endif
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
        fetch('/retailer/analytics/trends')
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
