@extends('warehouse::layouts.app')

@section('content')
    <!-- Header -->
    <div class="alerts-header">
        <h2 class="alerts-title">Alerts & Notifications</h2>
        <div class="system-status">
            <div class="status-indicator">
                <div class="status-dot"></div>
                <span class="status-text">System Online</span>
            </div>
        </div>
    </div>
    
    <div class="alerts-container">
        <div class="alerts-content">
            <!-- Alert Summary Cards -->
            <div class="stats-grid">
                <div class="stat-card stat-card-red">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-label">Low Stock Alerts</p>
                            <p class="stat-value">{{ $lowStockProducts->count() }}</p>
                        </div>
                        <div class="stat-icon">
                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card stat-card-green">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-label">Active Products</p>
                            <p class="stat-value">{{ $activeProducts }}</p>
                        </div>
                        <div class="stat-icon">
                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card stat-card-blue">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-label">Total Products</p>
                            <p class="stat-value">{{ $totalProducts }}</p>
                        </div>
                        <div class="stat-icon">
                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card stat-card-purple">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-label">Total Stock</p>
                            <p class="stat-value">{{ number_format($totalStock) }}</p>
                        </div>
                        <div class="stat-icon">
                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alerts Section -->
            <div class="alerts-section">
                <div class="section-header">
                    <h3 class="section-title">Low Stock Alerts</h3>
                    @if($lowStockProducts->count() > 0)
                        <span class="alert-badge alert-badge-red">
                            {{ $lowStockProducts->count() }} items need attention
                        </span>
                    @else
                        <span class="alert-badge alert-badge-green">
                            All stock levels are good
                        </span>
                    @endif
                </div>

                @if($lowStockProducts->count() > 0)
                    <div class="products-grid">
                        @foreach($lowStockProducts as $product)
                            <div class="product-card">
                                <!-- Product Image -->
                                <div class="product-image">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <svg class="placeholder-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="product-info">
                                    <div class="product-header">
                                        <h4 class="product-name">{{ $product->name }}</h4>
                                        <span class="status-badge status-low-stock">Low Stock</span>
                                    </div>
                                    
                                    <p class="product-description">{{ $product->description ?? 'No description available' }}</p>
                                    
                                    <div class="product-details">
                                        <div class="detail-row">
                                            <span class="detail-label">Category:</span>
                                            <span class="detail-value">{{ $product->category }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Current Stock:</span>
                                            <span class="detail-value stock-warning">{{ $product->quantity }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Reorder Level:</span>
                                            <span class="detail-value">{{ $product->reorder_level }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Status:</span>
                                            <span class="status-badge {{ $product->status === 'Active' ? 'status-active' : 'status-inactive' }}">
                                                {{ $product->status ?? 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="action-buttons">
                                        <button onclick="openAddStockModal({{ $product->product_id }}, '{{ $product->name }}')" class="action-btn action-btn-primary">
                                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Add Stock
                                        </button>
                                        <a href="{{ route('products.edit', $product->product_id) }}" class="action-btn action-btn-secondary">
                                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a4 4 0 01-1.414.94l-4.243 1.415 1.415-4.243a4 4 0 01.94-1.414z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="empty-title">No low stock alerts</h3>
                        <p class="empty-description">All products are above their reorder levels.</p>
                    </div>
                @endif
            </div>

            <!-- System Notifications Table -->
            <div class="notifications-section">
                <div class="section-header">
                    <h3 class="section-title">System Notifications</h3>
                    <p class="section-subtitle">Current system status and important notifications</p>
                </div>
                
                <div class="notifications-table">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            <!-- System Status Row -->
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="notification-item">
                                        <div class="notification-icon notification-icon-success">
                                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="notification-info">
                                            <div class="notification-title">System Status</div>
                                            <div class="notification-subtitle">Core Services</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <span class="status-badge status-online">
                                        <div class="status-dot status-dot-pulse"></div>
                                        Online
                                    </span>
                                </td>
                                <td class="table-cell">
                                    <div class="notification-description">Warehouse management system is running normally with all services operational.</div>
                                </td>
                                <td class="table-cell">
                                    <span class="timestamp">{{ now()->format('M d, Y H:i') }}</span>
                                </td>
                                <td class="table-cell">
                                    <button class="action-link">View Details</button>
                                </td>
                            </tr>

                            <!-- Database Sync Row -->
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="notification-item">
                                        <div class="notification-icon notification-icon-info">
                                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="notification-info">
                                            <div class="notification-title">Database Sync</div>
                                            <div class="notification-subtitle">Inventory Data</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <span class="status-badge status-synced">
                                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Synced
                                    </span>
                                </td>
                                <td class="table-cell">
                                    <div class="notification-description">All product and inventory data is up to date and synchronized across all modules.</div>
                                </td>
                                <td class="table-cell">
                                    <span class="timestamp">{{ now()->format('M d, Y H:i') }}</span>
                                </td>
                                <td class="table-cell">
                                    <button class="action-link">Refresh</button>
                                </td>
                            </tr>

                            <!-- Security Status Row -->
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="notification-item">
                                        <div class="notification-icon notification-icon-warning">
                                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                        <div class="notification-info">
                                            <div class="notification-title">Security Status</div>
                                            <div class="notification-subtitle">Access Control</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <span class="status-badge status-secure">
                                        <div class="status-dot"></div>
                                        Secure
                                    </span>
                                </td>
                                <td class="table-cell">
                                    <div class="notification-description">All security protocols are active and user authentication is functioning properly.</div>
                                </td>
                                <td class="table-cell">
                                    <span class="timestamp">{{ now()->format('M d, Y H:i') }}</span>
                                </td>
                                <td class="table-cell">
                                    <button class="action-link">Review</button>
                                </td>
                            </tr>

                            <!-- Maintenance Reminder Row -->
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="notification-item">
                                        <div class="notification-icon notification-icon-warning">
                                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        </div>
                                        <div class="notification-info">
                                            <div class="notification-title">Maintenance Reminder</div>
                                            <div class="notification-subtitle">System Health</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <span class="status-badge status-pending">
                                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Pending
                                    </span>
                                </td>
                                <td class="table-cell">
                                    <div class="notification-description">Check and update reorder levels for critical products regularly to maintain optimal inventory.</div>
                                </td>
                                <td class="table-cell">
                                    <span class="timestamp">{{ now()->format('M d, Y H:i') }}</span>
                                </td>
                                <td class="table-cell">
                                    <button class="action-link">Dismiss</button>
                                </td>
                            </tr>

                            <!-- Performance Monitor Row -->
                            <tr class="table-row">
                                <td class="table-cell">
                                    <div class="notification-item">
                                        <div class="notification-icon notification-icon-success">
                                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="notification-info">
                                            <div class="notification-title">Performance Monitor</div>
                                            <div class="notification-subtitle">System Metrics</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <span class="status-badge status-optimal">
                                        <div class="status-dot"></div>
                                        Optimal
                                    </span>
                                </td>
                                <td class="table-cell">
                                    <div class="notification-description">System performance is optimal with fast response times and efficient resource usage.</div>
                                </td>
                                <td class="table-cell">
                                    <span class="timestamp">{{ now()->format('M d, Y H:i') }}</span>
                                </td>
                                <td class="table-cell">
                                    <button class="action-link">View Report</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Stock Modal -->
    <div id="addStockModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Stock</h3>
                <button onclick="closeAddStockModal()" class="modal-close">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="addStockForm" method="POST" class="modal-form">
                @csrf
                <input type="hidden" id="product_id" name="product_id">
                <div class="form-group">
                    <label class="form-label">Product</label>
                    <input type="text" id="product_name" readonly class="form-input form-input-readonly">
                </div>
                <div class="form-group">
                    <label for="quantity" class="form-label">Quantity to Add</label>
                    <input type="number" id="quantity" name="quantity" min="1" required class="form-input">
                </div>
                <div class="modal-actions">
                    <button type="button" onclick="closeAddStockModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Stock</button>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
function openAddStockModal(productId, productName) {
    document.getElementById('product_id').value = productId;
    document.getElementById('product_name').value = productName;
    document.getElementById('addStockForm').action = '/warehouse/stock/' + productId + '/add';
    document.getElementById('addStockModal').classList.add('modal-open');
}

function closeAddStockModal() {
    document.getElementById('addStockModal').classList.remove('modal-open');
    document.getElementById('quantity').value = '';
}

// Close modal when clicking outside
document.getElementById('addStockModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddStockModal();
    }
});
</script>

<style>
/* Alerts Page Styles */
.alerts-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    padding: 2rem;
    border-radius: 0 0 1.5rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 4px 20px rgba(30, 58, 138, 0.15);
}

.alerts-title {
    color: white;
    font-size: 2.5rem;
    font-weight: 800;
    letter-spacing: -0.025em;
    margin: 0;
}

.system-status {
    display: flex;
    align-items: center;
}

.status-indicator {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 2rem;
    padding: 0.5rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-dot {
    width: 0.75rem;
    height: 0.75rem;
    background: #10b981;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.status-dot-pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.status-text {
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

.alerts-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    padding: 2rem 0;
}

.alerts-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border-left: 4px solid;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stat-card-red { border-left-color: #ef4444; }
.stat-card-green { border-left-color: #10b981; }
.stat-card-blue { border-left-color: #3b82f6; }
.stat-card-purple { border-left-color: #8b5cf6; }

.stat-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.stat-info {
    flex: 1;
}

.stat-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #6b7280;
    margin: 0 0 0.5rem 0;
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    margin: 0;
}

.stat-card-red .stat-value { color: #ef4444; }
.stat-card-green .stat-value { color: #10b981; }
.stat-card-blue .stat-value { color: #3b82f6; }
.stat-card-purple .stat-value { color: #8b5cf6; }

.stat-icon {
    background: rgba(0, 0, 0, 0.05);
    padding: 0.75rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-card-red .stat-icon { background: rgba(239, 68, 68, 0.1); }
.stat-card-green .stat-icon { background: rgba(16, 185, 129, 0.1); }
.stat-card-blue .stat-icon { background: rgba(59, 130, 246, 0.1); }
.stat-card-purple .stat-icon { background: rgba(139, 92, 246, 0.1); }

.icon {
    width: 1.5rem;
    height: 1.5rem;
}

.stat-card-red .icon { color: #ef4444; }
.stat-card-green .icon { color: #10b981; }
.stat-card-blue .icon { color: #3b82f6; }
.stat-card-purple .icon { color: #8b5cf6; }

/* Alerts Section */
.alerts-section {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.section-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0.25rem 0 0 0;
}

.alert-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.alert-badge-red {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.alert-badge-green {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}

.product-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s, box-shadow 0.2s;
}

.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.product-image {
    height: 200px;
    background: #f9fafb;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-icon {
    width: 3rem;
    height: 3rem;
    color: #9ca3af;
}

.product-info {
    padding: 1.5rem;
}

.product-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.product-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.product-description {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0 0 1rem 0;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-details {
    margin-bottom: 1.5rem;
}

.detail-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.detail-label {
    font-size: 0.875rem;
    color: #6b7280;
}

.detail-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1f2937;
}

.stock-warning {
    color: #dc2626;
    font-weight: 700;
}

/* Status Badges */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.status-low-stock {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.status-active {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.status-inactive {
    background: rgba(107, 114, 128, 0.1);
    color: #374151;
}

.status-online {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.status-synced {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
}

.status-secure {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.status-pending {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.status-optimal {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.75rem;
}

.action-btn {
    flex: 1;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.action-btn-primary {
    background: #3b82f6;
    color: white;
}

.action-btn-primary:hover {
    background: #2563eb;
    transform: translateY(-1px);
}

.action-btn-secondary {
    background: #10b981;
    color: white;
}

.action-btn-secondary:hover {
    background: #059669;
    transform: translateY(-1px);
}

.btn-icon {
    width: 1rem;
    height: 1rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    width: 3rem;
    height: 3rem;
    color: #10b981;
    margin: 0 auto 1rem;
}

.empty-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.empty-description {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

/* Notifications Section */
.notifications-section {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.notifications-table {
    overflow: hidden;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table-header {
    background: #f9fafb;
}

.table-header th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #e5e7eb;
}

.table-body {
    background: white;
}

.table-row {
    border-bottom: 1px solid #f3f4f6;
    transition: background-color 0.2s;
}

.table-row:hover {
    background: #f9fafb;
}

.table-row:last-child {
    border-bottom: none;
}

.table-cell {
    padding: 1rem 1.5rem;
    vertical-align: top;
}

/* Notification Items */
.notification-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.notification-icon {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-icon-success {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.notification-icon-info {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.notification-icon-warning {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.notification-info {
    flex: 1;
}

.notification-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.notification-subtitle {
    font-size: 0.75rem;
    color: #6b7280;
    margin: 0.25rem 0 0 0;
}

.notification-description {
    font-size: 0.875rem;
    color: #1f2937;
    line-height: 1.5;
}

.timestamp {
    font-size: 0.875rem;
    color: #6b7280;
}

.action-link {
    color: #3b82f6;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    background: none;
    border: none;
    cursor: pointer;
    transition: color 0.2s;
}

.action-link:hover {
    color: #2563eb;
}

/* Modal Styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}

.modal-open {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    transform: scale(0.9);
    transition: transform 0.3s;
}

.modal-open .modal-content {
    transform: scale(1);
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 0.5rem;
    transition: all 0.2s;
}

.modal-close:hover {
    background: #f3f4f6;
    color: #374151;
}

.modal-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
}

.form-input {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input-readonly {
    background: #f9fafb;
    color: #6b7280;
}

.modal-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    margin-top: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

/* Responsive Design */
@media (max-width: 768px) {
    .alerts-header {
        padding: 1.5rem;
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .alerts-title {
        font-size: 2rem;
    }
    
    .alerts-content {
        padding: 0 1rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .products-grid {
        grid-template-columns: 1fr;
    }
    
    .section-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .notifications-table {
        overflow-x: auto;
    }
    
    .table {
        min-width: 800px;
    }
    
    .modal-content {
        width: 95%;
        margin: 1rem;
    }
}
</style>