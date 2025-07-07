@extends('layouts.customer')

@section('content')
    @php $showSearchBar = true; @endphp
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-blue-900">Complete Your Payment</h1>
        
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4 text-blue-900">Order Summary</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Order Number</p>
                    <p class="font-semibold text-blue-900">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Total Amount</p>
                    <p class="font-semibold text-green-600 text-xl">UGX {{ number_format($order->total_amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Customer</p>
                    <p class="font-semibold text-blue-900">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Email</p>
                    <p class="font-semibold text-blue-900">{{ $order->customer_email }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Mobile Money Payment -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-blue-900">Mobile Money</h3>
                </div>
                
                <!-- Payment Instructions -->
                <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-blue-800 mb-2"><strong>Payment Instructions:</strong></p>
                    <p class="text-xs text-blue-700 mb-1">1. Select your mobile money provider below</p>
                    <p class="text-xs text-blue-700 mb-1">2. Enter your phone number</p>
                    <p class="text-xs text-blue-700 mb-1">3. Send payment to: <strong>{{ \App\Models\Payment::MERCHANT_NUMBER }}</strong></p>
                    <p class="text-xs text-blue-700 mb-1">4. Use your order number as reference</p>
                    <p class="text-xs text-blue-700">5. Confirm payment with your PIN when prompted</p>
                </div>
                
                <form action="{{ route('customer.payment.mobile-money') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Provider</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="payment_provider" value="airtel_money" class="mr-2" required>
                                <span class="text-blue-600 font-medium">Airtel Money</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_provider" value="mtn_money" class="mr-2" required>
                                <span class="text-yellow-600 font-medium">MTN Money</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" name="phone_number" id="phone_number" 
                               placeholder="e.g., 0777123456" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               pattern="[0-9]{10}" required>
                        <p class="text-xs text-gray-500 mt-1">Enter your 10-digit phone number</p>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition font-semibold">
                        Send Payment Request
                    </button>
                </form>
                <div class="mt-3 text-xs text-green-600 text-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    You will receive a payment message to confirm with your PIN
                </div>
            </div>

            <!-- Visa Card Payment -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-blue-900">Visa Card</h3>
                </div>
                
                <form action="{{ route('customer.payment.visa-card') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    
                    <div>
                        <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                        <input type="text" name="card_number" id="card_number" 
                               placeholder="1234 5678 9012 3456" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               pattern="[0-9]{16}" maxlength="16" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="expiry_month" class="block text-sm font-medium text-gray-700 mb-2">Month</label>
                            <select name="expiry_month" id="expiry_month" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">MM</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="expiry_year" class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                            <select name="expiry_year" id="expiry_year" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">YYYY</option>
                                @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="cvv" class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                            <input type="text" name="cvv" id="cvv" 
                                   placeholder="123" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   pattern="[0-9]{3,4}" maxlength="4" required>
                        </div>
                        <div>
                            <label for="cardholder_name" class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name</label>
                            <input type="text" name="cardholder_name" id="cardholder_name" 
                                   placeholder="JOHN DOE" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition font-semibold">
                        Pay with Visa Card
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('customer.cart') }}" class="text-blue-600 hover:text-blue-800 underline">
                ← Back to Cart
            </a>
        </div>
    </div>

    <script>
        // Format card number input
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        // Format CVV input
        document.getElementById('cvv').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        // Format phone number input
        document.getElementById('phone_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
    </script>
@endsection 