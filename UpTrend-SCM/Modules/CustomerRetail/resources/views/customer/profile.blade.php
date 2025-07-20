@extends('customerretail::layouts.customer')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="bg-gradient-to-r from-[#23235b] to-blue-900 rounded-2xl shadow p-8">
        <h1 class="text-3xl font-bold mb-6 text-yellow-300">Profile</h1>
        <p class="text-blue-100"><strong>Name:</strong> {{ $user->name }}</p>
        <p class="text-blue-100"><strong>Email:</strong> {{ $user->email }}</p>
        @if($user->segment)
            <p class="text-yellow-200"><strong>Customer Segment:</strong> <span class="text-yellow-300">{{ $user->segment }}</span></p>
        @endif
        <!-- Add other profile fields as needed -->
    </div>
</div>
@endsection 