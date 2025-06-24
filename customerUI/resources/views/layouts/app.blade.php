<!DOCTYPE html>
<html>
<head>
    <title>Customer Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
    <a class="navbar-brand" href="{{ route('customer.dashboard') }}">MyApp</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('customer.profile') }}">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('customer.orders') }}">Orders</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('customer.support') }}">Support</a></li>
            <li class="nav-item"><a class="nav-link text-danger" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</nav>
<div class="container mt-4">
    @yield('content')
</div>
</body>
</html>
