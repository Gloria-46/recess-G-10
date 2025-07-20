@extends('warehouse::layouts.app')

@section('content')
<style>
    .order-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 2rem 0;
    }
    
    .order-header {
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
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
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
    
    .error-message {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .order-items-section {
        background: #f8fafc;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-top: 1rem;
    }
    
    .order-item-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .order-item-img {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 0.4rem;
        border: 1px solid #e0e7ef;
        background: #fff;
    }
    
    .order-item-row select, .order-item-row input[type=number] {
        border-radius: 0.25rem;
        border: 1px solid #cbd5e1;
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
        min-width: 120px;
        background: white;
    }
    
    .order-item-row select:focus, .order-item-row input[type=number]:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
    }
    
    .remove-item {
        background: #fff;
        color: #ef4444;
        border: 1px solid #ef4444;
        border-radius: 0.3rem;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .remove-item:hover {
        background: #ef4444;
        color: #fff;
        transform: translateY(-1px);
    }
    
    .add-item-btn {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    
    .add-item-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
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
    
    .btn-success {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
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
        
        .order-item-row {
            flex-direction: column;
            align-items: stretch;
        }
        
        .button-group {
            flex-direction: column;
        }
        
        .btn {
            justify-content: center;
        }
    }
</style>

<div class="order-container">
    <!-- Header -->
    <div class="order-header">
        <div class="header-content">
            <div class="header-text">
                <h1>Create New Order</h1>
                <p>Add a new retailer order to the system</p>
            </div>
            <a href="{{ route('warehouse.inventory') }}" class="back-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Inventory
            </a>
        </div>
    </div>

    <div class="main-content">
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            
            <!-- Retailer Information -->
            <div class="form-section">
                <div class="section-header">
                    <h3>Retailer Information</h3>
                </div>
                <div class="section-content">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="retailer_name" class="form-label">Retailer Name</label>
                            <input type="text" name="retailer_name" id="retailer_name" value="{{ old('retailer_name') }}" required class="form-input">
                            @error('retailer_name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="retailer_email" class="form-label">Email</label>
                            <input type="email" name="retailer_email" id="retailer_email" value="{{ old('retailer_email') }}" required class="form-input">
                            @error('retailer_email')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="retailer_phone" class="form-label">Phone</label>
                            <input type="tel" name="retailer_phone" id="retailer_phone" value="{{ old('retailer_phone') }}" required class="form-input">
                            @error('retailer_phone')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="expected_delivery" class="form-label">Expected Delivery</label>
                            <input type="date" name="expected_delivery" id="expected_delivery" value="{{ old('expected_delivery') }}" required class="form-input">
                            @error('expected_delivery')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="retailer_address" class="form-label">Address</label>
                            <textarea name="retailer_address" id="retailer_address" rows="3" required class="form-textarea">{{ old('retailer_address') }}</textarea>
                            @error('retailer_address')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="retailer_city" class="form-label">City</label>
                            <input type="text" name="retailer_city" id="retailer_city" value="{{ old('retailer_city') }}" required class="form-input">
                            @error('retailer_city')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="retailer_country" class="form-label">Country</label>
                            <input type="text" name="retailer_country" id="retailer_country" value="{{ old('retailer_country', 'Uganda') }}" required class="form-input">
                            @error('retailer_country')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="delivery_method" class="form-label">Delivery Method</label>
                            <select name="delivery_method" id="delivery_method" required class="form-select">
                                <option value="">Select delivery method</option>
                                <option value="Within Kampala" {{ old('delivery_method') == 'Within Kampala' ? 'selected' : '' }}>Within Kampala</option>
                                <option value="Upcountry (outside Kampala)" {{ old('delivery_method') == 'Upcountry (outside Kampala)' ? 'selected' : '' }}>Upcountry (outside Kampala)</option>
                                <option value="Express (same day)" {{ old('delivery_method') == 'Express (same day)' ? 'selected' : '' }}>Express (same day)</option>
                                <option value="Pickup at Warehouse" {{ old('delivery_method') == 'Pickup at Warehouse' ? 'selected' : '' }}>Pickup at Warehouse</option>
                            </select>
                            @error('delivery_method')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="form-section">
                <div class="section-header">
                    <h3>Order Items</h3>
                </div>
                <div class="section-content">
                    <div class="order-items-section">
                        <div id="order-items">
                            <!-- Order items will be added here dynamically -->
                        </div>
                        
                        <button type="button" onclick="addOrderItemRow()" class="add-item-btn">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Item
                        </button>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            <div class="form-section">
                <div class="section-header">
                    <h3>Order Notes</h3>
                </div>
                <div class="section-content">
                    <div class="form-group">
                        <label for="notes" class="form-label">Additional Notes</label>
                        <textarea name="notes" id="notes" rows="4" placeholder="Any special instructions or notes for this order..." class="form-textarea">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="button-group">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" name="action" value="save" class="btn btn-success">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Save Order
                </button>
                <button type="submit" name="action" value="create" class="btn btn-primary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Create Order
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const products = @json($products);
const orderItemsDiv = document.getElementById('order-items');

function addOrderItemRow() {
    const row = document.createElement('div');
    row.className = 'order-item-row';
    
    // Product dropdown with image
    let productOptions = '<option value="">Select product</option>';
    products.forEach(p => {
        productOptions += `<option value="${p.product_id}" data-img="${p.image ? '/storage/' + p.image : ''}" data-sizes='${JSON.stringify(p.sizes)}' data-colors='${JSON.stringify(p.colors)}' data-stock='${p.quantity}'>${p.name} (UGX ${Number(p.price).toLocaleString()})</option>`;
    });
    
    row.innerHTML = `
        <img class="order-item-img" src="" alt="Product" style="display:none;">
        <select class="product-select" name="items[][product_id]" required>
            ${productOptions}
        </select>
        <select class="color-select" name="items[][color]" required style="display:none;">
            <option value="">Select color</option>
        </select>
        <select class="size-select" name="items[][size]" required style="display:none;">
            <option value="">Select size</option>
        </select>
        <input type="number" name="items[][quantity]" min="1" value="1" required placeholder="Qty">
        <button type="button" class="remove-item">Remove</button>
    `;
    
    orderItemsDiv.appendChild(row);
    
    // Remove button
    row.querySelector('.remove-item').addEventListener('click', function() {
        row.remove();
    });
    
    // Product select logic
    const productSelect = row.querySelector('.product-select');
    const sizeSelect = row.querySelector('.size-select');
    const colorSelect = row.querySelector('.color-select');
    const img = row.querySelector('.order-item-img');
    
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            const product = products.find(p => p.product_id == this.value);
            if (product) {
                // Show image
                if (product.image) {
                    img.src = '/storage/' + product.image;
                    img.style.display = 'block';
                } else {
                    img.style.display = 'none';
                }
                
                // Populate sizes
                const sizes = product.sizes || [];
                sizeSelect.innerHTML = '<option value="">Select size</option>' + 
                    sizes.map(s => `<option value="${s}">${s}</option>`).join('');
                sizeSelect.style.display = 'block';
                
                // Populate colors
                const colors = product.colors || [];
                colorSelect.innerHTML = '<option value="">Select color</option>' + 
                    colors.map(c => `<option value="${c}">${c}</option>`).join('');
                colorSelect.style.display = 'block';
            }
        } else {
            img.style.display = 'none';
            sizeSelect.style.display = 'none';
            colorSelect.style.display = 'none';
        }
    });
}

// Add initial row
addOrderItemRow();

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const items = document.querySelectorAll('.order-item-row');
    if (items.length === 0) {
        e.preventDefault();
        alert('Please add at least one item to the order.');
        return false;
    }
    
    let hasValidItems = false;
    items.forEach(item => {
        const productSelect = item.querySelector('.product-select');
        if (productSelect.value) {
            hasValidItems = true;
        }
    });
    
    if (!hasValidItems) {
        e.preventDefault();
        alert('Please select at least one product.');
        return false;
    }
});
</script>
@endsection 