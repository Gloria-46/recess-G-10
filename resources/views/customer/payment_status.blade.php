@extends('layouts.customer')

@section('content')
    @php $showSearchBar = true; @endphp
    <div class="max-w-2xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-blue-900">Payment Status</h1>
        
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="text-center mb-6">
                @if($payment->isCompleted())
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-green-600 mb-2">Payment Successful!</h2>
                    <p class="text-gray-600">Your payment has been processed successfully.</p>
                @elseif($payment->isFailed())
                    <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-red-600 mb-2">Payment Failed</h2>
                    <p class="text-gray-600">{{ $payment->error_message ?? 'Your payment could not be processed.' }}</p>
                @else
                    <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-yellow-600 mb-2">Processing Payment</h2>
                    <p class="text-gray-600">Please wait while we process your payment...</p>
                    
                    @if($payment->payment_method === 'mobile_money')
                        <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <h4 class="font-semibold text-yellow-800 mb-2">Mobile Money Payment</h4>
                            <p class="text-sm text-yellow-700 mb-2">You should receive a payment confirmation message on your phone.</p>
                            <p class="text-sm text-yellow-700 mb-1">• Check your phone for the payment message</p>
                            <p class="text-sm text-yellow-700 mb-1">• Enter your PIN to confirm the payment</p>
                            <p class="text-sm text-yellow-700">• Wait for the confirmation SMS</p>
                        </div>
                    @endif
                @endif
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold mb-4 text-blue-900">Payment Details</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Transaction ID:</span>
                        <span class="font-semibold text-blue-900">{{ $payment->transaction_id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order Number:</span>
                        <span class="font-semibold text-blue-900">{{ $payment->order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount:</span>
                        <span class="font-semibold text-green-600">{{ $payment->getFormattedAmount() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-semibold text-blue-900">{{ $payment->getPaymentMethodDisplay() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Provider:</span>
                        <span class="font-semibold text-blue-900">{{ $payment->getPaymentProviderDisplay() }}</span>
                    </div>
                    @if($payment->phone_number)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Customer Phone:</span>
                            <span class="font-semibold text-blue-900">{{ $payment->phone_number }}</span>
                        </div>
                    @endif
                    @if($payment->payment_method === 'mobile_money')
                        <div class="flex justify-between">
                            <span class="text-gray-600">Merchant Number:</span>
                            <span class="font-semibold text-green-600">{{ \App\Models\Payment::MERCHANT_NUMBER }}</span>
                        </div>
                    @endif
                    @if($payment->card_last_four)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Card:</span>
                            <span class="font-semibold text-blue-900">**** **** **** {{ $payment->card_last_four }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-semibold 
                            @if($payment->isCompleted()) text-green-600
                            @elseif($payment->isFailed()) text-red-600
                            @else text-yellow-600 @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    @if($payment->paid_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Paid At:</span>
                            <span class="font-semibold text-blue-900">{{ $payment->paid_at->format('M d, Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>

                            @if($payment->isCompleted())
                    <div class="mt-6 p-4 bg-green-50 rounded-lg">
                        <h4 class="font-semibold text-green-800 mb-2">Payment Successful!</h4>
                        <ul class="text-sm text-green-700 space-y-1">
                            <li>• Payment confirmed with PIN on {{ \App\Models\Payment::MERCHANT_NUMBER }}</li>
                            <li>• You will receive an email confirmation</li>
                            <li>• The vendor will be notified of your order</li>
                            <li>• Your order will be processed and shipped</li>
                            <li>• You can track your order in your profile</li>
                        </ul>
                    </div>
                                @elseif($payment->isFailed())
                    <div class="mt-6 p-4 bg-red-50 rounded-lg">
                        <h4 class="font-semibold text-red-800 mb-2">Payment Failed</h4>
                        <ul class="text-sm text-red-700 space-y-1">
                            <li>• Ensure you sent payment to {{ \App\Models\Payment::MERCHANT_NUMBER }}</li>
                            <li>• Check your PIN and try again</li>
                            <li>• Use your order number as reference</li>
                            <li>• Verify your mobile money balance</li>
                            <li>• Try the payment again or contact support</li>
                        </ul>
                    </div>
            @endif

            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                @if($payment->isCompleted())
                    <a href="{{ route('customer.home') }}" 
                       class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition font-semibold text-center">
                        Continue Shopping
                    </a>
                    <a href="{{ route('customer.orders') }}" 
                       class="flex-1 bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition font-semibold text-center">
                        View Orders
                    </a>
                @elseif($payment->isFailed())
                    <a href="{{ route('customer.payment.form', ['order_id' => $payment->order->id]) }}" 
                       class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition font-semibold text-center">
                        Try Again
                    </a>
                    <a href="{{ route('customer.cart') }}" 
                       class="flex-1 bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 transition font-semibold text-center">
                        Back to Cart
                    </a>
                @else
                    <button onclick="checkPaymentStatus()" 
                            class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition font-semibold">
                        Refresh Status
                    </button>
                    <a href="{{ route('customer.payment.cancel', $payment->id) }}" 
                       onclick="return confirm('Are you sure you want to cancel this payment?')"
                       class="flex-1 bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition font-semibold text-center">
                        Cancel Payment
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if(!$payment->isCompleted() && !$payment->isFailed())
        <script>
            // Auto-refresh payment status every 3 seconds
            let statusCheckInterval = setInterval(checkPaymentStatus, 3000);
            
            function checkPaymentStatus() {
                fetch('{{ route("customer.payment.check-status", $payment->id) }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.is_completed || data.is_failed) {
                            clearInterval(statusCheckInterval);
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error checking payment status:', error);
                    });
            }
        </script>
    @endif
@endsection 