<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vendor Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            950: '#082f49',
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                        'display': ['Poppins', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'bounce-gentle': 'bounceGentle 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        bounceGentle: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-5px)' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        .notification-badge {
            animation: bounceGentle 2s infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 font-sans">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-indigo-950 shadow-2xl relative z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center h-full">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                                <i class="fas fa-tshirt text-primary-600 text-lg"></i>
                            </div>
                            <span class="text-xl font-display font-bold text-white">UPTREND CLOTHING</span>
                        </div>
                        <div class="hidden md:flex h-full ml-12 space-x-1 relative">
                            @php
                                $vendorNavLinks = [
                                    ['route' => 'vendor.dashboard', 'icon' => 'fa-chart-line', 'label' => 'DASHBOARD'],
                                    ['route' => 'vendor.products.index', 'icon' => 'fa-box', 'label' => 'PRODUCTS', 'extra' => ['vendor.products.*']],
                                    ['route' => 'vendor.orders.index', 'icon' => 'fa-list', 'label' => 'ORDERS', 'pending' => true],
                                    ['route' => 'vendor.inventory', 'icon' => 'fa-warehouse', 'label' => 'INVENTORY'],
                                    ['route' => 'vendor.analytics', 'icon' => 'fa-chart-bar', 'label' => 'ANALYTICS'],
                                ];
                            @endphp
                            @foreach($vendorNavLinks as $link)
                                @php
                                    $isActive = request()->routeIs($link['route']) || (isset($link['extra']) && collect($link['extra'])->contains(fn($r) => request()->routeIs($r)));
                                @endphp
                                <div class="relative h-16 flex items-center" x-data="{hovered: false}">
                                    <a href="{{ route($link['route']) }}"
                                       class="flex items-center gap-2 text-white hover:text-blue-300 font-medium transition px-4 h-full whitespace-nowrap nav-link"
                                       @mouseenter="hovered = true" @mouseleave="hovered = false">
                                        <i class="fas {{ $link['icon'] }}"></i> {{ $link['label'] }}
                                        @if(isset($link['pending']) && !empty($pending_orders_count) && $pending_orders_count > 0)
                                            <span class="absolute -top-2 -right-2 bg-yellow-400 text-white text-xs rounded-full px-2 py-0.5 font-bold shadow notification-badge pending-orders-badge" title="Pending Orders">{{ $pending_orders_count }}</span>
                                        @endif
                                    </a>
                                    <!-- Active underline (white) -->
                                    <div class="absolute left-0 right-0 bottom-0 h-1 bg-white transition-all duration-300"
                                         :style="{{ $isActive ? 'true' : 'false' }} ? 'width:100%;opacity:1;' : 'width:0;opacity:0;'">
                                    </div>
                                    <!-- Hover underline (blue) -->
                                    <div class="absolute left-0 right-0 bottom-0 h-1 bg-blue-500 transition-all duration-300"
                                         :style="hovered ? 'width:100%;opacity:1;' : 'width:0;opacity:0;'">
                                    </div>
                                </div>
                            @endforeach
                            @if(isset($low_stock_inventories) && $low_stock_inventories->count())
                            <div class="relative group h-16 flex items-center mr-4">
                                <a href="{{ route('vendor.inventory') }}" class="relative focus:outline-none p-2 rounded-lg hover:bg-white/10 transition-colors">
                                    <i class="fas fa-bell text-white text-lg"></i>
                                    <span class="notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-2 py-1 font-bold">{{ $low_stock_inventories->count() }}</span>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative group ml-4">
                            <a href="{{ route('vendor.profile.edit') }}" class="relative focus:outline-none p-2 rounded-lg hover:bg-white/10 transition-colors">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </a>
                        </div>
                        <form method="POST" action="{{ route('vendor.logout') }}">
                            @csrf
                            <button type="submit" class="text-white hover:text-blue-200 px-4 py-2 rounded-lg hover:bg-white/10 transition-colors text-sm font-medium">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <script>
            // Live update for pending orders badge
            function updatePendingOrdersBadge() {
                fetch('/vendor/orders/pending-count')
                    .then(res => res.json())
                    .then(data => {
                        const badge = document.querySelector('.pending-orders-badge');
                        if (badge) {
                            if (data.count > 0) {
                                badge.textContent = data.count;
                                badge.style.display = '';
                            } else {
                                badge.style.display = 'none';
                            }
                        }
                    });
            }
            updatePendingOrdersBadge();
            setInterval(updatePendingOrdersBadge, 10000);
        </script>

        <!-- Main Content -->
        <main class="relative">
            <div id="page-animate" class="opacity-0 translate-y-8 transition-all duration-700">
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Footer -->
    <footer class="gradient-bg text-white mt-16">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-tshirt text-primary-600 text-lg"></i>
                        </div>
                        <span class="text-xl font-display font-bold">Uptrend Clothing Store LTD</span>
                    </div>
                    <p class="text-blue-100 text-sm">Your trusted partner in fashion retail management.</p>
                </div>
                <div class="space-y-4">
                    <h3 class="font-semibold text-lg">Contact Info</h3>
                    <div class="space-y-2 text-sm text-blue-100">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:info@uptrendclothing.com" class="hover:text-white transition-colors">info@uptrendclothing.com</a>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-phone"></i>
                            <a href="tel:+256700000000" class="hover:text-white transition-colors">+256 740 847 026</a>
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <h3 class="font-semibold text-lg">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="https://facebook.com" target="_blank" aria-label="Facebook" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank" aria-label="Twitter" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" aria-label="Instagram" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/20 mt-8 pt-8 text-center text-sm text-blue-100 flex flex-col md:flex-row items-center justify-between gap-2">
                <span>&copy; 2025 Uptrend Clothing Store LTD. All rights reserved.</span>
                <button onclick="document.getElementById('terms-modal').classList.remove('hidden')" class="underline hover:text-blue-300 focus:outline-none">Terms & Conditions</button>
            </div>
        </div>
    </footer>
    <!-- Terms Modal -->
    <div id="terms-modal" class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-8 relative">
            <button onclick="document.getElementById('terms-modal').classList.add('hidden')" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
            <h2 class="text-2xl font-bold mb-4 text-gray-900">Terms & Conditions</h2>
            <div class="text-gray-700 text-sm space-y-3 max-h-72 overflow-y-auto">
                <p>By using this platform, you agree to comply with all applicable laws and regulations. You are responsible for maintaining the confidentiality of your account and password.</p>
                <p>All content, trademarks, and data on this site are the property of Uptrend Clothing Store LTD. Unauthorized use is strictly prohibited.</p>
                <p>We reserve the right to modify or terminate the service for any reason, without notice, at any time.</p>
                <p>Your data is handled in accordance with our privacy policy. We do not share your personal information with third parties except as required by law.</p>
                <p>For more details, please contact our support team.</p>
            </div>
            <div class="mt-6 text-right">
                <button onclick="document.getElementById('terms-modal').classList.add('hidden')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Close</button>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="relative max-w-4xl max-h-full mx-4">
            <!-- Close Button -->
            <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 text-3xl font-bold transition-colors duration-300">
                <i class="fas fa-times"></i>
            </button>
            
            <!-- Modal Content -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 id="modalTitle" class="text-xl font-semibold text-gray-900"></h3>
                </div>
                <div class="p-6">
                    <img id="modalImage" src="" alt="" class="max-w-full max-h-96 object-contain rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('page-animate');
            if (el) {
                el.classList.remove('opacity-0', 'translate-y-8');
                el.classList.add('opacity-100', 'translate-y-0');
            }
        });

        // Image modal functions
        function openImageModal(imageSrc, imageAlt) {
            try {
                console.log('Opening modal for:', imageSrc, imageAlt);
                
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                const modalTitle = document.getElementById('modalTitle');
                
                if (!modal || !modalImage || !modalTitle) {
                    console.error('Modal elements not found!');
                    alert('Modal elements not found. Please refresh the page.');
                    return;
                }
                
                modalImage.src = imageSrc;
                modalImage.alt = imageAlt;
                modalTitle.textContent = imageAlt;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
                
                console.log('Modal should now be visible');
            } catch (error) {
                console.error('Error opening modal:', error);
                alert('Error opening image modal: ' + error.message);
            }
        }
        
        function closeImageModal() {
            console.log('Closing modal');
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }
        
        // Close modal when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeImageModal();
                    }
                });
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('imageModal').classList.contains('hidden')) {
                closeImageModal();
            }
        });
    </script>
    @stack('scripts')
</body>
</html> 