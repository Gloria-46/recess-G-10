@extends('layouts.customer')

@section('content')
<div class="max-w-xl mx-auto mt-12 bg-white rounded-2xl shadow-lg p-8">
    <h2 class="text-3xl font-bold text-blue-900 mb-4 flex items-center">
        <i class="fas fa-user-circle mr-3 text-blue-600"></i>
        Your Profile
    </h2>
    <p class="text-gray-600 mb-8">Your profile information will appear here. You can edit your details.</p>
    <div class="space-y-6">
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Name</label>
            <input type="text" value="{{ $user->name ?? '' }}" readonly class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-800 font-medium focus:outline-none">
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Email</label>
            <input type="email" value="{{ $user->email ?? '' }}" readonly class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-800 font-medium focus:outline-none">
        </div>
        <!-- Add more fields here if needed -->
    </div>
    <div class="mt-8 flex justify-end">
        <a href="{{ route('customer.profile.edit') }}" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            <i class="fas fa-edit mr-2"></i> Edit
        </a>
    </div>
</div>
@endsection 