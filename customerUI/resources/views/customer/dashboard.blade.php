@extends('layouts.app')

@section('content')
<h2>Welcome, {{ Auth::user()->name }}</h2>
<p>This is your customer dashboard.</p>
<ul>
    <li>Email: {{ Auth::user()->email }}</li>
    <li>Phone: {{ Auth::user()->phone ?? 'Not set' }}</li>
</ul>
@endsection
