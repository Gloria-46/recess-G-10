@extends('warehouse::layouts.app')

@section('content')
    <style>
        .profile-hero {
            background: linear-gradient(90deg, #2563eb 0%, #1e3a8a 100%);
            padding: 3rem 0 5rem 0;
            text-align: center;
            color: #fff;
            position: relative;
        }
        .profile-avatar {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 4px 24px rgba(30,58,138,0.12);
            margin-bottom: 1rem;
            background: #f1f5f9;
        }
        .profile-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(30,58,138,0.10);
            padding: 2.5rem 2rem 2rem 2rem;
            margin-top: -70px;
            max-width: 520px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            z-index: 2;
        }
        .profile-name {
            font-size: 2rem;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 0.2rem;
        }
        .profile-email {
            color: #64748b;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }
        .profile-section {
            background: #f8fafc;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(30,58,138,0.06);
            padding: 2rem 1.5rem;
            margin-bottom: 2rem;
        }
        .profile-section h3 {
            color: #1e3a8a;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        @media (max-width: 600px) {
            .profile-card { padding: 1.2rem 0.5rem; }
            .profile-section { padding: 1.2rem 0.5rem; }
        }
    </style>
    <div class="profile-hero">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=220&background=2563eb&color=fff" alt="Avatar" class="profile-avatar">
        <div class="profile-name">{{ Auth::user()->name }}</div>
        <div class="profile-email">{{ Auth::user()->email }}</div>
    </div>
    <div class="profile-card">
        <div class="profile-section">
            <h3>Profile Information</h3>
            @include('warehouse::profile.partials.update-profile-information-form')
        </div>
        <div class="profile-section">
            <h3>Update Password</h3>
            @include('warehouse::profile.partials.update-password-form')
        </div>
        <div class="profile-section">
            <h3>Delete Account</h3>
            @include('warehouse::profile.partials.delete-user-form')
        </div>
    </div>
@endsection
