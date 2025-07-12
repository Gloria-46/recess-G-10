<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .slide-up-fade-in {
            opacity: 0;
            transform: translateY(40px);
            animation: slideUpFadeInAnim 0.7s cubic-bezier(.4,0,.2,1) forwards;
        }
        @keyframes slideUpFadeInAnim {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Modern background patterns */
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(147, 51, 234, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.05) 0%, transparent 50%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: -1;
        }
        
        .floating-shape {
            position: absolute;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .floating-shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .nav-underline {
            position: relative;
        }
        .nav-underline::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 4px;
            background: #fff;
            border-radius: 2px;
            width: 0;
            opacity: 0;
            transition: width 0.3s cubic-bezier(.4,0,.2,1), opacity 0.3s;
        }
        .nav-underline.active::after,
        .nav-underline:hover::after {
            width: 100%;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen bg-pattern">
    <!-- Floating background shapes -->
    <div class="floating-shapes">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>
    
    <nav class="bg-[#23235b] shadow-2xl mb-4 glass-effect sticky top-0 z-50 h-20 backdrop-blur-lg bg-opacity-80 border-b border-blue-200/30 transition-all duration-300" aria-label="Main Navigation">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between gap-4">
            <!-- Only UPTREND on the left -->
            <div class="flex items-center flex-shrink-0">
                <span class="font-extrabold text-3xl text-white tracking-wider drop-shadow-lg">UPTREND</span>
            </div>
            <!-- Menu Items -->
            <div class="flex-1 flex justify-center">
                <div class="flex flex-nowrap items-center gap-2 md:gap-4">
                    @php
                        $navLinks = [
                            ['route' => 'customer.home', 'icon' => 'fa-home', 'label' => 'HOME'],
                            ['route' => 'customer.products', 'icon' => 'fa-box', 'label' => 'PRODUCT', 'extra' => ['customer.products.show']],
                            ['dropdown' => true, 'icon' => 'fa-th-large', 'label' => 'CATEGORIES', 'items' => [
                                ['route' => 'customer.products', 'label' => 'ALL PRODUCTS'],
                                ['route' => 'customer.products', 'label' => 'GENTLEMEN', 'params' => ['category' => 'gentlemen']],
                                ['route' => 'customer.products', 'label' => 'LADIES', 'params' => ['category' => 'ladies']],
                            ]],
                            ['route' => 'customer.cart', 'icon' => 'fa-shopping-cart', 'label' => 'CART'],
                            ['route' => 'customer.about', 'icon' => 'fa-info-circle', 'label' => 'ABOUT'],
                        ];
                    @endphp
                    @foreach($navLinks as $link)
                        @if(isset($link['dropdown']) && $link['dropdown'])
                            <div class="relative group flex items-center h-full">
                                <button type="button" class="flex items-center h-full px-4 py-2 rounded-xl transition-all duration-200 text-white text-lg gap-2 nav-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2 focus-visible:bg-blue-900/30 group-hover:bg-white/10 group-hover:text-yellow-200">
                                    <i class="fas {{ $link['icon'] }}"></i> {{ $link['label'] }} <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                </button>
                                <div class="absolute left-0 mt-14 min-w-[180px] bg-[#23235b] rounded-xl shadow-xl z-50 py-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 translate-y-2 pointer-events-none group-hover:pointer-events-auto transition-all duration-200 border border-blue-900">
                                    @foreach($link['items'] as $item)
                                        <a href="{{ isset($item['params']) ? route($item['route'], $item['params']) : route($item['route']) }}" class="block px-6 py-3 text-white hover:bg-blue-900 hover:text-yellow-300 transition text-base whitespace-nowrap">{{ $item['label'] }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="flex items-center h-full">
                                <a href="{{ route($link['route']) }}"
                                   class="flex items-center h-full px-4 py-2 rounded-xl transition-all duration-200 {{ (request()->routeIs($link['route']) || (isset($link['extra']) && collect($link['extra'])->contains(fn($r) => request()->routeIs($r)))) ? 'bg-white/20 text-yellow-300 font-bold shadow-inner' : 'hover:bg-white/10 hover:text-yellow-200 text-white' }} text-lg gap-2 nav-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2 focus-visible:bg-blue-900/30"
                                   aria-label="{{ $link['label'] }}">
                                    <i class="fas {{ $link['icon'] }}"></i> {{ $link['label'] }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <!-- Profile/Logout -->
            <div class="flex items-center gap-x-4 relative h-12 flex-shrink-0" x-data="{ openProfileDropdown: false }">
                @if(!Auth::guard('customer')->check())
                    <div class="flex items-center h-12 gap-3 whitespace-nowrap">
                        <a href="{{ route('customer.signup') }}" class="flex items-center gap-2 text-white hover:text-yellow-200 font-medium transition h-full whitespace-nowrap px-3 py-2 rounded-xl hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400" aria-label="Sign Up"><i class="fas fa-user-plus"></i> Sign Up</a>
                        <a href="{{ route('customer.login') }}" class="flex items-center gap-2 text-white hover:text-yellow-200 font-medium transition h-full whitespace-nowrap px-3 py-2 rounded-xl hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400" aria-label="Login"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </div>
                @else
                    <div class="flex items-center h-12 gap-3 whitespace-nowrap">
                        <button type="button" class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center cursor-pointer hover:scale-105 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400" @click="openProfileDropdown = !openProfileDropdown" title="Profile" tabindex="0" aria-label="Profile">
                            <i class="fas fa-user text-white text-lg"></i>
                        </button>
                        <div x-show="openProfileDropdown" @click.away="openProfileDropdown = false" class="absolute right-0 mt-14 w-56 bg-white rounded-xl shadow-2xl z-50 p-3 border border-blue-100 animate-fade-in-up" style="display: none;" x-transition>
                            <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50 rounded transition flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400" aria-label="Profile"><i class="fas fa-user"></i> Profile</a>
                            <a href="{{ route('customer.orders') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-50 rounded transition flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400" aria-label="Order History"><i class="fas fa-history"></i> Order History</a>
                        </div>
                        <form action="{{ route('customer.logout') }}" method="POST" class="inline h-full flex items-center">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 text-white hover:text-yellow-200 font-medium transition h-full whitespace-nowrap px-3 py-2 rounded-xl hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400" aria-label="Log Out"><i class="fas fa-sign-out-alt"></i> Log Out</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <div class="absolute left-0 right-0 bottom-0 h-1 bg-gradient-to-r from-blue-400 via-purple-400 to-blue-400 opacity-40"></div>
    </nav>

    @if(!empty($showSearchBar))
    <div class="glass-effect shadow-lg py-6 px-4 flex justify-center items-center mb-6 z-0 relative">
        <form action="{{ route('customer.products.search') }}" method="GET" class="w-full max-w-xl flex gap-3">
            <div class="flex-1 relative">
                <input type="text" name="query" value="{{ request('query') }}" placeholder="Search for products..." 
                       class="w-full px-6 py-3 border-0 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-lg bg-white/80 backdrop-blur-sm" required>
                <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
                Search
            </button>
        </form>
    </div>
    @endif
    <div class="container mx-auto px-4 min-h-[60vh] slide-up-fade-in relative z-10">
        @yield('content')
    </div>
    <footer class="bg-gray-900 text-gray-200 mt-12" x-data="{ showTerms: false, showPrivacy: false, showShipping: false, showReturns: false }">
        <!-- Main Footer Content -->
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-tshirt text-white text-xl"></i>
                        </div>
                        <span class="font-bold text-xl text-blue-400">UPTREND CLOTHING</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Your premier destination for trendy fashion. We offer quality clothing with excellent customer service and fast delivery.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" target="_blank" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('customer.home') }}" class="hover:text-blue-400 transition">Home</a></li>
                        <li><a href="{{ route('customer.products') }}" class="hover:text-blue-400 transition">All Products</a></li>
                        <li><a href="{{ route('customer.products', ['category' => 'ladies']) }}" class="hover:text-blue-400 transition">Ladies Collection</a></li>
                        <li><a href="{{ route('customer.products', ['category' => 'gentlemen']) }}" class="hover:text-blue-400 transition">Gentlemen Collection</a></li>
                        <li><a href="{{ route('customer.about') }}" class="hover:text-blue-400 transition">About Us</a></li>
                        <li><a href="{{ route('customer.contact') }}" class="hover:text-blue-400 transition">Contact</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">Customer Service</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition" @click="showShipping = true">Shipping Info</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition" @click="showReturns = true">Returns & Exchanges</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition" @click="showPrivacy = true">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition" @click="showTerms = true">Terms & Conditions</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Size Guide</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Care Instructions</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">Contact Info</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-blue-400 mt-1"></i>
                            <div>
                                <p class="font-medium">Address</p>
                                <p class="text-gray-400">Kampala, Uganda</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-phone text-blue-400 mt-1"></i>
                            <div>
                                <p class="font-medium">Phone</p>
                                <p class="text-gray-400">+256 742 954 755</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-envelope text-blue-400 mt-1"></i>
                            <div>
                                <p class="font-medium">Email</p>
                                <p class="text-gray-400">info@uptrendclothing.com</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-clock text-blue-400 mt-1"></i>
                            <div>
                                <p class="font-medium">Business Hours</p>
                                <p class="text-gray-400">Mon-Fri: 8AM-6PM</p>
                                <p class="text-gray-400">Sat: 9AM-4PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4 text-sm">
                        <span>&copy; {{ date('Y') }} Uptrend Clothing Store. All rights reserved.</span>
                        <span class="hidden md:inline">|</span>
                        <span>Made with ❤️ in Uganda</span>
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <span>Secure Payment:</span>
                        <div class="flex gap-2">
                            <i class="fab fa-cc-visa text-xl text-blue-400"></i>
                            <i class="fab fa-cc-mastercard text-xl text-blue-400"></i>
                            <i class="fas fa-mobile-alt text-xl text-blue-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terms & Conditions Modal -->
        <div x-show="showTerms" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-8 relative">
                <button @click="showTerms = false" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-xl">&times;</button>
                <h2 class="text-2xl font-bold mb-4 text-blue-900">Terms & Conditions</h2>
                <div class="text-gray-700 text-sm space-y-3 max-h-96 overflow-y-auto">
                    <p><strong>1. Product Information:</strong> We strive to ensure all product descriptions, images, and prices are accurate. However, slight variations in color or size may occur due to monitor settings or manufacturing processes.</p>
                    <p><strong>2. Orders & Payment:</strong> All orders are subject to acceptance and availability. Payment must be made in full before dispatch. We reserve the right to cancel or refuse any order at our discretion.</p>
                    <p><strong>3. Shipping & Delivery:</strong> Delivery times are estimates and may vary. We are not responsible for delays caused by third-party couriers or unforeseen circumstances.</p>
                    <p><strong>4. Returns & Exchanges:</strong> Items may be returned or exchanged within 7 days of receipt, provided they are unworn, unwashed, and in original condition with tags attached. Sale items are final and non-returnable.</p>
                    <p><strong>5. Privacy:</strong> Customer information is kept confidential and used only for order processing and communication. We do not share your data with third parties except as required to fulfill your order.</p>
                    <p><strong>6. Liability:</strong> We are not liable for any indirect, incidental, or consequential damages arising from the use of our products or website.</p>
                    <p><strong>7. Changes to Terms:</strong> We reserve the right to update these terms at any time. Continued use of our website constitutes acceptance of the latest terms.</p>
                </div>
            </div>
        </div>

        <!-- Privacy Policy Modal -->
        <div x-show="showPrivacy" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-8 relative">
                <button @click="showPrivacy = false" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-xl">&times;</button>
                <h2 class="text-2xl font-bold mb-4 text-blue-900">Privacy Policy</h2>
                <div class="text-gray-700 text-sm space-y-3 max-h-96 overflow-y-auto">
                    <p><strong>1. Information We Collect:</strong> We collect information you provide directly to us, such as when you create an account, make a purchase, or contact us for support.</p>
                    <p><strong>2. How We Use Your Information:</strong> We use the information we collect to process your orders, communicate with you, and improve our services.</p>
                    <p><strong>3. Information Sharing:</strong> We do not sell, trade, or otherwise transfer your personal information to third parties except as described in this policy.</p>
                    <p><strong>4. Data Security:</strong> We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>
                    <p><strong>5. Cookies:</strong> We use cookies to enhance your browsing experience and analyze site traffic.</p>
                    <p><strong>6. Your Rights:</strong> You have the right to access, correct, or delete your personal information. Contact us to exercise these rights.</p>
                </div>
            </div>
        </div>

        <!-- Shipping Information Modal -->
        <div x-show="showShipping" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-8 relative">
                <button @click="showShipping = false" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-xl">&times;</button>
                <h2 class="text-2xl font-bold mb-4 text-blue-900">Shipping Information</h2>
                <div class="text-gray-700 text-sm space-y-3 max-h-96 overflow-y-auto">
                    <p><strong>1. Delivery Areas:</strong> We currently deliver to all major cities and towns in Uganda.</p>
                    <p><strong>2. Delivery Time:</strong> Standard delivery takes 30-60 minutes within Kampala and 2-5 business days for other areas.This can be subject to quantity purchased.</p>
                    <p><strong>3. Shipping Cost:</strong> Free shipping on orders above UGX 500,000. Standard delivery fee is UGX 5,000 within the City and can vary depending on the location and quantity purchased.</p>
                    <p><strong>4. Order Tracking:</strong> You will receive tracking information via email once your order ships.</p>
                    <p><strong>5. Delivery Options:</strong> We offer both home delivery and pickup from our store location.</p>
                    <p><strong>6. International Shipping:</strong> Currently available for select countries. Contact us for rates and availability.</p>
                </div>
            </div>
        </div>

        <!-- Returns & Exchanges Modal -->
        <div x-show="showReturns" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-8 relative">
                <button @click="showReturns = false" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-xl">&times;</button>
                <h2 class="text-2xl font-bold mb-4 text-blue-900">Returns & Exchanges</h2>
                <div class="text-gray-700 text-sm space-y-3 max-h-96 overflow-y-auto">
                    <p><strong>1. Return Policy:</strong> Items may be returned within 7 days of receipt for a full refund or exchange.</p>
                    <p><strong>2. Return Conditions:</strong> Items must be unworn, unwashed, and in original condition with all tags attached.</p>
                    <p><strong>3. Exchanges:</strong> We offer free exchanges for different sizes or colors, subject to availability.</p>
                    <p><strong>4. Refund Process:</strong> Refunds will be processed within 5-7 business days after we receive your return.</p>
                    <p><strong>5. Return Shipping:</strong> Customers are responsible for return shipping costs unless the item is defective.</p>
                    <p><strong>6. Sale Items:</strong> Sale and clearance items are final sale and cannot be returned or exchanged.</p>
                </div>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trigger = document.getElementById('categories-trigger');
            const dropdown = document.getElementById('categories-dropdown');
            let dropdownTimeout;

            function showDropdown() {
                clearTimeout(dropdownTimeout);
                dropdown.style.display = 'block';
            }
            function hideDropdown() {
                dropdownTimeout = setTimeout(() => {
                    dropdown.style.display = 'none';
                }, 120); // short delay for smoothness
            }

            trigger.addEventListener('mouseenter', showDropdown);
            trigger.addEventListener('mouseleave', hideDropdown);
            dropdown.addEventListener('mouseenter', showDropdown);
            dropdown.addEventListener('mouseleave', hideDropdown);
        });
    </script>
</body>
</html> 