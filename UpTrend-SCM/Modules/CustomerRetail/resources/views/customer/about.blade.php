@extends('customerretail::layouts.customer')

@section('content')
<div class="max-w-6xl mx-auto py-10">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl shadow-lg p-10 mb-10 flex flex-col md:flex-row items-center gap-8">
        <div class="flex-1">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 flex items-center gap-3">
                <i class="fas fa-tshirt"></i> About Uptrend
            </h1>
            <p class="text-lg text-blue-100 mb-4">Your one-stop clothing centre for quality, style, and confidence.</p>
            <a href="{{ route('customer.products') }}" class="inline-block mt-2 px-6 py-2 bg-white text-blue-700 font-bold rounded-lg shadow hover:bg-blue-100 transition">Shop Now</a>
        </div>
        <div class="flex-1 flex justify-center">
            <img src="https://img.freepik.com/free-photo/young-happy-african-woman-holding-shopping-bags_171337-11360.jpg?w=826&t=st=1689950000~exp=1689950600~hmac=demo" alt="Uptrend Clothing" class="rounded-2xl shadow-lg w-72 h-72 object-cover border-4 border-white">
        </div>
    </div>

    <!-- Company Story & Mission -->
    <div class="bg-white rounded-2xl shadow p-8 mb-10">
        <h2 class="text-2xl font-bold text-blue-900 mb-4 flex items-center gap-2"><i class="fas fa-store"></i> Our Story</h2>
        <p class="text-gray-700 mb-4">Founded in 2025 by five passionate entrepreneurs, Uptrend Clothing Store was born from a desire to bring affordable, high-quality fashion to everyone. We specialize in men’s and women’s apparel, offering a wide range of designs, colors, and sizes to suit every taste and occasion. Our commitment to quality means every item is carefully selected and inspected before it reaches our shelves.</p>
        <h3 class="text-xl font-semibold text-blue-800 mt-6 mb-2 flex items-center gap-2"><i class="fas fa-bullseye"></i> Our Mission</h3>
        <p class="text-gray-700 mb-2">To empower our customers to express themselves through fashion, while ensuring comfort, durability, and value in every purchase.</p>
        <h3 class="text-xl font-semibold text-blue-800 mt-6 mb-2 flex items-center gap-2"><i class="fas fa-heart"></i> Our Values</h3>
        <ul class="list-disc pl-6 text-gray-700 space-y-1">
            <li>Customer-first service</li>
            <li>Quality and authenticity</li>
            <li>Inclusivity in style and sizing</li>
            <li>Ethical sourcing and sustainability</li>
            <li>Community engagement</li>
        </ul>
    </div>

    <!-- Team Section -->
    <div class="bg-blue-50 rounded-2xl shadow p-8 mb-10">
        <h2 class="text-2xl font-bold text-blue-900 mb-6 flex items-center gap-2"><i class="fas fa-users"></i> Meet Our Team</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Gloria Nassanga -->
            <div class="flex flex-col items-center group">
                <div class="relative mb-4">
                    <div class="w-28 h-28 rounded-full border-4 border-blue-300 shadow-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center group-hover:border-blue-500 transition-all duration-300">
                        <span class="text-white text-2xl font-bold">GN</span>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-crown text-white text-sm"></i>
                    </div>
                </div>
                <div class="text-center">
                    <div class="font-bold text-blue-800 text-lg">GLORIA NASSANGA</div>
                    <div class="text-gray-600 text-sm mb-2">Founder & CEO</div>
                    <div class="text-xs text-gray-500">Fashion Visionary & Business Leader</div>
                </div>
            </div>

            <!-- Asher Simon Bukenya -->
            <div class="flex flex-col items-center group">
                <div class="relative mb-4">
                    <div class="w-28 h-28 rounded-full border-4 border-blue-300 shadow-lg bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center group-hover:border-blue-500 transition-all duration-300">
                        <span class="text-white text-2xl font-bold">ASB</span>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-sm"></i>
                    </div>
                </div>
                <div class="text-center">
                    <div class="font-bold text-blue-800 text-lg">ASHER SIMON BUKENYA</div>
                    <div class="text-gray-600 text-sm mb-2">Operations Director</div>
                    <div class="text-xs text-gray-500">Supply Chain & Logistics Expert</div>
                </div>
            </div>

            <!-- Mustafa Kavuma -->
            <div class="flex flex-col items-center group">
                <div class="relative mb-4">
                    <div class="w-28 h-28 rounded-full border-4 border-blue-300 shadow-lg bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center group-hover:border-blue-500 transition-all duration-300">
                        <span class="text-white text-2xl font-bold">MK</span>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-palette text-white text-sm"></i>
                    </div>
                </div>
                <div class="text-center">
                    <div class="font-bold text-blue-800 text-lg">MUSTAFA KAVUMA</div>
                    <div class="text-gray-600 text-sm mb-2">Creative Director</div>
                    <div class="text-xs text-gray-500">Style & Design Specialist</div>
                </div>
            </div>

            <!-- Hilda Nakabbubi -->
            <div class="flex flex-col items-center group">
                <div class="relative mb-4">
                    <div class="w-28 h-28 rounded-full border-4 border-blue-300 shadow-lg bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center group-hover:border-blue-500 transition-all duration-300">
                        <span class="text-white text-2xl font-bold">HN</span>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-white text-sm"></i>
                    </div>
                </div>
                <div class="text-center">
                    <div class="font-bold text-blue-800 text-lg">HILDA NAKABBUBI</div>
                    <div class="text-gray-600 text-sm mb-2">Quality Assurance</div>
                    <div class="text-xs text-gray-500">Product Standards & Testing</div>
                </div>
            </div>

            <!-- Jonathan Otimong -->
            <div class="flex flex-col items-center group">
                <div class="relative mb-4">
                    <div class="w-28 h-28 rounded-full border-4 border-blue-300 shadow-lg bg-gradient-to-br from-red-500 to-pink-600 flex items-center justify-center group-hover:border-blue-500 transition-all duration-300">
                        <span class="text-white text-2xl font-bold">JO</span>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-red-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-white text-sm"></i>
                    </div>
                </div>
                <div class="text-center">
                    <div class="font-bold text-blue-800 text-lg">JONATHAN OTIMONG</div>
                    <div class="text-gray-600 text-sm mb-2">Customer Support</div>
                    <div class="text-xs text-gray-500">Client Relations & Service</div>
                </div>
            </div>


        </div>
    </div>

    <!-- Contact & Address -->
    <div class="bg-white rounded-2xl shadow p-8 flex flex-col md:flex-row items-center gap-8">
        <div class="flex-1">
            <h2 class="text-xl font-bold text-blue-900 mb-2 flex items-center gap-2"><i class="fas fa-map-marker-alt"></i> Visit Us</h2>
            <div class="text-gray-700 mb-2">Physical Address: <span class="font-semibold">Kampala, Uganda</span></div>
            <div class="text-gray-700 mb-2">Tel: <span class="font-semibold">+256 700 000 000</span></div>
            <div class="text-gray-700 mb-2">Email: <span class="font-semibold">uptrendclothing09@gmail.com</span></div>
        </div>
        <div class="flex-1 flex flex-col items-center">
            <h2 class="text-xl font-bold text-blue-900 mb-2 flex items-center gap-2"><i class="fas fa-headset"></i> Need Help?</h2>
            <a href="{{ route('customer.contact') }}" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-3 px-8 rounded-lg shadow transition text-lg flex items-center gap-2"><i class="fas fa-envelope"></i> Contact Support Team</a>
        </div>
    </div>
</div>
@endsection 