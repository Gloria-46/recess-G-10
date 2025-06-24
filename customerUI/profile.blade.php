@extends('layouts.app')

@section('content')
<h2>My Profile</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('customer.profile.update') }}">
    @csrf

    <div class="form-group mt-3">
        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
    </div>

    <div class="form-group mt-3">
        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
    </div>

    <div class="form-group mt-3">
        <label>Phone:</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
</form>
@endsection
