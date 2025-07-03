<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">Transfer Stocks</h2>
    </x-slot>
    <div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded shadow">
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
        @endif
        <form action="{{ route('warehouse.transfer.handle') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="product_id" class="block font-semibold mb-1">Product</label>
                <select name="product_id" id="product_id" class="w-full border rounded p-2" required>
                    <option value="" disabled selected>Select a product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->product_id }}">{{ $product->name }} ({{ $product->quantity }} in stock)</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="to_branch" class="block font-semibold mb-1">To Branch</label>
                <select name="to_branch" id="to_branch" class="w-full border rounded p-2" required>
                    <option value="" disabled selected>Select a branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch }}">{{ $branch }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="quantity" class="block font-semibold mb-1">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="w-full border rounded p-2" min="1" required>
            </div>
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded">Transfer</button>
        </form>
    </div>
</x-app-layout> 