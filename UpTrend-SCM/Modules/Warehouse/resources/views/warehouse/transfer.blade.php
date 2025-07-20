@extends('warehouse::layouts.app')

@section('content')
<style>
    .transfer-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 2rem 0;
    }
    
    .transfer-header {
        background: linear-gradient(90deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(30, 58, 138, 0.15);
    }
    
    .header-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .header-text h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .header-text p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }
    
    .back-btn {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .back-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    .main-content {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
    }
    
    .alert-success {
        background: linear-gradient(90deg, #dcfce7 0%, #bbf7d0 100%);
        border: 1px solid #22c55e;
        color: #166534;
    }
    
    .alert-error {
        background: linear-gradient(90deg, #fee2e2 0%, #fecaca 100%);
        border: 1px solid #ef4444;
        color: #991b1b;
    }
    
    .form-section {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    
    .section-header {
        background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .section-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
    }
    
    .section-content {
        padding: 2rem;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .product-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }
    
    .product-image-container {
        width: 120px;
        height: 120px;
        background: #f8fafc;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed #cbd5e1;
        overflow: hidden;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0.5rem;
    }
    
    .detail-item {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 0.5rem;
        border-left: 4px solid #2563eb;
    }
    
    .detail-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    
    .detail-value {
        font-weight: 600;
        color: #1f2937;
    }
    
    .color-size-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .option-group {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 0.5rem;
        border: 1px solid #e2e8f0;
    }
    
    .option-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        padding: 0.5rem;
        background: white;
        border-radius: 0.25rem;
        border: 1px solid #e5e7eb;
    }
    
    .option-checkbox {
        width: 1.2rem;
        height: 1.2rem;
        accent-color: #2563eb;
    }
    
    .option-label {
        font-weight: 500;
        color: #374151;
        flex: 1;
    }
    
    .option-quantity {
        width: 80px;
        padding: 0.25rem 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        text-align: center;
    }
    
    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .btn {
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }
    
    .btn-primary {
        background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }
    
    .btn-secondary {
        background: white;
        color: #374151;
        border: 2px solid #d1d5db;
    }
    
    .btn-secondary:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }
    
    .hidden {
        display: none;
    }
    
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .header-text h1 {
            font-size: 2rem;
        }
        
        .main-content {
            padding: 0 1rem;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .button-group {
            flex-direction: column;
        }
        
        .btn {
            justify-content: center;
        }
    }
</style>

<div class="transfer-container">
    <!-- Header -->
    <div class="transfer-header">
        <div class="header-content">
            <div class="header-text">
                <h1>Transfer Stocks</h1>
                <p>Transfer products between branches with detailed specifications</p>
            </div>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <a href="{{ route('warehouse.transfers.index') }}" class="back-btn" style="background: #fff; color: #2563eb; border: 1.5px solid #2563eb; font-weight: 600;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h6"></path>
                        <circle cx="9" cy="17" r="2" stroke="currentColor" stroke-width="2" fill="none"></circle>
                    </svg>
                    View All Transfers
                </a>
                <a href="{{ route('warehouse.inventory') }}" class="back-btn">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Inventory
                </a>
            </div>
        </div>
    </div>

    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('warehouse.transfer.handle') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Product Selection -->
            <div class="form-section">
                <div class="section-header">
                    <h3>Product Selection</h3>
                </div>
                <div class="section-content">
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="product_id" class="form-label">Product</label>
                            <select name="product_id" id="product_id" onchange="loadProductDetails()" class="form-select" required>
                                <option value="">Select a product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->product_id }}" 
                                            data-category="{{ $product->category }}"
                                            data-price="{{ $product->price }}"
                                            data-colors="{{ is_array($product->colors) ? implode(',', $product->colors) : ($product->colors ?? '') }}"
                                            data-sizes="{{ is_array($product->sizes) ? implode(',', $product->sizes) : ($product->sizes ?? '') }}"
                                            data-status="{{ $product->status }}"
                                            data-description="{{ $product->description }}"
                                            data-batch="{{ $product->batch }}"
                                            data-image="{{ $product->image }}"
                                            data-date="{{ $product->date }}"
                                            data-quantity="{{ $product->quantity }}">
                                        {{ $product->name }} ({{ $product->quantity }} in stock)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="to_branch" class="form-label">To Branch</label>
                            <select name="to_branch" id="to_branch" class="form-select" required>
                                <option value="">Select a branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch }}">{{ $branch }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" min="1" class="form-input" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Display -->
            <div id="product-details" class="form-section hidden">
                <div class="section-header">
                    <h3>Product Details</h3>
                </div>
                <div class="section-content">
                    <div class="product-details">
                        <div class="form-group full-width">
                            <label class="form-label">Product Image</label>
                            <div id="product-image-container" class="product-image-container">
                                <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Category</div>
                            <div id="product-category" class="detail-value">-</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Price</div>
                            <div id="product-price" class="detail-value">-</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div id="product-status" class="detail-value">-</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Batch</div>
                            <div id="product-batch" class="detail-value">-</div>
                        </div>

                        <div class="detail-item full-width">
                            <div class="detail-label">Description</div>
                            <div id="product-description" class="detail-value">-</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Color and Size Selection -->
            <div id="color-size-selection" class="form-section hidden">
                <div class="section-header">
                    <h3>Color & Size Selection</h3>
                </div>
                <div class="section-content">
                    <div class="color-size-grid">
                        <div class="option-group">
                            <label class="form-label">Colors</label>
                            <div id="color-options">
                                <!-- Color options will be populated dynamically -->
                            </div>
                        </div>

                        <div class="option-group">
                            <label class="form-label">Sizes</label>
                            <div id="size-options">
                                <!-- Size options will be populated dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transfer Details -->
            <div class="form-section">
                <div class="section-header">
                    <h3>Transfer Details</h3>
                </div>
                <div class="section-content">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="transfer_date" class="form-label">Transfer Date</label>
                            <input type="datetime-local" name="transfer_date" id="transfer_date" value="{{ now()->format('Y-m-d\TH:i') }}" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="priority" class="form-label">Priority</label>
                            <select name="priority" id="priority" class="form-select">
                                <option value="normal">Normal</option>
                                <option value="urgent">Urgent</option>
                                <option value="express">Express</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label for="notes" class="form-label">Transfer Notes</label>
                            <textarea name="notes" id="notes" rows="3" placeholder="Any special instructions or notes for this transfer..." class="form-textarea"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="button-group">
                <a href="{{ route('warehouse.inventory') }}" class="btn btn-secondary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Transfer Stock
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function loadProductDetails() {
    const select = document.getElementById('product_id');
    const selectedOption = select.options[select.selectedIndex];
    const productDetails = document.getElementById('product-details');
    const colorSizeSelection = document.getElementById('color-size-selection');
    
    if (select.value) {
        // Show product details
        productDetails.classList.remove('hidden');
        
        // Update product details
        document.getElementById('product-category').textContent = selectedOption.dataset.category || '-';
        document.getElementById('product-price').textContent = selectedOption.dataset.price ? 'UGX ' + Number(selectedOption.dataset.price).toLocaleString() : '-';
        document.getElementById('product-status').textContent = selectedOption.dataset.status || '-';
        document.getElementById('product-batch').textContent = selectedOption.dataset.batch || '-';
        document.getElementById('product-description').textContent = selectedOption.dataset.description || '-';
        
        // Update product image
        const imageContainer = document.getElementById('product-image-container');
        if (selectedOption.dataset.image) {
            imageContainer.innerHTML = `<img src="/storage/${selectedOption.dataset.image}" alt="Product Image" class="product-image">`;
        } else {
            imageContainer.innerHTML = `<svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>`;
        }
        
        // Load color and size options
        loadColorOptions(selectedOption.dataset.colors);
        loadSizeOptions(selectedOption.dataset.sizes);
        
        colorSizeSelection.classList.remove('hidden');
    } else {
        productDetails.classList.add('hidden');
        colorSizeSelection.classList.add('hidden');
    }
}

