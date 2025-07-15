<x-app-layout>
    <!-- Modern Dashboard Layout -->
    <div class="modern-dashboard">
        <!-- Modern Header -->
        <div class="modern-card modern-mb-8">
            <div class="modern-card-header">
                <div class="modern-flex justify-between items-center">
                    <div>
                        <h1 class="modern-stats-number" style="color: white; margin-bottom: 0.5rem;">Warehouse Management System</h1>
                        <p style="color: rgba(255, 255, 255, 0.9); font-size: 1.1rem;">
                            Welcome back, {{ Auth::user()->name }}. Here's your warehouse overview for {{ now()->format('l, F j, Y') }}
                        </p>
                    </div>

        <!-- Main Content -->
        <div class="relative z-10">
            <!-- Professional Header -->
            <div class="pt-6 pb-8 px-6 border-b border-white/10">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="mb-6 lg:mb-0">
                            <h1 class="text-3xl lg:text-4xl font-bold text-white mb-2">
                                Warehouse Management System
                            </h1>
                            <p class="text-lg text-blue-100">
                                Welcome back, {{ Auth::user()->name }}. Here's your warehouse overview for {{ now()->format('l, F j, Y') }}
                            </p>
                        </div>
                        
                        <!-- Profile Card -->
                        @php
                        $profileLinks = [
                            [
                                'label' => 'Profile',
                                'icon' => 'user',
                                'route' => route('profile.edit'),
                                'color' => 'blue',
                            ],
                            [
                                'label' => 'Logout',
                                'icon' => 'logout',
                                'route' => route('logout'),
                                'color' => 'red',
                                'isForm' => true,
                            ],
                        ];
                        @endphp
                        <div class="flex items-center space-x-4">
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 flex items-center space-x-3 border border-white/20">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="text-white">
                                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-sm text-blue-200">Warehouse Manager</div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                @foreach($profileLinks as $link)
                                    @if(!empty($link['isForm']))
                                        <form method="POST" action="{{ $link['route'] }}" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 rounded-lg bg-red-500/20 text-red-200 hover:bg-red-500/30 transition-all duration-200">
                                                <svg class="dashboard-icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ $link['route'] }}" class="p-2 rounded-lg bg-blue-500/20 text-blue-200 hover:bg-blue-500/30 transition-all duration-200">
                                            <svg class="dashboard-icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Performance Indicators (KPI Cards) -->
            <div class="modern-container">
                <div class="modern-mb-8">
                    <h2 class="modern-stats-number modern-mb-6" style="color: var(--gray-800);">Key Performance Indicators</h2>
                    <div class="modern-grid modern-grid-4">
                            <!-- Total Products KPI -->
                            <div class="modern-stats-card">
                                <div class="modern-flex justify-between items-center modern-mb-4">
                                    <div style="background: var(--primary-blue); padding: 0.75rem; border-radius: var(--radius-md);">
                                        <svg class="dashboard-icon-sm" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div style="text-align: right;">
                                        <div class="modern-stats-number">{{ \App\Models\Product::count() }}</div>
                                        <div class="modern-stats-label">Total Products</div>
                                    </div>
                                </div>
                                <div class="modern-mb-3">
                                    <h3 style="color: var(--gray-800); font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">Product Catalog</h3>
                                    <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.4;">Complete inventory of all products in the warehouse system</p>
                                </div>
                                <div class="modern-flex justify-between items-center">
                                    <span style="color: var(--gray-600); font-size: 0.875rem;">View all products</span>
                                    <a href="{{ route('products.index') }}" class="modern-btn modern-btn-primary modern-btn-sm">
                                        View Catalog
                                    </a>
                                </div>
                            </div>

                            <!-- Total Stock Units KPI -->
                            <div class="modern-stats-card success">
                                <div class="modern-flex justify-between items-center modern-mb-4">
                                    <div style="background: var(--primary-green); padding: 0.75rem; border-radius: var(--radius-md);">
                                        <svg class="dashboard-icon-sm" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                    <div style="text-align: right;">
                                        <div class="modern-stats-number">{{ number_format(\App\Models\Product::sum('quantity')) }}</div>
                                        <div class="modern-stats-label">Stock Units</div>
                                    </div>
                                </div>
                                <div class="modern-mb-3">
                                    <h3 style="color: var(--gray-800); font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">Inventory Management</h3>
                                    <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.4;">Monitor stock levels, add inventory, and manage warehouse operations</p>
                                </div>
                                <div class="modern-flex justify-between items-center">
                                    <span style="color: var(--gray-600); font-size: 0.875rem;">Manage inventory</span>
                                    <a href="{{ route('warehouse.inventory') }}" class="modern-btn modern-btn-success modern-btn-sm">
                                        View Inventory
                                    </a>
                                </div>
                            </div>

                            <!-- Low Stock Alerts KPI -->
                            <div class="modern-stats-card warning">
                                <div class="modern-flex justify-between items-center modern-mb-4">
                                    <div style="background: var(--warning); padding: 0.75rem; border-radius: var(--radius-md);">
                                        <svg class="dashboard-icon-sm" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                    </div>
                                    <div style="text-align: right;">
                                        <div class="modern-stats-number">{{ \App\Models\Product::whereColumn('quantity', '<', 'reorder_level')->count() }}</div>
                                        <div class="modern-stats-label">Low Stock</div>
                                    </div>
                                </div>
                                <div class="modern-mb-3">
                                    <h3 style="color: var(--gray-800); font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">Stock Alerts</h3>
                                    <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.4;">Products that need reordering to maintain optimal stock levels</p>
                                </div>
                                <div class="modern-flex justify-between items-center">
                                    <span style="color: var(--gray-600); font-size: 0.875rem;">Review alerts</span>
                                    <a href="{{ route('alerts') }}" class="modern-btn modern-btn-sm" style="background: var(--warning); color: white;">
                                        View Alerts
                                    </a>
                                </div>
                            </div>

                            <!-- Active Products KPI -->
                            <div class="modern-stats-card" style="border-left-color: #8b5cf6;">
                                <div class="modern-flex justify-between items-center modern-mb-4">
                                    <div style="background: #8b5cf6; padding: 0.75rem; border-radius: var(--radius-md);">
                                        <svg class="dashboard-icon-sm" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div style="text-align: right;">
                                        <div class="modern-stats-number">{{ \App\Models\Product::where('status', 'Active')->count() }}</div>
                                        <div class="modern-stats-label">Active</div>
                                    </div>
                                </div>
                                <div class="modern-mb-3">
                                    <h3 style="color: var(--gray-800); font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">Active Products</h3>
                                    <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.4;">Currently available products ready for order fulfillment</p>
                                </div>
                                <div class="modern-flex justify-between items-center">
                                    <span style="color: var(--gray-600); font-size: 0.875rem;">View active items</span>
                                    <a href="{{ route('products.index') }}" class="modern-btn modern-btn-sm" style="background: #8b5cf6; color: white;">
                                        View Products
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Management Cards -->
                    <div class="modern-grid modern-grid-3 modern-mb-8">
                        <!-- Order Management Card -->
                        <div class="modern-stats-card" style="border-left-color: var(--primary-blue);">
                            <div class="modern-flex justify-between items-center modern-mb-4">
                                <div style="background: var(--primary-blue); padding: 0.75rem; border-radius: var(--radius-md);">
                                    <svg class="dashboard-icon-sm" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <div style="text-align: right;">
                                    <div class="modern-stats-number">{{ \App\Models\Order::count() }}</div>
                                    <div class="modern-stats-label">Total Orders</div>
                                </div>
                            </div>
                            <div class="modern-mb-3">
                                <h3 style="color: var(--gray-800); font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">Order Management</h3>
                                <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.4;">Create, track, and manage customer orders and fulfillment</p>
                            </div>
                            <div class="modern-flex justify-between items-center">
                                <span style="color: var(--gray-600); font-size: 0.875rem;">Manage orders</span>
                                <a href="{{ route('orders.index') }}" class="modern-btn modern-btn-primary modern-btn-sm">
                                    View Orders
                                </a>
                            </div>
                        </div>

                        <!-- Stock Transfer Card -->
                        <div class="modern-stats-card" style="border-left-color: var(--primary-green);">
                            <div class="modern-flex justify-between items-center modern-mb-4">
                                <div style="background: var(--primary-green); padding: 0.75rem; border-radius: var(--radius-md);">
                                    <svg class="dashboard-icon-sm" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                </div>
                                <div style="text-align: right;">
                                    <div class="modern-stats-number">{{ \App\Models\StockTransfer::count() }}</div>
                                    <div class="modern-stats-label">Transfers</div>
                                </div>
                            </div>
                            <div class="modern-mb-3">
                                <h3 style="color: var(--gray-800); font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">Stock Transfer</h3>
                                <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.4;">Transfer inventory between locations and manage stock movements</p>
                            </div>
                            <div class="modern-flex justify-between items-center">
                                <span style="color: var(--gray-600); font-size: 0.875rem;">Transfer stock</span>
                                <a href="{{ route('warehouse.transfer.form') }}" class="modern-btn modern-btn-success modern-btn-sm">
                                    New Transfer
                                </a>
                            </div>
                        </div>

                        <!-- Reports & Analytics Card -->
                        <div class="modern-stats-card" style="border-left-color: var(--warning);">
                            <div class="modern-flex justify-between items-center modern-mb-4">
                                <div style="background: var(--warning); padding: 0.75rem; border-radius: var(--radius-md);">
                                    <svg class="dashboard-icon-sm" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div style="text-align: right;">
                                    <div class="modern-stats-number">📊</div>
                                    <div class="modern-stats-label">Analytics</div>
                                </div>
                            </div>
                            <div class="modern-mb-3">
                                <h3 style="color: var(--gray-800); font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">Reports & Analytics</h3>
                                <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.4;">Generate reports, view analytics, and track warehouse performance</p>
                            </div>
                            <div class="modern-flex justify-between items-center">
                                <span style="color: var(--gray-600); font-size: 0.875rem;">View reports</span>
                                <a href="{{ route('warehouse.reports') }}" class="modern-btn modern-btn-sm" style="background: var(--warning); color: white;">
                                    View Reports
                                </a>
                            </div>
                        </div>

                        <!-- Supplies Management Card -->
                        <div class="modern-stats-card" style="border-left-color: #14b8a6;">
                            <div class="modern-flex justify-between items-center modern-mb-4">
                                <div style="background: #14b8a6; padding: 0.75rem; border-radius: var(--radius-md);">
                                    <svg class="dashboard-icon-sm" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div style="text-align: right;">
                                    <div class="modern-stats-number">Supplies</div>
                                    <div class="modern-stats-label">Supplies Management</div>
                                </div>
                            </div>
                            <div class="modern-mb-3">
                                <h3 style="color: var(--gray-800); font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">Supplies Management</h3>
                                <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.4;">Track supplies received from suppliers and manage supply records</p>
                            </div>
                            <div class="modern-flex justify-between items-center">
                                <span style="color: var(--gray-600); font-size: 0.875rem;">View all supplies</span>
                                <a href="{{ route('supplies.index') }}" class="modern-btn modern-btn-sm" style="background: #14b8a6; color: white;">
                                    View Supplies
                                </a>
                            </div>
                        </div>

                        <!-- View Orders Card -->
                        <div class="modern-stats-card" style="border-left-color: #6366f1;">
                            <div class="modern-flex justify-between items-center modern-mb-4">
                                <div style="background: #6366f1; padding: 0.75rem; border-radius: var(--radius-md);">
                                    <svg class="dashboard-icon-sm" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <div style="text-align: right;">
                                    <div class="modern-stats-number">Orders</div>
                                    <div class="modern-stats-label">Retailer Orders</div>
                                </div>
                            </div>
                            <div class="modern-mb-3">
                                <h3 style="color: var(--gray-800); font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">View Orders</h3>
                                <p style="color: var(--gray-600); font-size: 0.875rem; line-height: 1.4;">See all retailer orders in the system and track their status</p>
                            </div>
                            <div class="modern-flex justify-between items-center">
                                <span style="color: var(--gray-600); font-size: 0.875rem;">View all orders</span>
                                <a href="{{ route('orders.retailers') }}" class="modern-btn modern-btn-sm" style="background: #6366f1; color: white;">
                                    View Orders
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Section -->
                    @php
                    $quickActions = [
                        [
                            'label' => 'Inventory Management',
                            'desc' => 'View and manage stock levels',
                            'icon' => 'inventory',
                            'color' => 'blue',
                            'route' => route('warehouse.inventory'),
                        ],
                        [
                            'label' => 'Add New Product',
                            'desc' => 'Create new inventory item',
                            'icon' => 'plus',
                            'color' => 'green',
                            'route' => route('products.create'),
                        ],
                        [
                            'label' => 'Stock Transfer',
                            'desc' => 'Transfer between locations',
                            'icon' => 'transfer',
                            'color' => 'purple',
                            'route' => route('warehouse.transfer.form'),
                        ],
                        [
                            'label' => 'Reports & Analytics',
                            'desc' => 'View performance reports',
                            'icon' => 'report',
                            'color' => 'orange',
                            'route' => route('warehouse.reports'),
                        ],
                    ];
                    $iconSvgs = [
                        'inventory' => '<svg class="quick-action-icon text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                        'plus' => '<svg class="quick-action-icon text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>',
                        'transfer' => '<svg class="quick-action-icon text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>',
                        'report' => '<svg class="quick-action-icon text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>',
                    ];
                    $colorClasses = [
                        'blue' => 'bg-blue-500',
                        'green' => 'bg-green-500',
                        'purple' => 'bg-purple-500',
                        'orange' => 'bg-orange-500',
                    ];
                    @endphp
                    
                    <div class="quick-actions-container">
                        <div class="quick-actions-header">
                            <h2 class="quick-actions-title">Quick Actions</h2>
                            <div class="system-status">
                                <div class="status-indicator"></div>
                                <span class="status-text">System Online</span>
                            </div>
                        </div>
                        <div class="quick-actions-grid">
                            @foreach($quickActions as $action)
                                <a href="{{ $action['route'] }}" class="quick-action-card" data-color="{{ $action['color'] }}">
                                    <div class="card-header">
                                        <div class="icon-container {{ $colorClasses[$action['color']] ?? 'bg-blue-500' }}">
                                            {!! $iconSvgs[$action['icon']] ?? '' !!}
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">{{ $action['label'] }}</h3>
                                            <p class="card-description">{{ $action['desc'] }}</p>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="access-text">Click to access</span>
                                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- System Status Footer -->
                    <div class="mt-8 bg-white/5 backdrop-blur-sm rounded-xl p-6 border border-white/10">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center space-x-6 mb-4 md:mb-0">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                    <span class="text-white text-sm">Database Connected</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse"></div>
                                    <span class="text-white text-sm">Real-time Updates</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-purple-400 rounded-full animate-pulse"></div>
                                    <span class="text-white text-sm">Secure Access</span>
                                </div>
                            </div>
                            <div class="text-white/60 text-sm">
                                Last updated: {{ now()->format('M j, Y g:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

.dashboard-icon-sm {
    width: 1.25rem !important;
    height: 1.25rem !important;
}

.quick-action-icon {
    width: 1rem !important;
    height: 1rem !important;
}

/* Quick Actions Dynamic Cards */
.quick-actions-container {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    border-radius: 12px;
    padding: 24px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 32px;
}

.quick-actions-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.quick-actions-title {
    font-size: 20px;
    font-weight: bold;
    color: white;
    margin: 0;
}

.system-status {
    display: flex;
    align-items: center;
    gap: 8px;
}

.status-indicator {
    width: 8px;
    height: 8px;
    background-color: #4ade80;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.status-text {
    color: #bbf7d0;
    font-size: 14px;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 16px;
}

.quick-action-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    padding: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.quick-action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--card-color, #3b82f6), var(--card-color-light, #60a5fa));
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.quick-action-card:hover::before {
    transform: scaleX(1);
}

.quick-action-card:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.card-header {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
}

.icon-container {
    padding: 8px;
    border-radius: 8px;
    margin-right: 12px;
    transition: transform 0.3s ease;
}

.quick-action-card:hover .icon-container {
    transform: scale(1.1);
}

.card-content {
    flex: 1;
}

.card-title {
    color: white;
    font-weight: 600;
    font-size: 16px;
    margin: 0 0 4px 0;
}

.card-description {
    color: rgba(255, 255, 255, 0.7);
    font-size: 12px;
    margin: 0;
}

.card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 8px;
}

.access-text {
    color: rgba(255, 255, 255, 0.6);
    font-size: 12px;
}

.arrow-icon {
    width: 12px;
    height: 12px;
    color: rgba(255, 255, 255, 0.6);
    transition: color 0.3s ease;
}

.quick-action-card:hover .arrow-icon {
    color: white;
}

/* Color-specific styles */
.quick-action-card[data-color="blue"] {
    --card-color: #3b82f6;
    --card-color-light: #60a5fa;
}

.quick-action-card[data-color="green"] {
    --card-color: #10b981;
    --card-color-light: #34d399;
}

.quick-action-card[data-color="purple"] {
    --card-color: #8b5cf6;
    --card-color-light: #a78bfa;
}

.quick-action-card[data-color="orange"] {
    --card-color: #f59e0b;
    --card-color-light: #fbbf24;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
</style>


