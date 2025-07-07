@extends('layouts.customer')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow p-8">
        <h1 class="text-3xl font-bold mb-6 text-blue-900">Edit Profile</h1>
        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('customer.profile.update') }}">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold text-gray-700">Name</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold text-gray-700">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold text-gray-700">New Password <span class="text-gray-500 text-sm">(leave blank to keep current)</span></label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-6">
                <label class="block font-semibold text-gray-700">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-blue-700 hover:bg-blue-900 text-white font-semibold px-6 py-2 rounded-xl transition">Save Changes</button>
            <a href="{{ route('customer.profile') }}" class="ml-4 text-gray-600 hover:text-blue-700 transition">Cancel</a>
        </form>
    </div>
</div>
@endsection 