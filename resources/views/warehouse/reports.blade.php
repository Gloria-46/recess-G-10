<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">Warehouse Reports</h1>
    </x-slot>
<div class="container">
    <h2>Reorder Report</h2>
    @if($reorderProducts->isEmpty())
        <p>All products are above their reorder levels.</p>
    @else
        <table class="min-w-full table-auto border-collapse border border-gray-300 mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Category</th>
                    <th class="border px-4 py-2">Quantity</th>
                    <th class="border px-4 py-2">Reorder Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reorderProducts as $product)
                    <tr>
                        <td class="border px-4 py-2">{{ $product->name }}</td>
                        <td class="border px-4 py-2">{{ $product->category }}</td>
                        <td class="border px-4 py-2">{{ $product->quantity }}</td>
                        <td class="border px-4 py-2">{{ $product->reorder_level }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</x-app-layout>