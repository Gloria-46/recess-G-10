<x-app-layout>
<style>
    .supply-form-container {
        max-width: 600px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(30,58,138,0.08);
        padding: 2.5rem 2rem;
    }
    .supply-form-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 2rem;
        text-align: center;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 0.5rem;
        font-size: 1rem;
        color: #374151;
        background: #f8fafc;
        transition: border 0.2s;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: #2563eb;
        outline: none;
    }
    .form-btn {
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        padding: 0.7rem 2rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        font-size: 1.1rem;
        margin-top: 1rem;
        width: 100%;
    }
    .form-btn:hover {
        background: #1e3a8a;
    }
</style>
<div class="supply-form-container">
    <div class="supply-form-title">Add New Supply</div>
    <form method="POST" action="{{ route('supplies.store') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Supplier</label>
            <select name="supplier_id" class="form-select" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Product</label>
            <select name="product_id" class="form-select" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->product_id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-input" min="1" required>
        </div>
        <div class="form-group">
            <label class="form-label">Date Received</label>
            <input type="date" name="date_received" class="form-input">
        </div>
        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="Received">Received</option>
                <option value="Pending">Pending</option>
                <option value="Returned">Returned</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-textarea" rows="3"></textarea>
        </div>
        <button type="submit" class="form-btn">Save Supply</button>
    </form>
</div>
</x-app-layout> 