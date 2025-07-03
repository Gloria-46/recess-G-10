<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Warehouse Staff') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased relative">
        <x-navbar />
        <!-- Dull, full-page background image -->
        <div class="fixed inset-0 w-full h-full -z-10">
            <img src="/images/uptrend-bg.jpg.jpg" alt="Background" class="w-full h-full object-cover" style="opacity:0.25;" />
        </div>
        @if (!Request::is('/'))
            <button id="toggleSidebar" style="position:fixed; top:1rem; left:1rem; z-index:1001; background:#fff; border:none; border-radius:4px; box-shadow:0 1px 4px rgba(0,0,0,0.08); padding:0.5rem 0.75rem; font-size:1.5rem; cursor:pointer;">☰</button>
            <x-sidebar />
            <div id="main-content" class="min-h-screen max-w-7xl mx-auto py-10 px-4" style="margin-left:200px; transition: margin-left 0.3s;">
        @else
            <div class="min-h-screen max-w-7xl mx-auto py-10 px-4">
        @endif
            @isset($header)
                <header class="bg-white shadow mb-8">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            <main>
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
        @if (!Request::is('/'))
        <script>
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleBtn = document.getElementById('toggleSidebar');
            // Check localStorage for sidebar state
            let sidebarVisible = localStorage.getItem('sidebarVisible') !== 'false';
            function showSidebar() {
                sidebar.style.left = '0';
                mainContent.style.marginLeft = '200px';
                sidebarVisible = true;
                localStorage.setItem('sidebarVisible', 'true');
            }
            function hideSidebar() {
                sidebar.style.left = '-200px';
                mainContent.style.marginLeft = '0';
                sidebarVisible = false;
                localStorage.setItem('sidebarVisible', 'false');
            }
            // Set initial state on page load
            if (sidebarVisible) {
                showSidebar();
            } else {
                hideSidebar();
            }
            toggleBtn.addEventListener('click', function() {
                if (sidebarVisible) {
                    hideSidebar();
                } else {
                    showSidebar();
                }
            });
        </script>
        @endif
    </body>
</html>
