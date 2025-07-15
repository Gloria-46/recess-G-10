<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'supplier_id',
        'status',
        'order_date',
        'expected_delivery',
        'actual_delivery',
        'total_amount',
        'shipping_cost',
        'tax_amount',
        'grand_total',
        'notes',
        'shipping_address',
        'payment_terms',
        'payment_status'
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery' => 'date',
        'actual_delivery' => 'date',
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'grand_total' => 'decimal:2'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'PO-' . date('Y') . '-' . str_pad(static::whereYear('created_at', date('Y'))->count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
