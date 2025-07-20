@extends('customerretail::layouts.retailer')

@section('content')
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl text-center font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    PRODUCTS
                </h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('retailer.products.create') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-2xl shadow-sm text-sm font-medium text-white bg-indigo-900 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    ADD PRODUCT
                </a>
            </div>
        </div>
        @if (session('success'))
            <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-2xl">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-50 to-purple-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Product Name</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Colors</th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Sizes</th>
                                    <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-4 py-4 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($products as $product)
                                    <tr class="hover:bg-blue-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    @if($product->image)
                                                        <img class="h-12 w-12 rounded-xl object-cover cursor-pointer hover:opacity-90 transition-opacity duration-300" 
                                                             src="{{ asset('storage/' . $product->image) }}" 
                                                             alt="{{ $product->name }}"
                                                             onclick="openImageModal('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}')">
                                                    @else
                                                        <span class="inline-block h-12 w-12 rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center">
                                                            <svg class="h-6 w-6 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M24 24H0V0h24v24z" fill="none"/>
                                                                <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                                                            </svg>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-base font-semibold text-blue-900">
                                                        <a href="{{ route('retailer.inventory.product', $product->id) }}" class="hover:underline">
                                                            {{ $product->name }}
                                                        </a>
                                                    </div>
                                                    <div class="text-xs text-gray-500">{{ $product->description }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->category ?? '-' }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">UGX {{ number_format($product->price, 2) }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->color }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->size }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold leading-5 {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('retailer.products.edit', $product) }}" class="inline-block text-blue-600 hover:text-blue-900 mr-4 font-semibold">Edit</a>
                                            <form action="{{ route('retailer.products.destroy', $product) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-block text-red-600 hover:text-red-900 font-semibold" onclick="return confirm('Are you sure you want to delete this product?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 whitespace-nowrap text-base text-gray-400 text-center">
                                            No products found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </main>
@endsection 