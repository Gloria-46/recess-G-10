@extends('layouts.retailer')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Retailer Profile</h1>
    <div class="bg-white rounded-xl shadow-lg p-8 mb-8 max-w-lg mx-auto border border-blue-100">
        <dl class="divide-y divide-blue-50">
            <div class="py-3 flex justify-between items-center">
                <dt class="font-semibold text-blue-900">Business Name:</dt>
                <dd class="text-gray-800">{{ $retailer->business_name ?? $retailer->businessName ?? '-' }}</dd>
            </div>
            <div class="py-3 flex justify-between items-center">
                <dt class="font-semibold text-blue-900">Email:</dt>
                <dd class="text-gray-800">{{ $retailer->email }}</dd>
            </div>
            <div class="py-3 flex justify-between items-center">
                <dt class="font-semibold text-blue-900">Phone:</dt>
                <dd class="text-gray-800">{{ $retailer->phone ?? $retailer->contact ?? '-' }}</dd>
            </div>
            <div class="py-3 flex justify-between items-center">
                <dt class="font-semibold text-blue-900">Address:</dt>
                <dd class="text-gray-800">{{ $retailer->address ?? '-' }}</dd>
            </div>
            <div class="py-3 flex justify-between items-center">
                <dt class="font-semibold text-blue-900">About:</dt>
                <dd class="text-gray-800">{{ $retailer->about ?? '-' }}</dd>
            </div>
            <div class="py-3 flex justify-between items-center">
                <dt class="font-semibold text-blue-900">Year of Establishment:</dt>
                <dd class="text-gray-800">{{ $retailer->yearOfEstablishment ?? '-' }}</dd>
            </div>
            <div class="py-3 flex justify-between items-center">
                <dt class="font-semibold text-blue-900">Active:</dt>
                <dd class="text-gray-800">{{ $retailer->is_active ? 'Yes' : 'No' }}</dd>
            </div>
        </dl>
    </div>
    <div class="text-center">
        <a href="{{ route('retailer.profile.edit') }}" class="inline-block bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-8 rounded shadow transition">Edit Profile</a>
    </div>
@endsection 