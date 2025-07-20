@extends('vendor::layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Supplier Details</h1>
            <div class="flex gap-2">
                <a href="{{ route('suppliers.edit', $supplier) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Edit Supplier
                </a>
                <a href="{{ route('suppliers.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                    Back to List
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Header with status -->
            <div class="bg-gray-50 px-6 py-4 border-b">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $supplier->name }}</h2>
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        {{ $supplier->status == 'active' ? 'bg-green-100 text-green-800' : 
                           ($supplier->status == 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst($supplier->status) }}
                    </span>
                </div>
                @if($supplier->category)
                    <p class="text-gray-600 mt-1">Category: {{ $supplier->category }}</p>
                @endif
            </div>

            <!-- Contact Information -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Contact Information</h3>
                        <div class="space-y-3">
                            @if($supplier->contact_person)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Contact Person:</span>
                                    <p class="text-gray-800">{{ $supplier->contact_person }}</p>
                                </div>
                            @endif
                            
                            @if($supplier->email)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Email:</span>
                                    <p class="text-gray-800">
                                        <a href="mailto:{{ $supplier->email }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $supplier->email }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            
                            @if($supplier->phone)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Phone:</span>
                                    <p class="text-gray-800">
                                        <a href="tel:{{ $supplier->phone }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $supplier->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            
                            @if($supplier->address)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Address:</span>
                                    <p class="text-gray-800">{{ $supplier->address }}</p>
                                </div>
                            @endif
                            
                            @if($supplier->country)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Country:</span>
                                    <p class="text-gray-800">{{ $supplier->country }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Business Information</h3>
                        <div class="space-y-3">
                            @if($supplier->payment_terms)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Payment Terms:</span>
                                    <p class="text-gray-800">{{ $supplier->payment_terms }}</p>
                                </div>
                            @endif
                            
                            @if($supplier->lead_time_days)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Lead Time:</span>
                                    <p class="text-gray-800">{{ $supplier->lead_time_days }} days</p>
                                </div>
                            @endif
                            
                            <div>
                                <span class="text-sm font-medium text-gray-500">Created:</span>
                                <p class="text-gray-800">{{ $supplier->created_at->format('M d, Y') }}</p>
                            </div>
                            
                            <div>
                                <span class="text-sm font-medium text-gray-500">Last Updated:</span>
                                <p class="text-gray-800">{{ $supplier->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($supplier->notes)
                    <div class="mt-6 pt-6 border-t">
                        <h3 class="text-lg font-medium text-gray-800 mb-3">Notes</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ $supplier->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 