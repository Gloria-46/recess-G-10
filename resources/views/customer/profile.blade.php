@extends('layouts.customer')

@section('content')
    <div class="max-w-2xl mx-auto py-8">
        <div class="bg-white rounded-2xl shadow p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-blue-900">Your Profile</h1>
                <a href="{{ route('customer.profile.edit') }}" class="bg-blue-700 hover:bg-blue-900 text-white font-semibold px-4 py-2 rounded-xl transition flex items-center gap-2"><i class="fas fa-edit"></i> Edit</a>
            </div>
            <p class="mb-4 text-gray-600">Your profile information will appear here. You can edit your details.</p>
            <!-- Example profile fields -->
            <form>
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Name</label>
                    <input type="text" class="w-full border rounded px-3 py-2" value="{{ $user->name ?? '' }}" disabled>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Email</label>
                    <input type="email" class="w-full border rounded px-3 py-2" value="{{ $user->email ?? '' }}" disabled>
                </div>
                <!-- Add more fields as needed -->
            </form>
        </div>
    </div>
@endsection 