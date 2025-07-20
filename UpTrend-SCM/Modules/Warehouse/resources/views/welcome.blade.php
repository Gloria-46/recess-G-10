@extends('warehouse::layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-cyan-50 py-12">
        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-6 text-center mb-16">
            <div class="relative">
                <!-- Background decorative elements -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-96 h-96 bg-blue-200 rounded-full opacity-20 blur-3xl"></div>
                    <div class="w-80 h-80 bg-green-200 rounded-full opacity-20 blur-3xl ml-20"></div>
                </div>
                
                <div class="relative z-10">
                    <h1 class="text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-900 to-green-700 mb-6">
                        Uptrend Warehouse System
                    </h1>
                    <p class="text-xl md:text-2xl mb-4 font-medium text-gray-700">
                        Efficient Inventory & Warehouse Management
                    </p>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Streamline your warehouse operations with our comprehensive management system
                    </p>
                </div>
            </div>
        </div>
        <!-- Dynamic Cards Section -->
        @php
            $features = [
                [
                    'title' => 'Inventory Management',
                    'desc' => 'Browse, manage, and track all available stock in the system with real-time updates.',
                    'link' => '/inventory',
                    'btn' => 'Go to Inventory',
                    'icon' => 'inventory',
                    'color' => 'blue',
                    'gradient' => 'from-blue-500 to-blue-600',
                    'bg_gradient' => 'from-blue-50 to-blue-100',
                    'border_color' => 'border-blue-200'
                ],
                [
                    'title' => 'Reports & Analytics',
                    'desc' => 'Monitor stock movement, transfer history, and generate comprehensive reports.',
                    'link' => '/warehouse/reports',
                    'btn' => 'View Reports',
                    'icon' => 'reports',
                    'color' => 'green',
                    'gradient' => 'from-green-500 to-green-600',
                    'bg_gradient' => 'from-green-50 to-green-100',
                    'border_color' => 'border-green-200'
                ],
                [
                    'title' => 'Stock Transfer',
                    'desc' => 'Move stock between Uptrend branches with detailed tracking and management.',
                    'link' => '/warehouse/transfer',
                    'btn' => 'Transfer Now',
                    'icon' => 'transfer',
                    'color' => 'purple',
                    'gradient' => 'from-purple-500 to-purple-600',
                    'bg_gradient' => 'from-purple-50 to-purple-100',
                    'border_color' => 'border-purple-200'
                ],
                [
                    'title' => 'Product Catalog',
                    'desc' => 'View all products, add new items, and manage your product database.',
                    'link' => '/products',
                    'btn' => 'View Products',
                    'icon' => 'products',
                    'color' => 'orange',
                    'gradient' => 'from-orange-500 to-orange-600',
                    'bg_gradient' => 'from-orange-50 to-orange-100',
                    'border_color' => 'border-orange-200'
                ],
                [
                    'title' => 'Order Management',
                    'desc' => 'Create, track, and manage customer orders and fulfillment processes.',
                    'link' => '/orders',
                    'btn' => 'Manage Orders',
                    'icon' => 'orders',
                    'color' => 'indigo',
                    'gradient' => 'from-indigo-500 to-indigo-600',
                    'bg_gradient' => 'from-indigo-50 to-indigo-100',
                    'border_color' => 'border-indigo-200'
                ],
                [
                    'title' => 'Account Access',
                    'desc' => 'Login to your account or create a new one to access the system.',
                    'link' => null,
                    'btn' => null,
                    'icon' => 'account',
                    'color' => 'teal',
                    'gradient' => 'from-teal-500 to-teal-600',
                    'bg_gradient' => 'from-teal-50 to-teal-100',
                    'border_color' => 'border-teal-200'
                ],
                [
                    'title' => 'Supplies Management',
                    'desc' => 'Track supplies received from suppliers and manage supply records.',
                    'link' => route('supplies.index'),
                    'btn' => 'View Supplies',
                    'icon' => 'inventory',
                    'color' => 'teal',
                    'gradient' => 'from-teal-500 to-teal-600',
                    'bg_gradient' => 'from-teal-50 to-teal-100',
                    'border_color' => 'border-teal-200'
                ],
                [
                    'title' => 'View Orders',
                    'desc' => 'See all retailer orders in the system and track their status.',
                    'link' => route('orders.retailers'),
                    'btn' => 'View Orders',
                    'icon' => 'orders',
                    'color' => 'indigo',
                    'gradient' => 'from-indigo-500 to-indigo-600',
                    'bg_gradient' => 'from-indigo-50 to-indigo-100',
                    'border_color' => 'border-indigo-200'
                ],
            ];
            
            $iconSvgs = [
                'inventory' => '<svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                'reports' => '<svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>',
                'transfer' => '<svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>',
                'products' => '<svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                'orders' => '<svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>',
                'account' => '<svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
            ];
        @endphp
        <div class="max-w-7xl mx-auto px-6">
            <div class="features-grid">
                @foreach($features as $feature)
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">
                            {!! $iconSvgs[$feature['icon']] !!}
                        </div>
                        
                        <div class="feature-content">
                            <h3 class="feature-title">
                                {{ $feature['title'] }}
                            </h3>
                            <p class="feature-description">
                                {{ $feature['desc'] }}
                            </p>
                            
                            @if($feature['title'] === 'Account Access')
                                <div class="feature-actions">
                                    <a href="/" class="feature-btn primary">
                                        Login
                                    </a>
                                    <a href="/register" class="feature-btn secondary">
                                        Register
                                    </a>
                                </div>
                            @else
                                <a href="{{ $feature['link'] }}" class="feature-btn primary">
                                    {{ $feature['btn'] }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Quick Actions Section -->
            <div class="quick-actions-section">
                <h2 class="quick-actions-title">Quick Actions</h2>
                <div class="quick-actions-grid">
                    <a href="/products" class="quick-action-card">
                        <div class="quick-action-icon">
                            <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="quick-action-content">
                            <h3 class="quick-action-title">View All Products</h3>
                            <p class="quick-action-description">Browse the complete product catalog</p>
                        </div>
                    </a>
                    
                    <a href="/products/create" class="quick-action-card">
                        <div class="quick-action-icon">
                            <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="quick-action-content">
                            <h3 class="quick-action-title">Add New Product</h3>
                            <p class="quick-action-description">Create a new inventory item</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="max-w-7xl mx-auto px-6 mt-16 text-center">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 border border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Ready to Get Started?</h3>
                <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                    Experience the power of efficient warehouse management with our comprehensive system designed for modern businesses.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/login" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105">
                        Get Started
                    </a>
                    <a href="/warehouse/reports" class="bg-white border-2 border-gray-200 hover:border-gray-300 text-gray-700 font-semibold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105">
                        View Demo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Feature Cards */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .feature-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .feature-icon-wrapper {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon-wrapper {
            transform: scale(1.1);
        }

        .feature-icon {
            width: 1.5rem;
            height: 1.5rem;
            color: white;
        }

        .feature-content {
            flex: 1;
        }

        .feature-title {
            font-size: 1.125rem;
            font-weight: bold;
            color: #111827;
            margin: 0 0 0.75rem 0;
            transition: color 0.3s ease;
        }

        .feature-card:hover .feature-title {
            color: #374151;
        }

        .feature-description {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.5;
            margin: 0 0 1rem 0;
        }

        .feature-actions {
            display: flex;
            gap: 0.5rem;
        }

        .feature-btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .feature-btn.primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            width: 100%;
        }

        .feature-btn.primary:hover {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .feature-btn.secondary {
            background: white;
            color: #374151;
            border: 2px solid #e5e7eb;
            flex: 1;
        }

        .feature-btn.secondary:hover {
            border-color: #d1d5db;
            background: #f9fafb;
            transform: translateY(-1px);
        }

        /* Quick Actions */
        .quick-actions-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            border: 1px solid #e5e7eb;
            margin-bottom: 2rem;
        }

        .quick-actions-title {
            font-size: 1.875rem;
            font-weight: bold;
            color: #111827;
            margin: 0 0 1.5rem 0;
            text-align: center;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .quick-action-card {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border: 1px solid #bae6fd;
            border-radius: 10px;
            padding: 1.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .quick-action-card:hover {
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            border-color: #7dd3fc;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .quick-action-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: #3b82f6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .quick-action-content {
            flex: 1;
        }

        .quick-action-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin: 0 0 0.5rem 0;
        }

        .quick-action-description {
            color: #6b7280;
            font-size: 0.875rem;
            margin: 0;
        }

        .small-icon {
            width: 1rem;
            height: 1rem;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-actions-grid {
                grid-template-columns: 1fr;
            }
            
            .feature-actions {
                flex-direction: column;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1025px) {
            .features-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1280px) {
            .features-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (min-width: 1536px) {
            .features-grid {
                grid-template-columns: repeat(6, 1fr);
            }
        }
    </style>
@endsection 