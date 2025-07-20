@extends('customerretail::layouts.customer')

@section('content')
    @php $user = auth('customer')->user(); @endphp
    <div class="max-w-2xl mx-auto py-8">
        <div class="bg-white rounded-2xl shadow p-8">
            <h1 class="text-3xl font-bold mb-6 text-blue-900">Contact Us</h1>
            @if(session('success'))
                <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('customer.contact.send') }}">
                @csrf
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Your Name</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" placeholder="Enter your name" value="{{ $user->name ?? '' }}" @if($user) readonly @endif required>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Your Email</label>
                    <input type="email" name="email" class="w-full border rounded px-3 py-2" placeholder="Enter your email" value="{{ $user->email ?? '' }}" @if($user) readonly @endif required>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Message</label>
                    <textarea name="message" class="w-full border rounded px-3 py-2" rows="4" placeholder="Type your message" required></textarea>
                </div>
                <button type="submit" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-6 rounded">Send</button>
            </form>
        </div>
    </div>
@endsection 