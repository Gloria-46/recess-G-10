@extends('warehouse::layouts.app')

@section('title', 'Order Management')

@section('content')
<div class="orders-page">
    <!-- Header -->
    <div class="orders-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">Order Management</h1>
                <p class="page-subtitle">Manage retailer orders and track fulfillment</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('orders.create') }}" class="new-order-btn">
                    <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    New Order
                </a>
                <a href="{{ route('orders.index') }}" class="new-order-btn" style="background: #fff; color: #2563eb; border: 1.5px solid #2563eb; font-weight: 600; margin-left: 1rem;">
                    <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h18"></path>
                    </svg>
                    View All Orders
                </a>
                <a href="{{ route('orders.retailers') }}" class="new-order-btn" style="background: #14b8a6; color: #fff; font-weight: 600; margin-left: 1rem;">
                    <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h18"></path>
                    </svg>
                    View All Retailer Orders
                </a>
                <a href="#" class="new-order-btn" id="filterOrdersBtn" style="background: #fff; color: #2563eb; border: 1.5px solid #2563eb; font-weight: 600; margin-left: 1rem;">
                    <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h18"></path>
                    </svg>
                    Filter Orders
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="orders-container">
        <div class="stats-grid">
            <!-- Total Orders -->
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon blue-icon">
                        <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="stat-details">
                        <dt class="stat-label">Total Orders</dt>
                        <dd class="stat-value">{{ $stats['total_orders'] }}</dd>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon yellow-icon">
                        <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-details">
                        <dt class="stat-label">Pending</dt>
                        <dd class="stat-value">{{ $stats['pending_orders'] }}</dd>
                    </div>
                </div>
            </div>

            <!-- Processing Orders -->
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon purple-icon">
                        <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="stat-details">
                        <dt class="stat-label">Processing</dt>
                        <dd class="stat-value">{{ $stats['processing_orders'] }}</dd>
                    </div>
                </div>
            </div>

            <!-- Shipped Orders -->
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon indigo-icon">
                        <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="stat-details">
                        <dt class="stat-label">Shipped</dt>
                        <dd class="stat-value">{{ $stats['shipped_orders'] }}</dd>
                    </div>
                </div>
            </div>

            <!-- Delivered Orders -->
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon green-icon">
                        <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="stat-details">
                        <dt class="stat-label">Delivered</dt>
                        <dd class="stat-value">{{ $stats['delivered_orders'] }}</dd>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-icon revenue-icon">
                        <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="stat-details">
                        <dt class="stat-label">Revenue</dt>
                        <dd class="stat-value">UGX{{ number_format($stats['total_revenue'], 0) }}</dd>
                    </div>
                </div>
            </div>
        </div>

        @php
            $draftOrders = $orders->filter(fn($order) => $order->status === 'draft');
            $activeOrders = $orders->filter(fn($order) => $order->status !== 'draft');
        @endphp

        @if($draftOrders->count() > 0)
            <div class="orders-table-container mb-8">
                <div class="table-header">
                    <h3 class="table-title">Saved Orders (Drafts)</h3>
                    <p class="table-subtitle">Orders saved as drafts. Complete or edit to submit.</p>
                </div>
                <ul class="orders-list">
                    @foreach($draftOrders as $order)
                    <li class="order-item">
                        <div class="order-content">
                            <div class="order-left">
                                <div class="order-icon">
                                    <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div class="order-details">
                                    <div class="order-header">
                                        <p class="order-number">{{ $order->order_number }}</p>
                                        <span class="status-badge status-draft">Draft</span>
                                    </div>
                                    <div class="order-meta">
                                        <p>{{ $order->retailer_name }}</p>
                                        <span class="separator">•</span>
                                        <p>{{ $order->order_date->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="order-right">
                                <a href="{{ route('orders.edit', $order) }}" class="action-link edit-link">Continue</a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Orders Table -->
        <div class="orders-table-container">
            <div class="table-header">
                <h3 class="table-title">Recent Orders</h3>
                <p class="table-subtitle">All retailer orders and their current status</p>
            </div>
            
            @php
                $orders = $activeOrders;
            @endphp

            @if($orders->count() > 0)
                <ul class="orders-list">
                    @foreach($orders as $order)
                    <li class="order-item">
                        <div class="order-content">
                            <div class="order-left">
                                <div class="order-icon">
                                    <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div class="order-details">
                                    <div class="order-header">
                                        <p class="order-number">{{ $order->order_number }}</p>
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </div>
                                    <div class="order-meta">
                                        <p>{{ $order->retailer_name }}</p>
                                        <span class="separator">•</span>
                                        <p>{{ $order->order_date->format('M d, Y') }}</p>
                                        <span class="separator">•</span>
                                        <p>{{ $order->orderItems->count() }} items</p>
                                    </div>
                                </div>
                            </div>
                            <div class="order-right">
                                <div class="order-summary">
                                    <p class="order-total">UGX{{ number_format($order->total, 0) }}</p>
                                    <p class="order-units">{{ $order->orderItems->sum('quantity') }} units</p>
                                </div>
                                <div class="order-actions">
                                    <a href="{{ route('orders.show', $order) }}" class="action-link view-link">
                                        View
                                    </a>
                                    <a href="{{ route('orders.edit', $order) }}" class="action-link edit-link">
                                        Edit
                                    </a>
                                    @if($order->status === 'pending')
                                    <form method="POST" action="{{ route('orders.process', $order) }}" class="inline-form">
                                        @csrf
                                        <button type="submit" class="action-link process-link">
                                            Process
                                        </button>
                                    </form>
                                    @endif
                                    @if($order->status === 'confirmed' || $order->status === 'processing')
                                    <form method="POST" action="{{ route('orders.ship', $order) }}" class="inline-form">
                                        @csrf
                                        <button type="submit" class="action-link ship-link">
                                            Ship
                                        </button>
                                    </form>
                                    @endif
                                    @if($order->status === 'shipped')
                                    <form method="POST" action="{{ route('orders.deliver', $order) }}" class="inline-form">
                                        @csrf
                                        <button type="submit" class="action-link deliver-link">
                                            Deliver
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                
                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination-mobile">
                        @if($orders->previousPageUrl())
                            <a href="{{ $orders->previousPageUrl() }}" class="pagination-btn">
                                Previous
                            </a>
                        @endif
                        @if($orders->nextPageUrl())
                            <a href="{{ $orders->nextPageUrl() }}" class="pagination-btn">
                                Next
                            </a>
                        @endif
                    </div>
                    <div class="pagination-desktop">
                        <div class="pagination-info">
                            <p class="pagination-text">
                                Showing <span class="font-medium">{{ $orders->firstItem() }}</span> to <span class="font-medium">{{ $orders->lastItem() }}</span> of <span class="font-medium">{{ $orders->total() }}</span> results
                            </p>
                        </div>
                        <div class="pagination-links">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="empty-title">No orders</h3>
                    <p class="empty-text">Get started by creating a new order.</p>
                    <div class="empty-actions">
                        <a href="{{ route('orders.create') }}" class="empty-btn">
                            <svg class="small-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            New Order
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.getElementById('filterOrdersBtn').addEventListener('click', function(e) {
    e.preventDefault();
    // Scroll to or focus the orders table, or open a filter modal if you have one
    // For now, just alert as a placeholder
    alert('Use the status badges or table to view/filter orders by status. (You can implement a modal or filter UI here.)');
});
</script>

<style>
    /* Orders Page Styles */
    .orders-page {
        min-height: 100vh;
        background: #f8fafc;
    }

    /* Header */
    .orders-header {
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border-bottom: 1px solid #e5e7eb;
    }

    .header-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 0;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: bold;
        color: #111827;
        margin: 0;
    }

    .page-subtitle {
        margin: 0.25rem 0 0 0;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .new-order-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: #3b82f6;
        border: 1px solid transparent;
        border-radius: 0.375rem;
        font-weight: 600;
        font-size: 0.75rem;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-decoration: none;
        transition: all 0.15s ease-in-out;
    }

    .new-order-btn:hover {
        background: #2563eb;
    }

    /* Container */
    .orders-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stat-content {
        padding: 1.25rem;
        display: flex;
        align-items: center;
    }

    .stat-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .blue-icon { background: #3b82f6; }
    .yellow-icon { background: #f59e0b; }
    .purple-icon { background: #8b5cf6; }
    .indigo-icon { background: #6366f1; }
    .green-icon { background: #10b981; }
    .revenue-icon { background: #059669; }

    .small-icon {
        width: 1rem;
        height: 1rem;
        color: white;
    }

    .stat-details {
        margin-left: 1.25rem;
        flex: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
        margin: 0;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    .stat-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    /* Orders Table */
    .orders-table-container {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .table-subtitle {
        margin: 0.25rem 0 0 0;
        font-size: 0.875rem;
        color: #6b7280;
        max-width: 32rem;
    }

    /* Orders List */
    .orders-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .order-item {
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s ease;
    }

    .order-item:hover {
        background: #f9fafb;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-content {
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .order-left {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .order-icon {
        width: 2.5rem;
        height: 2.5rem;
        background: #d1d5db;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .order-details {
        margin-left: 1rem;
    }

    .order-header {
        display: flex;
        align-items: center;
    }

    .order-number {
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .status-badge {
        margin-left: 0.5rem;
        padding: 0.125rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #dbeafe; color: #1e40af; }
    .status-processing { background: #e9d5ff; color: #7c3aed; }
    .status-shipped { background: #c7d2fe; color: #4338ca; }
    .status-delivered { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }
    .status-draft { background: #e0f2fe; color: #1e40af; }

    .order-meta {
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .separator {
        margin: 0 0.5rem;
    }

    .order-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .order-summary {
        text-align: right;
    }

    .order-total {
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .order-units {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }

    .order-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-link {
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .view-link { color: #3b82f6; }
    .view-link:hover { color: #1d4ed8; }
    .edit-link { color: #6366f1; }
    .edit-link:hover { color: #4338ca; }
    .process-link { color: #10b981; }
    .process-link:hover { color: #059669; }
    .ship-link { color: #8b5cf6; }
    .ship-link:hover { color: #7c3aed; }
    .deliver-link { color: #10b981; }
    .deliver-link:hover { color: #059669; }

    .inline-form {
        display: inline;
    }

    .inline-form button {
        background: none;
        border: none;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    /* Pagination */
    .pagination-container {
        background: white;
        padding: 0.75rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid #e5e7eb;
    }

    .pagination-mobile {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .pagination-desktop {
        display: none;
        width: 100%;
        align-items: center;
        justify-content: space-between;
    }

    .pagination-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        background: white;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination-btn:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }

    .pagination-text {
        font-size: 0.875rem;
        color: #374151;
        margin: 0;
    }

    .font-medium {
        font-weight: 500;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .empty-icon {
        width: 3rem;
        height: 3rem;
        margin: 0 auto 0.75rem;
        color: #9ca3af;
    }

    .empty-title {
        font-size: 0.875rem;
        font-weight: 500;
        color: #111827;
        margin: 0 0 0.25rem 0;
    }

    .empty-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0 0 1.5rem 0;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border: 1px solid transparent;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: white;
        background: #3b82f6;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .empty-btn:hover {
        background: #2563eb;
    }

    /* Responsive Design */
    @media (min-width: 640px) {
        .pagination-mobile {
            display: none;
        }
        
        .pagination-desktop {
            display: flex;
        }
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .order-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .order-right {
            width: 100%;
            justify-content: space-between;
        }
    }

    @media (min-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(6, 1fr);
        }
    }
</style>
@endsection 