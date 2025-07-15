@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create New Purchase Order</h1>
                <p class="text-gray-600 mt-2">Create a new purchase order with supplier and materials</p>
            </div>
            <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                Back to Orders
            </a>
        </div>

        <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
            @csrf
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Order Details -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-2">Supplier *</label>
                            <select name="supplier_id" id="supplier_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }} - {{ $supplier->category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="order_date" class="block text-sm font-medium text-gray-700 mb-2">Order Date *</label>
                            <input type="date" name="order_date" id="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('order_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="expected_delivery" class="block text-sm font-medium text-gray-700 mb-2">Expected Delivery</label>
                            <input type="date" name="expected_delivery" id="expected_delivery" value="{{ old('expected_delivery') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('expected_delivery')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="shipping_cost" class="block text-sm font-medium text-gray-700 mb-2">Shipping Cost</label>
                            <input type="number" name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost', 0) }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('shipping_cost')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_terms" class="block text-sm font-medium text-gray-700 mb-2">Payment Terms</label>
                            <input type="text" name="payment_terms" id="payment_terms" value="{{ old('payment_terms', 'Net 30') }}" placeholder="e.g., Net 30" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('payment_terms')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                            <textarea name="shipping_address" id="shipping_address" rows="3" placeholder="Enter shipping address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" id="notes" rows="3" placeholder="Additional notes about this order" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Order Items -->
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Order Items</h3>
                        <button type="button" id="addItem" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition duration-200">
                            Add Item
                        </button>
                    </div>

                    <div id="orderItems" class="space-y-4">
                        <!-- Items will be added here dynamically -->
                    </div>

                    @error('items')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order Summary -->
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Subtotal</p>
                            <p class="text-xl font-semibold text-gray-900" id="subtotal">$0.00</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Tax (8%)</p>
                            <p class="text-xl font-semibold text-gray-900" id="tax">$0.00</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Grand Total</p>
                            <p class="text-xl font-semibold text-blue-600" id="grandTotal">$0.00</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="p-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                            Create Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Item Template (hidden) -->
<template id="itemTemplate">
    <div class="item-row bg-gray-50 p-4 rounded-lg border">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Material *</label>
                <select name="items[INDEX][material_id]" required class="material-select w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Material</option>
                    @foreach($materials as $material)
                        <option value="{{ $material->id }}" data-price="{{ $material->price }}" data-unit="{{ $material->unit }}">
                            {{ $material->name }} - ${{ $material->price }}/{{ $material->unit }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                <input type="number" name="items[INDEX][quantity]" required min="1" class="quantity-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price *</label>
                <input type="number" name="items[INDEX][unit_price]" required step="0.01" min="0" class="price-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                <input type="text" class="item-total w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                <input type="text" class="item-unit w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
            </div>
            <div class="flex items-end">
                <button type="button" class="remove-item bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md transition duration-200">
                    Remove
                </button>
            </div>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
            <input type="text" name="items[INDEX][notes]" placeholder="Optional notes for this item" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 0;
    const itemsContainer = document.getElementById('orderItems');
    const itemTemplate = document.getElementById('itemTemplate');
    const addItemBtn = document.getElementById('addItem');

    // Add first item by default
    addItem();

    addItemBtn.addEventListener('click', addItem);

    function addItem() {
        const itemHtml = itemTemplate.innerHTML.replace(/INDEX/g, itemIndex);
        const itemDiv = document.createElement('div');
        itemDiv.innerHTML = itemHtml;
        itemsContainer.appendChild(itemDiv.firstElementChild);

        // Add event listeners to the new item
        const newItem = itemsContainer.lastElementChild;
        setupItemEventListeners(newItem);
        itemIndex++;
    }

    function setupItemEventListeners(item) {
        const materialSelect = item.querySelector('.material-select');
        const quantityInput = item.querySelector('.quantity-input');
        const priceInput = item.querySelector('.price-input');
        const totalInput = item.querySelector('.item-total');
        const unitInput = item.querySelector('.item-unit');
        const removeBtn = item.querySelector('.remove-item');

        // Material selection
        materialSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                priceInput.value = selectedOption.dataset.price;
                unitInput.value = selectedOption.dataset.unit;
                calculateItemTotal();
            }
        });

        // Quantity and price changes
        quantityInput.addEventListener('input', calculateItemTotal);
        priceInput.addEventListener('input', calculateItemTotal);

        // Remove item
        removeBtn.addEventListener('click', function() {
            item.remove();
            calculateOrderTotal();
        });

        function calculateItemTotal() {
            const quantity = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const total = quantity * price;
            totalInput.value = '$' + total.toFixed(2);
            calculateOrderTotal();
        }
    }

    function calculateOrderTotal() {
        let subtotal = 0;
        const itemTotals = document.querySelectorAll('.item-total');
        
        itemTotals.forEach(totalInput => {
            const total = parseFloat(totalInput.value.replace('$', '')) || 0;
            subtotal += total;
        });

        const shippingCost = parseFloat(document.getElementById('shipping_cost').value) || 0;
        const tax = subtotal * 0.08;
        const grandTotal = subtotal + tax + shippingCost;

        document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('tax').textContent = '$' + tax.toFixed(2);
        document.getElementById('grandTotal').textContent = '$' + grandTotal.toFixed(2);
    }

    // Shipping cost change
    document.getElementById('shipping_cost').addEventListener('input', calculateOrderTotal);
});
</script>
@endsection 