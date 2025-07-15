@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Add New Material</h1>
            <a href="{{ route('materials.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Materials</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('materials.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Material Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                               placeholder="e.g., Cotton Fabric, Metal Zippers"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-2">Supplier *</label>
                        <select name="supplier_id" id="supplier_id" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select name="category" id="category" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Category</option>
                            <option value="Fabric" {{ old('category') == 'Fabric' ? 'selected' : '' }}>Fabric</option>
                            <option value="Accessories" {{ old('category') == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                            <option value="Packaging" {{ old('category') == 'Packaging' ? 'selected' : '' }}>Packaging</option>
                            <option value="Dyes" {{ old('category') == 'Dyes' ? 'selected' : '' }}>Dyes & Chemicals</option>
                            <option value="Threads" {{ old('category') == 'Threads' ? 'selected' : '' }}>Threads</option>
                            <option value="Labels" {{ old('category') == 'Labels' ? 'selected' : '' }}>Labels & Tags</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subcategory" class="block text-sm font-medium text-gray-700 mb-2">Subcategory</label>
                        <input type="text" name="subcategory" id="subcategory" value="{{ old('subcategory') }}"
                               placeholder="e.g., Cotton, Polyester, Metal, Plastic"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('subcategory')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                        <select name="unit" id="unit" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Unit</option>
                            <option value="meters" {{ old('unit') == 'meters' ? 'selected' : '' }}>Meters</option>
                            <option value="yards" {{ old('unit') == 'yards' ? 'selected' : '' }}>Yards</option>
                            <option value="pieces" {{ old('unit') == 'pieces' ? 'selected' : '' }}>Pieces</option>
                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                            <option value="grams" {{ old('unit') == 'grams' ? 'selected' : '' }}>Grams (g)</option>
                            <option value="liters" {{ old('unit') == 'liters' ? 'selected' : '' }}>Liters</option>
                            <option value="rolls" {{ old('unit') == 'rolls' ? 'selected' : '' }}>Rolls</option>
                            <option value="boxes" {{ old('unit') == 'boxes' ? 'selected' : '' }}>Boxes</option>
                        </select>
                        @error('unit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">Unit Price (UGX) *</label>
                        <input type="number" name="unit_price" id="unit_price" value="{{ old('unit_price') }}" required min="0" step="0.01"
                               placeholder="0.00"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('unit_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="moq" class="block text-sm font-medium text-gray-700 mb-2">Minimum Order Quantity *</label>
                        <input type="number" name="moq" id="moq" value="{{ old('moq') }}" required min="1"
                               placeholder="1"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('moq')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lead_time_days" class="block text-sm font-medium text-gray-700 mb-2">Lead Time (Days) *</label>
                        <input type="number" name="lead_time_days" id="lead_time_days" value="{{ old('lead_time_days') }}" required min="0"
                               placeholder="0"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('lead_time_days')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select name="status" id="status" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="3"
                              placeholder="Brief description of the material..."
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="specifications" class="block text-sm font-medium text-gray-700 mb-2">Technical Specifications</label>
                    <textarea name="specifications" id="specifications" rows="3"
                              placeholder="Technical details, specifications, or requirements..."
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('specifications') }}</textarea>
                    @error('specifications')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                              placeholder="Additional notes or comments..."
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4 mt-8">
                    <a href="{{ route('materials.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Create Material
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 