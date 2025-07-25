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

        <!-- Module Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Modern Theme CSS -->
        <link rel="stylesheet" href="/css/warehouse-modern-theme.css">
        
        <!-- Additional Dashboard Styles -->
        {{-- <style>
            .modern-body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
            }
            
            .modern-container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 2rem;
            }
            
            .modern-dashboard {
                background: transparent;
            }
        </style> --}}
        
        @yield('styles')
    </head>
    <body class="modern-body">
        @include('warehouse::components.navbar')
        <div class="modern-container" style="min-height: 100vh; padding: 2rem 0;">
            @isset($header)
                <header class="modern-card modern-mb-8">
                    <div class="modern-card-body">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            <main class="modern-fade-in">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
        @include('warehouse::components.footer')
        
        @yield('scripts')
    </body>
</html>