function loadColorOptions(colors) {
    const colorOptions = document.getElementById('color-options');
    if (colors) {
        const colorArray = colors.split(',');
        colorOptions.innerHTML = colorArray.map(color => `
            <div class="option-item">
                <input type="checkbox" name="selected_colors[]" value="${color}" id="color-${color}" class="option-checkbox">
                <label for="color-${color}" class="option-label">${color}</label>
                <input type="number" name="color_quantity_${color}" placeholder="Qty" min="0" class="option-quantity">
            </div>
        `).join('');
    } else {
        colorOptions.innerHTML = '<p style="color: #6b7280; font-style: italic;">No colors available for this product</p>';
    }
}

function loadSizeOptions(sizes) {
    const sizeOptions = document.getElementById('size-options');
    if (sizes) {
        const sizeArray = sizes.split(',');
        sizeOptions.innerHTML = sizeArray.map(size => `
            <div class="option-item">
                <input type="checkbox" name="selected_sizes[]" value="${size}" id="size-${size}" class="option-checkbox">
                <label for="size-${size}" class="option-label">${size}</label>
                <input type="number" name="size_quantity_${size}" placeholder="Qty" min="0" class="option-quantity">
            </div>
        `).join('');
    } else {
        sizeOptions.innerHTML = '<p style="color: #6b7280; font-style: italic;">No sizes available for this product</p>';
    }
}
</script>
@endsection 