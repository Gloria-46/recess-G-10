<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - UpTrend Customer</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body { overflow-x: hidden; }
        .chat-container { background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: calc(100vh - 80px); }
        .user-card { background: white; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.3s ease; border: 1px solid #e2e8f0; }
        .user-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); border-color: #8b5cf6; }
        .user-avatar { width: 50px; height: 50px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem; }
        .status-indicator { width: 12px; height: 12px; background: #10b981; border-radius: 50%; border: 2px solid white; position: absolute; bottom: 0; right: 0; }
        .chat-header { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: white; padding: 1.5rem; border-radius: 12px 12px 0 0; }
        .search-box { background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.75rem 1rem; transition: all 0.3s ease; }
        .search-box:focus { outline: none; border-color: #8b5cf6; box-shadow: 0 0 0 3px rgba(139,92,246,0.1); }
    </style>
</head>
<body class="bg-gray-50 overflow-x-hidden">
    <!-- Navigation -->
    <nav class="flex items-center justify-between px-6 py-4 bg-purple-950 text-white shadow-sm border-b">
        <div class="flex items-center gap-6 text-white">
            <div class="text-2xl font-bold">
                <i class="fas fa-tshirt mr-2"></i>
                UpTrend Clothing Store
            </div>
            <ul class="flex gap-8">
                <li>
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 text-white font-medium text-purple-400 border-b-2 border-purple-400 pb-1">
                        <i class="fas fa-chart-line"></i> DASHBOARD
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.products') }}" class="flex items-center gap-2 text-white hover:text-purple-400 transition-colors">
                        <i class="fas fa-shopping-bag"></i> PRODUCTS
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.orders') }}" class="flex items-center gap-2 text-white hover:text-purple-400 transition-colors">
                        <i class="fas fa-shopping-cart"></i> ORDERS
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.profile') }}" class="flex items-center gap-2 text-white hover:text-purple-400 transition-colors">
                        <i class="fas fa-user"></i> PROFILE
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.support') }}" class="flex items-center gap-2 text-white hover:text-purple-400 transition-colors">
                        <i class="fas fa-headset"></i> SUPPORT
                    </a>
                </li>
            </ul>
        </div>
        <div class="flex items-center gap-4">
            <div x-data="{ open: false }" class="relative text-sm text-white cursor-pointer select-none">
                <div @click="open = !open" class="flex items-center">
                    <a href="{{ route('customer.chat.index') }}" class="flex items-center">
                        <i class="fas fa-comment mr-2 text-purple-400"></i>
                        <span class="mr-4">Chat</span>
                    </a>
                    <i class="fas fa-user-circle mr-2"></i>
                    {{ Auth::user()->name ?? 'Customer' }}
                </div>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg z-50" style="display: none;">
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="chat-container p-6">
        <div class="max-w-4xl mx-auto">
            <div class="chat-header mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">Customer Support</h1>
                        <p class="text-purple-100">Get help from our support team</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 bg-white/10 px-3 py-2 rounded-lg">
                            <i class="fas fa-users text-purple-300"></i>
                            <span class="text-sm">{{ collect($groups)->flatten(1)->count() }} Support Agents</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-6">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search support agents..." class="search-box w-full pl-10 pr-4" x-data x-on:input="searchTerm = $event.target.value">
                </div>
            </div>
            @php $hasUsers = false; @endphp
            @foreach($groups as $role => $users)
                @if($users->count())
                    @php $hasUsers = true; @endphp
                    <h3 class="text-lg font-semibold mt-6 mb-2 text-purple-700">{{ $role }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        @foreach($users as $userItem)
                            <a href="{{ route('customer.chat.with', $userItem->id) }}" class="block">
                        <div class="user-card p-4">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="user-avatar">
                                                {{ strtoupper(substr($userItem->name, 0, 1)) }}
                                    </div>
                                    <div class="status-indicator"></div>
                                </div>
                                <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 mb-1">{{ $userItem->name }}</h3>
                                            <p class="text-sm text-gray-600 mb-2">{{ $userItem->email ?? '' }}</p>
                                    <div class="flex items-center gap-2">
                                                @if(($userItem->unread_count ?? 0) > 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        {{ $userItem->unread_count }} new
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
                @endif
            @endforeach
            @unless($hasUsers)
                <div class="text-center py-12">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No support agents available</h3>
                    <p class="text-gray-600">Our support team will be available soon. Please try again later.</p>
                </div>
            @endunless
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[placeholder="Search support agents..."]');
            const userCards = document.querySelectorAll('.user-card');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    userCards.forEach(card => {
                        const userName = card.querySelector('h3').textContent.toLowerCase();
                        const userEmail = card.querySelector('p').textContent.toLowerCase();
                        if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                            card.closest('a').style.display = 'block';
                        } else {
                            card.closest('a').style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>