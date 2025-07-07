@extends('layouts.customer')

@section('content')
    <div class="max-w-md mx-auto py-8">
        <div class="bg-white rounded-2xl shadow p-8">
            <h1 class="text-3xl font-bold mb-6 text-blue-900">Sign Up</h1>
            <form method="POST" action="{{ route('customer.signup') }}">
                @csrf
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Name</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-6">
                    <label class="block font-semibold text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
                </div>
                <button type="submit" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-6 rounded w-full">Sign Up</button>
            </form>
        </div>
    </div>
@endsection 