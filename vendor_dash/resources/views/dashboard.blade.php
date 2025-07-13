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
<body class="font-sans bg-gray-50">
  <!-- Navigation Bar -->
  <nav class="flex items-center justify-between px-6 py-4 bg-indigo-950 text-white shadow-sm border-b">
    <div class="flex items-center gap-6 text-white">
      <div class="text-2xl font-bold ">
        <i class="fas fa-tshirt mr-2 "></i>
        uptrend clothing store
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
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">vendor Dashboard</h1>
      <p class="text-gray-600">Monitor your supply chain operations and supplier performance</p>
    </div>

    <!-- Key Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <!-- Total Suppliers -->
      <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Suppliers</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalSuppliers }}</p>
            <p class="text-sm text-green-600 mt-1">
              <i class="fas fa-arrow-up mr-1"></i>
              {{ $activeSuppliers }} Active
            </p>
          </div>
          <div class="p-3 bg-blue-100 rounded-full">
            <i class="fas fa-truck text-2xl text-blue-600"></i>
          </div>
        </div>
      </div>

      <!-- Inventory Value -->
      <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Inventory Value</p>
            <p class="text-3xl font-bold text-gray-800">UGX {{ number_format($totalInventoryValue, 2) }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $totalInventoryItems }} Items</p>
          </div>
          <div class="p-3 bg-green-100 rounded-full">
            <i class="fas fa-warehouse text-2xl text-green-600"></i>
          </div>
        </div>
      </div>

      <!-- Low Stock Alerts -->
      <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Low Stock Items</p>
            <p class="text-3xl font-bold text-red-600">{{ $lowStockItems }}</p>
            <p class="text-sm text-red-500 mt-1">{{ $outOfStockItems }} Out of Stock</p>
          </div>
          <div class="p-3 bg-red-100 rounded-full">
            <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
          </div>
        </div>
      </div>

      <!-- Shipments -->
      <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Active Shipments</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalShipments }}</p>
            <p class="text-sm text-blue-600 mt-1">{{ $inTransitShipments }} In Transit</p>
          </div>
          <div class="p-3 bg-purple-100 rounded-full">
            <i class="fas fa-shipping-fast text-2xl text-purple-600"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts and Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
      <!-- Top Suppliers -->
      <div class="bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
          <i class="fas fa-trophy mr-2 text-yellow-500"></i>
          Top Suppliers by Value
        </h3>
        <div class="space-y-4">
          @forelse($topSuppliers as $supplier)
            <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                  <i class="fas fa-building text-blue-600"></i>
                </div>
                <div>
                  <p class="font-medium text-gray-800">{{ $supplier->name }}</p>
                  <p class="text-sm text-gray-500">{{ $supplier->contact_person }}</p>
                </div>
              </div>
              <div class="text-right">
                <p class="font-semibold text-gray-800">UGX {{ number_format($supplier->total_value, 2) }}</p>
                <p class="text-xs text-gray-500">Inventory Value</p>
              </div>
            </div>
          @empty
            <p class="text-gray-500 text-center py-4">No supplier data available</p>
          @endforelse
        </div>
      </div>

      <!-- Inventory by Category -->
      <div class="bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
          <i class="fas fa-chart-pie mr-2 text-green-500"></i>
          Inventory by Category
        </h3>
        <div class="space-y-3">
          @forelse($inventoryByCategory as $category)
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-3">
                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                <span class="font-medium text-gray-700">{{ $category->category ?? 'Uncategorized' }}</span>
              </div>
              <div class="text-right">
                <p class="font-semibold text-gray-800">{{ $category->item_count }} items</p>
                <p class="text-xs text-gray-500">UGX {{ number_format($category->total_value, 2) }}</p>
              </div>
            </div>
          @empty
            <p class="text-gray-500 text-center py-4">No category data available</p>
          @endforelse
        </div>
      </div>

      <!-- Low Stock Alerts -->
      <div class="bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-semibold text-red-600 mb-4 flex items-center">
          <i class="fas fa-exclamation-circle mr-2"></i>
          Low Stock Alerts
        </h3>
        <div class="space-y-3">
          @forelse($lowStockList as $item)
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
              <div>
                <p class="font-medium text-gray-800">{{ $item->name }}</p>
                <p class="text-sm text-gray-500">{{ $item->supplier->name ?? 'Unknown Supplier' }}</p>
              </div>
              <div class="text-right">
                <p class="font-semibold text-red-600">{{ $item->quantity }} left</p>
                <p class="text-xs text-gray-500">Reorder: {{ $item->reorder_quantity }}</p>
              </div>
            </div>
          @empty
            <p class="text-green-600 text-center py-4">
              <i class="fas fa-check-circle mr-1"></i>
              All items well stocked
            </p>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Recent Shipments Table -->
    <div class="bg-white rounded-xl shadow-sm border">
      <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
          <i class="fas fa-shipping-fast mr-2 text-blue-500"></i>
          Recent Shipments
        </h3>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking #</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carrier</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Est. Delivery</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse($recentShipments as $shipment)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {{ $shipment->tracking_number ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ $shipment->supplier->name ?? 'Unknown' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $shipment->carrier ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  @php
                    $statusColors = [
                      'pending' => 'bg-yellow-100 text-yellow-800',
                      'in_transit' => 'bg-blue-100 text-blue-800',
                      'delivered' => 'bg-green-100 text-green-800',
                      'cancelled' => 'bg-red-100 text-red-800'
                    ];
                    $statusColor = $statusColors[$shipment->status] ?? 'bg-gray-100 text-gray-800';
                  @endphp
                  <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                    {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $shipment->estimated_delivery ? $shipment->estimated_delivery->format('M d, Y') : 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  UGX {{ number_format($shipment->shipping_cost ?? 0, 2) }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                  <i class="fas fa-inbox mr-2"></i>
                  No recent shipments
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>

