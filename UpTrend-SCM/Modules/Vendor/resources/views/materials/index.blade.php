@extends('vendor::layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Materials & Products Catalog</h1>
        <a href="{{ route('materials.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">+ Add Material</a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('materials.index') }}" class="mb-6 bg-white rounded-lg shadow p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search materials..." 
                   class="border rounded px-3 py-2 w-full" />
            
            <select name="category" class="border rounded px-3 py-2 w-full">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" @if(request('category') == $cat) selected @endif>{{ $cat }}</option>
                @endforeach
            </select>
            
            <select name="supplier" class="border rounded px-3 py-2 w-full">
                <option value="">All Suppliers</option>
                @foreach($vendor_suppliers as $supplier)
                    <option value="{{ $supplier->id }}" @if(request('supplier') == $supplier->id) selected @endif>{{ $supplier->name }}</option>
                @endforeach
            </select>
            
            <button type="submit" class="bg-gray-700 text-white rounded px-4 py-2 hover:bg-gray-800 transition">Filter</button>
        </div>
    </form>

    <!-- Materials Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($materials as $material)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $material->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $material->supplier->name }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $material->status == 'available' ? 'bg-green-100 text-green-800' : 
                           ($material->status == 'out_of_stock' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $material->status)) }}
                    </span>
                </div>

                <!-- Category & Subcategory -->
                <div class="mb-4">
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-2">
                        {{ $material->category }}
                    </span>
                    @if($material->subcategory)
                        <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                            {{ $material->subcategory }}
                        </span>
                    @endif
                </div>

                <!-- Pricing & MOQ -->
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Price:</span>
                        <span class="font-semibold text-gray-800">UGX {{ number_format($material->unit_price, 2) }}/{{ $material->unit }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">MOQ:</span>
                        <span class="font-medium text-gray-800">{{ number_format($material->moq) }} {{ $material->unit }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Lead Time:</span>
                        <span class="font-medium text-gray-800">{{ $material->lead_time_days }} days</span>
                    </div>
                </div>

                <!-- Description -->
                @if($material->description)
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $material->description }}</p>
                @endif

                <!-- Actions -->
                <div class="flex gap-2 pt-4 border-t">
                    <a href="{{ route('materials.show', $material) }}" 
                       class="flex-1 text-center px-3 py-2 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                        View Details
                    </a>
                    <a href="{{ route('materials.edit', $material) }}" 
                       class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 text-sm">
                        Edit
                    </a>
                    <form action="{{ route('materials.destroy', $material) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this material?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200 text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No materials found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new material.</p>
                <div class="mt-6">
                    <a href="{{ route('materials.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Add Material
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $materials->links() }}
    </div>
</div>
@endsection 