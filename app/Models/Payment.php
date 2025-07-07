<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_provider',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'phone_number',
        'card_last_four',
        'card_type',
        'payment_details',
        'error_message',
        'paid_at',
    ];

    // Merchant number for mobile money payments
    const MERCHANT_NUMBER = '+256 742954755';

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'paid_at' => 'datetime',
    ];

    // Payment statuses
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    // Payment methods
    const METHOD_MOBILE_MONEY = 'mobile_money';
    const METHOD_VISA_CARD = 'visa_card';

    // Payment providers
    const PROVIDER_AIRTEL_MONEY = 'airtel_money';
    const PROVIDER_MTN_MONEY = 'mtn_money';
    const PROVIDER_VISA = 'visa';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'paid_at' => now(),
        ]);
    }

    public function markAsFailed($errorMessage = null)
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'error_message' => $errorMessage,
        ]);
    }

    public function getFormattedAmount()
    {
        return 'UGX ' . number_format($this->amount, 2);
    }

    public function getPaymentMethodDisplay()
    {
        $methods = [
            self::METHOD_MOBILE_MONEY => 'Mobile Money',
            self::METHOD_VISA_CARD => 'Visa Card',
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    public function getPaymentProviderDisplay()
    {
        $providers = [
            self::PROVIDER_AIRTEL_MONEY => 'Airtel Money',
            self::PROVIDER_MTN_MONEY => 'MTN Money',
            self::PROVIDER_VISA => 'Visa',
        ];

        return $providers[$this->payment_provider] ?? $this->payment_provider;
    }
}
