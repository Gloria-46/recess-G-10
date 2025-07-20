@extends('customerretail::layouts.customer')

@section('content')
<div class="max-w-md mx-auto mt-12 bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold mb-6 text-blue-900 flex items-center gap-2"><i class="fas fa-sign-in-alt"></i> Customer Login</h2>
    @if($errors->any())
        <div class="mb-4 p-2 bg-red-100 text-red-800 rounded">
            {{ $errors->first() }}
        </div>
    @endif
    <form method="POST" action="{{ route('customer.login.submit') }}" class="space-y-4">
        @csrf
        <div>
            <label for="email" class="block font-semibold text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label for="password" class="block font-semibold text-gray-700">Password</label>
            <input type="password" name="password" id="password" required class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="w-full px-4 py-2 bg-blue-700 text-white rounded-lg font-semibold hover:bg-blue-900 transition">Login</button>
    </form>
    <div class="mt-4 flex justify-between text-sm">
        <a href="{{ route('customer.signup') }}" class="text-blue-700 hover:underline">Don't have an account? Sign Up</a>
        <a href="{{ route('customer.home') }}" class="text-gray-500 hover:underline">Back to Home</a>
    </div>
</div>
@endsection 