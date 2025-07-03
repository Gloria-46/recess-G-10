<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 ">Inventory-Uptrend Clothing Store</h2>
    </x-slot>
<div class="min-h-screen bg-gradient-to-b from-white via-gray-100 to-white py-10 px-4">
    <div class="max-w-7xl mx-auto">
    <h2>Warehouse Inventory</h2>
        @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4 alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class=" bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded mb-4 alert alert-danger">{{ session('error') }}</div>
    @endif
<div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
    <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-100">
            <tr>
                
                <th class="border px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                <th class="border px-6 py-3 text-left text-sm font-semibold text-gray-600">Category</th>
                <th class="border px-6 py-3 text-left text-sm font-semibold text-gray-600">Quantity</th>
                <th class="border px-6 py-3 text-left text-sm font-semibold text-gray-600">Reorder Level</th>
                <th class="border px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr class=" hover:bg-gray-50 transition {{ $product->quantity < 20 ? 'table-danger' : '' }}">
                <td class="border px-6 py-3 text-sm text-gray-800">{{ $product->name }}</td>
                <td class="border px-6 py-3 text-sm text-gray-800">{{ $product->category }}</td>
                <td class="border px-6 py-3 text-sm text-gray-800">{{ $product->quantity }}</td>
                
                <td class="border px-6 py-3 text-sm text-gray-800">{{ $product->reorder_level}}</td>
                
                <td class="border px-6 py-3 text-sm text-gray-800">
                    <!-- Add stock -->
                    <form action="{{ route('warehouse.inventory.add') }}" method="POST" class="inline-block ml-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <input type="number" name="quantity" placeholder="Qty" class="w-16 border rounded p-1 text-sm" min="1" required>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-sm px-3 py-1 rounded"> Add</button>
                     </form>

                    <!-- Remove stock -->
                    <form action="{{ route('warehouse.inventory.remove') }}" method="POST" class="inline-block">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <input type="number" name="quantity" placeholder="Qty" class="w-16 border rounded p-1 text-sm" min="1" required>
                        <button type="submit"class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1">Remove</button>
                    </form>
                    <!-- Transfer stock -->
                    <form action="{{ route('warehouse.inventory.transfer') }}" method="POST" class="inline-block mt-2">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
    <select name="to_branch" class="border rounded text-sm p-1" required>
        <option disabled selected>Branch</option>
        <option>Kampala</option>
        <option>Jinja</option>
        <option>Arua</option>
    </select>
    <input type="number" name="quantity" placeholder="Qty" class="w-16 border rounded p-1 text-sm" min="1" required>
    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-3 py-1 rounded">Transfer</button>
</form>

@if ($product->quantity < $product->reorder_level)
    <span style="color:red;">Restock Needed!</span>
@endif

                </td>
            </tr>
                         
            
        @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
</x-app-layout>
