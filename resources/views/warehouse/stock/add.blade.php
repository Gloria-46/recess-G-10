@extends('layouts.app')

@section('title', 'Add Stock - ' . $product->name)

@section('content')
<div class="add-stock-page">
    <div class="page-container">
        <!-- Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="page-title">Add Stock</h1>
                    <p class="page-subtitle">Add stock to {{ $product->name }}</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('warehouse.inventory') }}" class="back-btn">
                        <svg class="small-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Inventory
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Info Card -->
        <div class="product-info-card">
            <div class="product-header">
                <div class="product-icon">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <svg class="product-placeholder" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    @endif
                </div>
                <div class="product-details">
                    <h2 class="product-name">{{ $product->name }}</h2>
                    <p class="product-description">{{ $product->description ?? 'No description available' }}</p>
                    <div class="product-meta">
                        <span class="meta-item">
                            <strong>Category:</strong> {{ $product->category }}
                        </span>
                        <span class="meta-item">
                            <strong>Current Stock:</strong> {{ $product->quantity }} units
                        </span>
                        <span class="meta-item">
                            <strong>Reorder Level:</strong> {{ $product->reorder_level ?? 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Stock Form -->
        <div class="form-container">
            <div class="form-card">
                <h3 class="form-title">Add Stock Details</h3>
                
                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('warehouse.stock.add.store', $product->product_id) }}" method="POST" class="stock-form">
                    @csrf
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="quantity" class="form-label">General Quantity to Add</label>
                            <input type="number" id="quantity" name="quantity" min="0" 
                                   class="form-input" placeholder="Enter general quantity (optional)">
                            <small class="form-help">Use this for general stock or if not specifying by color/size</small>
                            @error('quantity')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="reason" class="form-label">Reason for Addition</label>
                            <select id="reason" name="reason" class="form-select">
                                <option value="">Select a reason</option>
                                <option value="New Purchase">New Purchase</option>
                                <option value="Return from Customer">Return from Customer</option>
                                <option value="Transfer from Another Branch">Transfer from Another Branch</option>
                                <option value="Inventory Adjustment">Inventory Adjustment</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('reason')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="batch_number" class="form-label">Batch Number</label>
                            <input type="text" id="batch_number" name="batch_number" 
                                   class="form-input" placeholder="Enter batch number">
                            @error('batch_number')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input type="date" id="expiry_date" name="expiry_date" 
                                   class="form-input" min="{{ date('Y-m-d') }}">
                            @error('expiry_date')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="supplier" class="form-label">Supplier</label>
                            <input type="text" id="supplier" name="supplier" 
                                   class="form-input" placeholder="Enter supplier name">
                            @error('supplier')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cost_price" class="form-label">Cost Price per Unit</label>
                            <input type="number" id="cost_price" name="cost_price" step="0.01" min="0" 
                                   class="form-input" placeholder="Enter cost price">
                            @error('cost_price')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Color-based Stock Addition -->
                    @if($product->colors && count($product->colors) > 0)
                    <div class="stock-section">
                        <h4 class="section-title">Add Stock by Color</h4>
                        <div class="color-grid">
                            @foreach($product->colors as $color)
                            <div class="color-item">
                                <div class="color-preview" style="background-color: {{ strtolower($color) }};"></div>
                                <label class="color-label">{{ $color }}</label>
                                <input type="number" name="color_quantities[{{ $color }}]" min="0" 
                                       class="quantity-input" placeholder="Qty">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Size-based Stock Addition -->
                    @if($product->sizes && count($product->sizes) > 0)
                    <div class="stock-section">
                        <h4 class="section-title">Add Stock by Size</h4>
                        <div class="size-grid">
                            @foreach($product->sizes as $size)
                            <div class="size-item">
                                <label class="size-label">{{ $size }}</label>
                                <input type="number" name="size_quantities[{{ $size }}]" min="0" 
                                       class="quantity-input" placeholder="Qty">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="form-actions">
                        <button type="button" onclick="history.back()" class="btn btn-secondary">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <svg class="small-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Stock
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add Stock Page Styles */
    .add-stock-page {
        min-height: 100vh;
        background: #f8fafc;
    }

    .page-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Header */
    .page-header {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .header-content {
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: bold;
        color: #111827;
        margin: 0;
    }

    .page-subtitle {
        margin: 0.25rem 0 0 0;
        font-size: 1rem;
        color: #6b7280;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: #f3f4f6;
        color: #374151;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .back-btn:hover {
        background: #e5e7eb;
        color: #111827;
    }

    /* Product Info Card */
    .product-info-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .product-header {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .product-icon {
        width: 4rem;
        height: 4rem;
        border-radius: 8px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .product-placeholder {
        width: 2rem;
        height: 2rem;
        color: #9ca3af;
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin: 0 0 0.5rem 0;
    }

    .product-description {
        color: #6b7280;
        margin: 0 0 1rem 0;
        line-height: 1.5;
    }

    .product-meta {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .meta-item {
        font-size: 0.875rem;
        color: #374151;
    }

    /* Form */
    .form-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .form-card {
        padding: 2rem;
    }

    .form-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin: 0 0 1.5rem 0;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-input, .form-select {
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .error-message {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
        color: #111827;
    }

    .small-icon {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    /* Stock Sections */
    .stock-section {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #374151;
        margin: 0 0 1rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 1.5rem;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 2px;
    }

    /* Color Grid */
    .color-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }

    .color-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: white;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .color-item:hover {
        border-color: #3b82f6;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);
    }

    .color-preview {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        border: 2px solid #e5e7eb;
        flex-shrink: 0;
    }

    .color-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        flex: 1;
    }

    /* Size Grid */
    .size-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
    }

    .size-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        padding: 0.75rem;
        background: white;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .size-item:hover {
        border-color: #3b82f6;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);
    }

    .size-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        text-align: center;
    }

    .quantity-input {
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.875rem;
        text-align: center;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .quantity-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-help {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .product-header {
            flex-direction: column;
            text-align: center;
        }
        
        .product-meta {
            justify-content: center;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }

        .color-grid, .size-grid {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        }
    }
</style>
@endsection 