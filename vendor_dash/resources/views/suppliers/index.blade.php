<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers</title>
</head>
<body>
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Supplier Master List</h1>
        <a href="{{ route('suppliers.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">+ Add Supplier</a>
    </div>
    <form method="GET" action="{{ route('suppliers.index') }}" class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, contact, email, country..." class="border rounded px-3 py-2 w-full" />
        <select name="type" class="border rounded px-3 py-2 w-full">
            <option value="">All Types</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" @if(request('type') == $cat) selected @endif>{{ $cat }}</option>
            @endforeach
        </select>
        <select name="country" class="border rounded px-3 py-2 w-full">
            <option value="">All Locations</option>
            @foreach($countries as $country)
                <option value="{{ $country }}" @if(request('country') == $country) selected @endif>{{ $country }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-700 text-white rounded px-4 py-2 hover:bg-gray-800 transition">Filter</button>
    </form>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Type</th>
                    <th class="px-4 py-2 text-left">Contact</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Phone</th>
                    <th class="px-4 py-2 text-left">Country</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2 font-semibold">{{ $supplier->name }}</td>
                    <td class="px-4 py-2">{{ $supplier->category ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $supplier->contact_person }}</td>
                    <td class="px-4 py-2">{{ $supplier->email }}</td>
                    <td class="px-4 py-2">{{ $supplier->phone }}</td>
                    <td class="px-4 py-2">{{ $supplier->country }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded-full text-xs {{ $supplier->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($supplier->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-xs">Edit</a>
                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">No suppliers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $suppliers->links() }}</div>
    </div>
</div>
@endsection 
</body>
</html>