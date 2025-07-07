@extends('layouts.vendor')

@section('content')
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div id="inventory-animate" class="opacity-0 translate-y-8 transition-all duration-700">
            
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-3xl font-display font-bold text-gray-900 mb-2">Inventory Management</h1>
                        <p class="text-gray-600">Track and manage your product inventory efficiently</p>
                    </div>
                    <a href="{{ route('vendor.inventory.addForm') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 font-semibold">
                        <i class="fas fa-plus mr-2"></i>
                        Add New Inventory
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-600"></i>
                        <span class="block sm:inline font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Low Stock Alerts -->
            @if($low_stock_inventories->count())
                <div class="mb-8 p-6 bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 rounded-xl shadow-sm">
                    <div class="flex items-center mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-red-800">Low Stock Alerts</h3>
                            <p class="text-red-700 text-sm">The following products are running low on stock</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($low_stock_inventories as $product)
                            <a href="{{ route('vendor.inventory.addForm', ['product_id' => $product->id]) }}" class="bg-white p-3 rounded-lg border border-red-200 shadow-sm hover:bg-blue-50 transition-colors cursor-pointer block">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="h-10 w-10 rounded-lg object-cover border border-gray-200">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                                    <i class="fas fa-tshirt text-white text-sm"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $product->name }}</span>
                                    </div>
                                    <span class="text-red-600 font-bold">{{ $product->current_stock ?? 0 }}</span>
                                </div>
                                <div class="text-xs text-blue-600 mt-1 flex items-center"><i class="fas fa-plus mr-1"></i> Add Inventory</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Inventory Table Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-warehouse mr-3 text-blue-600"></i>
                        Inventory Overview
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-blue-600 to-purple-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-box mr-2"></i>Product Name
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-barcode mr-2"></i>Batch No
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-calendar mr-2"></i>Date/Time Received
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-plus-circle mr-2"></i>Quantity Added
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-chart-line mr-2"></i>Current Stock
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-2"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($batches as $batch)
                            <tr class="transition-all duration-300 hover:bg-blue-50 {{ ($batch['running_stock'] ?? 0) <= 5 ? 'bg-red-50 border-l-4 border-red-500' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            @if($batch['product_image'])
                                                <img src="{{ asset('storage/' . $batch['product_image']) }}" 
                                                     alt="{{ $batch['product_name'] }}" 
                                                     class="h-12 w-12 rounded-lg object-cover border border-gray-200 cursor-pointer hover:scale-105 transition-transform"
                                                     onclick="openImageModal('{{ asset('storage/' . $batch['product_image']) }}', '{{ $batch['product_name'] }}')">
                                            @else
                                                <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                                    <i class="fas fa-tshirt text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $batch['product_name'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <details class="group">
                                        <summary class="cursor-pointer hover:text-blue-600 transition-colors text-sm font-medium text-gray-900 flex items-center">
                                            <i class="fas fa-chevron-down mr-2 group-open:rotate-180 transition-transform"></i>
                                            {{ $batch['batch_no'] }}
                                        </summary>
                                        <div class="mt-3 p-4 bg-gray-50 rounded-lg border border-gray-200 w-max max-w-sm" id="batch-details-{{ $batch['id'] }}">
                                            <div class="space-y-2 text-sm">
                                                <div class="flex items-center">
                                                    <i class="fas fa-truck text-blue-600 mr-2 w-4"></i>
                                                    <span class="font-semibold">Supplier:</span> 
                                                    <span class="ml-1 text-gray-700">{{ $batch['supplier_name'] ?? 'N/A' }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-clock text-green-600 mr-2 w-4"></i>
                                                    <span class="font-semibold">Date/Time:</span> 
                                                    <span class="ml-1 text-gray-700">{{ $batch['received_at'] ? \Carbon\Carbon::parse($batch['received_at'])->format('Y-m-d H:i') : '-' }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-boxes text-purple-600 mr-2 w-4"></i>
                                                    <span class="font-semibold">Quantity:</span> 
                                                    <span class="ml-1 text-gray-700">{{ $batch['quantity_added'] }}</span>
                                                </div>
                                            </div>
                                            <button onclick="printBatchDetails('batch-details-{{ $batch['id'] }}')" class="mt-3 w-full px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                                <i class="fas fa-print mr-2"></i>Print Details
                                            </button>
                                        </div>
                                    </details>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                        {{ $batch['received_at'] ? \Carbon\Carbon::parse($batch['received_at'])->format('Y-m-d H:i') : '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-plus mr-1"></i>
                                        {{ $batch['quantity_added'] }}
                                    </span>
                                </td>
                                @php
                                    $product = $products->where('name', $batch['product_name'])->first();
                                    $currentStock = $product ? $product->current_stock : 0;
                                @endphp
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-lg font-bold {{ $currentStock <= 5 ? 'text-red-600 animate-pulse' : 'text-gray-900' }}">
                                            {{ $currentStock }}
                                        </span>
                                        @if($currentStock <= 5)
                                            <i class="fas fa-exclamation-triangle text-red-500 ml-2"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('vendor.inventory.batch.edit', $batch['id']) }}" class="inline-flex items-center px-3 py-2 text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('vendor.inventory.batch.delete', $batch['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this batch? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-2 text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors">
                                                <i class="fas fa-trash mr-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No inventory data found</h3>
                                        <p class="text-gray-500 mb-4">Get started by adding your first inventory batch</p>
                                        <a href="{{ route('vendor.inventory.addForm') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-plus mr-2"></i>
                                            Add Inventory
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('inventory-animate');
            if (el) {
                el.classList.remove('opacity-0', 'translate-y-8');
                el.classList.add('opacity-100', 'translate-y-0');
            }
        });
    </script>
@endsection

@push('scripts')
<script>
function printBatchDetails(elementId) {
    var content = document.getElementById(elementId).innerHTML;
    var printWindow = window.open('', '', 'height=500,width=700');
    printWindow.document.write('<html><head><title>Batch Details</title>');
    printWindow.document.write('<style>body{font-family:Inter,sans-serif;padding:30px;background:#f8fafc;} .space-y-2>*+*{margin-top:0.5rem;} .flex{display:flex;} .items-center{align-items:center;} .font-semibold{font-weight:600;} .text-gray-700{color:#374151;} .w-4{width:1rem;} .mr-2{margin-right:0.5rem;} .mt-3{margin-top:0.75rem;} .px-3{padding-left:0.75rem;padding-right:0.75rem;} .py-2{padding-top:0.5rem;padding-bottom:0.5rem;} .bg-blue-600{background-color:#2563eb;} .text-white{color:#ffffff;} .rounded-lg{border-radius:0.5rem;} .text-sm{font-size:0.875rem;} .font-medium{font-weight:500;} .w-full{width:100%;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<div style="background:white;padding:20px;border-radius:10px;box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);">');
    printWindow.document.write('<h2 style="color:#1f2937;font-size:1.5rem;font-weight:700;margin-bottom:20px;border-bottom:2px solid #e5e7eb;padding-bottom:10px;">Batch Details</h2>');
    printWindow.document.write(content);
    printWindow.document.write('</div>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    setTimeout(function(){ printWindow.print(); printWindow.close(); }, 500);
}
</script>
@endpush 