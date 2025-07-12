<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Order;
use App\Notifications\CustomerOrderConfirmation;
use App\Notifications\RetailerNewOrder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function handlePaymentCompletion(Payment $payment)
    {
        if (!$payment->isCompleted()) {
            return false;
        }

        $order = $payment->order;
        
        // Update order status
        $order->update(['status' => 'paid']);
        
        // Reduce stock for each item
        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->current_stock = max(0, $product->current_stock - $item->quantity);
                $product->save();
            }
        }

        // Send email to customer
        if ($order->user && $order->user->email) {
            Notification::route('mail', $order->user->email)->notify(new CustomerOrderConfirmation($order));
        } elseif ($order->customer_email) {
            Notification::route('mail', $order->customer_email)->notify(new CustomerOrderConfirmation($order));
        }

        // Send the same email to retailer
        $retailer = $order->retailer ?? $order->vendor;
        if ($retailer && $retailer->email) {
            Notification::route('mail', $retailer->email)->notify(new CustomerOrderConfirmation($order));
        }

        Log::info('Payment completed and order processed', [
            'payment_id' => $payment->id,
            'order_id' => $order->id,
            'transaction_id' => $payment->transaction_id,
            'amount' => $payment->amount,
        ]);

        return true;
    }

    public function handlePaymentFailure(Payment $payment)
    {
        if (!$payment->isFailed()) {
            return false;
        }

        $order = $payment->order;
        
        // Update order status to failed
        $order->update(['status' => 'payment_failed']);

        Log::warning('Payment failed', [
            'payment_id' => $payment->id,
            'order_id' => $order->id,
            'transaction_id' => $payment->transaction_id,
            'error_message' => $payment->error_message,
        ]);

        return true;
    }
} 