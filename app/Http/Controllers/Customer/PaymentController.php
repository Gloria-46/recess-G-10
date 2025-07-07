<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function showPaymentForm(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = Order::findOrFail($orderId);
        
        return view('customer.payment', compact('order'));
    }

    public function processMobileMoney(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'phone_number' => 'required|string|regex:/^[0-9]{10}$/',
            'payment_provider' => 'required|in:airtel_money,mtn_money',
        ]);

        $order = Order::findOrFail($request->order_id);
        
        // Check if payment already exists
        if ($order->hasPayment()) {
            return redirect()->back()->with('error', 'Payment already exists for this order.');
        }

        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => Payment::METHOD_MOBILE_MONEY,
            'payment_provider' => $request->payment_provider,
            'transaction_id' => 'MM-' . strtoupper(Str::random(12)),
            'amount' => $order->total_amount,
            'currency' => 'UGX',
            'status' => Payment::STATUS_PENDING,
            'phone_number' => $request->phone_number,
        ]);

        // Simulate payment processing
        $this->processMobileMoneyPayment($payment);

        return redirect()->route('customer.payment.status', $payment->id)
            ->with('success', 'Payment initiated successfully!');
    }

    public function processVisaCard(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'card_number' => 'required|string|regex:/^[0-9]{16}$/',
            'expiry_month' => 'required|integer|between:1,12',
            'expiry_year' => 'required|integer|min:' . date('Y'),
            'cvv' => 'required|string|regex:/^[0-9]{3,4}$/',
            'cardholder_name' => 'required|string|max:255',
        ]);

        $order = Order::findOrFail($request->order_id);
        
        // Check if payment already exists
        if ($order->hasPayment()) {
            return redirect()->back()->with('error', 'Payment already exists for this order.');
        }

        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => Payment::METHOD_VISA_CARD,
            'payment_provider' => Payment::PROVIDER_VISA,
            'transaction_id' => 'VC-' . strtoupper(Str::random(12)),
            'amount' => $order->total_amount,
            'currency' => 'UGX',
            'status' => Payment::STATUS_PENDING,
            'card_last_four' => substr($request->card_number, -4),
            'card_type' => 'visa',
            'payment_details' => [
                'cardholder_name' => $request->cardholder_name,
                'expiry_month' => $request->expiry_month,
                'expiry_year' => $request->expiry_year,
            ],
        ]);

        // Simulate payment processing
        $this->processVisaCardPayment($payment, $request);

        return redirect()->route('customer.payment.status', $payment->id)
            ->with('success', 'Payment initiated successfully!');
    }

    public function showPaymentStatus($paymentId)
    {
        $payment = Payment::with('order')->findOrFail($paymentId);
        
        return view('customer.payment_status', compact('payment'));
    }

    public function checkPaymentStatus($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        
        return response()->json([
            'status' => $payment->status,
            'is_completed' => $payment->isCompleted(),
            'is_failed' => $payment->isFailed(),
        ]);
    }

    private function processMobileMoneyPayment(Payment $payment)
    {
        // Simulate payment processing delay (including PIN confirmation)
        sleep(3);

        // Simulate success/failure (90% success rate for demo)
        $isSuccess = rand(1, 10) <= 9;

        if ($isSuccess) {
            $payment->markAsCompleted();
            
            // Handle payment completion
            $paymentService = new PaymentService();
            $paymentService->handlePaymentCompletion($payment);
            
            Log::info('Mobile money payment completed with PIN confirmation', [
                'payment_id' => $payment->id,
                'transaction_id' => $payment->transaction_id,
                'amount' => $payment->amount,
                'merchant_number' => Payment::MERCHANT_NUMBER,
                'payment_provider' => $payment->payment_provider,
                'pin_confirmed' => true,
            ]);
        } else {
            $payment->markAsFailed('Payment was declined. Please check your PIN and try again.');
            
            // Handle payment failure
            $paymentService = new PaymentService();
            $paymentService->handlePaymentFailure($payment);
            
            Log::warning('Mobile money payment failed - PIN issue', [
                'payment_id' => $payment->id,
                'transaction_id' => $payment->transaction_id,
                'merchant_number' => Payment::MERCHANT_NUMBER,
                'payment_provider' => $payment->payment_provider,
                'pin_confirmed' => false,
            ]);
        }
    }

    private function processVisaCardPayment(Payment $payment, Request $request)
    {
        // Simulate payment processing delay
        sleep(3);

        // Simulate success/failure (85% success rate for demo)
        $isSuccess = rand(1, 20) <= 17;

        if ($isSuccess) {
            $payment->markAsCompleted();
            
            // Handle payment completion
            $paymentService = new PaymentService();
            $paymentService->handlePaymentCompletion($payment);
            
            Log::info('Visa card payment completed', [
                'payment_id' => $payment->id,
                'transaction_id' => $payment->transaction_id,
                'amount' => $payment->amount,
                'card_last_four' => $payment->card_last_four,
            ]);
        } else {
            $payment->markAsFailed('Payment was declined by the card issuer.');
            
            // Handle payment failure
            $paymentService = new PaymentService();
            $paymentService->handlePaymentFailure($payment);
            
            Log::warning('Visa card payment failed', [
                'payment_id' => $payment->id,
                'transaction_id' => $payment->transaction_id,
            ]);
        }
    }

    public function cancelPayment($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        
        if ($payment->isPending()) {
            $payment->update(['status' => Payment::STATUS_CANCELLED]);
            
            return redirect()->route('customer.cart')
                ->with('success', 'Payment cancelled successfully.');
        }
        
        return redirect()->back()->with('error', 'Payment cannot be cancelled.');
    }
}
