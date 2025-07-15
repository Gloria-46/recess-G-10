<x-app-layout>
    <x-slot name="header">
        <div class="bg-blue-900 shadow-sm py-8 px-8 flex items-center justify-between rounded-b-lg">
            <h1 class="text-4xl font-extrabold text-white tracking-wide">Warehouse Reports & Analytics</h1>
            <div class="text-white text-sm">
                <span>Last updated: {{ now()->format('M j, Y g:i A') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Summary Cards -->
            <div class="summary-cards-container">
                <div class="summary-card blue-card">
                    <div class="card-content">
                        <div class="card-text">
                            <p class="card-label">Total Products</p>
                            <p class="card-number">{{ number_format($totalProducts) }}</p>
                        </div>
                        <div class="card-icon blue-icon">
                            <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="summary-card green-card">
                    <div class="card-content">
                        <div class="card-text">
                            <p class="card-label">Active Products</p>
                            <p class="card-number">{{ number_format($activeProducts) }}</p>
                        </div>
                        <div class="card-icon green-icon">
                            <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="summary-card yellow-card">
                    <div class="card-content">
                        <div class="card-text">
                            <p class="card-label">Total Stock Units</p>
                            <p class="card-number">{{ number_format($totalStockUnits) }}</p>
                        </div>
                        <div class="card-icon yellow-icon">
                            <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="summary-card purple-card">
                    <div class="card-content">
                        <div class="card-text">
                            <p class="card-label">Stock Value</p>
                            <p class="card-number">UGX{{ number_format($totalStockValue, 0) }}</p>
                        </div>
                        <div class="card-icon purple-icon">
                            <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Grid -->
            <div class="reports-grid">
                
                <!-- Reorder Report -->
                <div class="report-card">
                    <div class="card-header">
                        <h2 class="card-title">Reorder Alerts</h2>
                        <span class="alert-badge">
                            {{ $reorderProducts->count() }} items
                        </span>
                    </div>
                    
                    @if($reorderProducts->isEmpty())
                        <div class="empty-state">
                            <svg class="empty-icon success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="empty-text success">All products are above their reorder levels!</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reorder Level</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reorderProducts as $product)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->category }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->reorder_level }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Critical Stock Report -->
                <div class="report-card">
                    <div class="card-header">
                        <h2 class="card-title">Critical Stock</h2>
                        <span class="warning-badge">
                            {{ $criticalStock->count() }} items
                        </span>
                    </div>
                    
                    @if($criticalStock->isEmpty())
                        <div class="empty-state">
                            <svg class="empty-icon success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="empty-text success">No critical stock levels!</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($criticalStock as $product)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                    Critical
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Category Analysis -->
                <div class="report-card">
                    <h2 class="card-title">Category Analysis</h2>
                    
                    @if($categoryStats->isEmpty())
                        <div class="empty-state">
                            <p class="empty-text">No category data available</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($categoryStats as $category)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $category->category }}</h3>
                                        <p class="text-sm text-gray-500">{{ $category->count }} products</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">{{ number_format($category->total_quantity) }} units</p>
                                        <p class="text-sm text-gray-500">Avg: UGX{{ number_format($category->avg_price, 0) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Top Products -->
                <div class="report-card">
                    <h2 class="card-title">Top Products by Quantity</h2>
                    
                    @if($topProducts->isEmpty())
                        <div class="empty-state">
                            <p class="empty-text">No product data available</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($topProducts as $index => $product)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full mr-3">
                                            #{{ $index + 1 }}
                                        </span>
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $product->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $product->category }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">{{ number_format($product->quantity) }} units</p>
                                        <p class="text-sm text-gray-500">UGX{{ number_format($product->price, 0) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Recent Transfers -->
                <div class="report-card wide-card">
                    <h2 class="card-title">Recent Stock Transfers</h2>
                    
                    @if($recentTransfers->isEmpty())
                        <div class="empty-state">
                            <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            <p class="empty-text">No recent transfers</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">To Branch</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentTransfers as $transfer)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $transfer->product->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transfer->to_branch }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transfer->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $transfer->created_at->format('M j, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                    Completed
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Monthly Stock Movement Chart -->
            @if($monthlyTransfers->isNotEmpty())
            <div class="monthly-movement-card">
                <h2 class="card-title">Monthly Stock Movement (Last 6 Months)</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($monthlyTransfers as $transfer)
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">
                                {{ \Carbon\Carbon::createFromDate($transfer->year, $transfer->month, 1)->format('M Y') }}
                            </p>
                            <p class="text-2xl font-bold text-blue-600">{{ number_format($transfer->total_transferred) }}</p>
                            <p class="text-xs text-gray-500">units transferred</p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

    <style>
        /* Summary Cards */
        .summary-cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            flex: 1;
            min-width: 200px;
            border-left: 4px solid;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .blue-card { border-left-color: #3b82f6; }
        .green-card { border-left-color: #10b981; }
        .yellow-card { border-left-color: #f59e0b; }
        .purple-card { border-left-color: #8b5cf6; }

        .card-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: #6b7280;
            margin: 0;
        }

        .card-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #111827;
            margin: 0;
        }

        .card-icon {
            padding: 0.5rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .blue-icon { background: #dbeafe; }
        .green-icon { background: #d1fae5; }
        .yellow-icon { background: #fef3c7; }
        .purple-icon { background: #e9d5ff; }

        .small-icon {
            width: 1rem;
            height: 1rem;
            color: inherit;
        }

        /* Reports Grid */
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .report-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .report-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .wide-card {
            grid-column: span 2;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: bold;
            color: #111827;
            margin: 0 0 1rem 0;
        }

        .alert-badge {
            background: #fee2e2;
            color: #dc2626;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
        }

        .warning-badge {
            background: #fed7aa;
            color: #ea580c;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
        }

        /* Empty States */
        .empty-state {
            text-align: center;
            padding: 1.5rem;
        }

        .empty-icon {
            width: 2rem;
            height: 2rem;
            margin: 0 auto 0.75rem;
            color: #9ca3af;
        }

        .empty-icon.success {
            color: #10b981;
        }

        .empty-text {
            color: #6b7280;
            font-size: 0.875rem;
            margin: 0;
        }

        .empty-text.success {
            color: #10b981;
            font-weight: 500;
        }

        /* Monthly Movement */
        .monthly-movement-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            margin-top: 1.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .summary-cards-container {
                flex-direction: column;
            }
            
            .reports-grid {
                grid-template-columns: 1fr;
            }
            
            .wide-card {
                grid-column: span 1;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .reports-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1025px) {
            .reports-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1280px) {
            .reports-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>
</x-app-layout>