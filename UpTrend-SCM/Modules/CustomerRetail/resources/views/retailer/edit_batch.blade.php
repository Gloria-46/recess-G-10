@extends('customerretail::layouts.retailer')

@section('content')
<main class="max-w-2xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Edit Batch</h2>
    <form action="{{ route('retailer.inventory.batch.update', $batch->id) }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="batch_no" class="block text-sm font-medium text-gray-700">Batch Number</label>
            <input type="text" name="batch_no" id="batch_no" value="{{ old('batch_no', $batch->batch_no) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <label for="quantity_added" class="block text-sm font-medium text-gray-700">Quantity Added</label>
            <input type="number" name="quantity_added" id="quantity_added" min="1" value="{{ old('quantity_added', $batch->quantity_added) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div class="flex justify-end">
            <a href="{{ route('retailer.inventory') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 mr-2">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-indigo-950 text-white rounded hover:bg-indigo-800">Update Batch</button>
        </div>
    </form>
</main>
@endsection 