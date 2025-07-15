<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTransfer extends Model
{
    protected $fillable = [
        'product_id', 
        'to_branch', 
        'quantity', 
        'staff_id',
        'transfer_date',
        'priority',
        'notes',
        'color_details',
        'size_details'
    ];

    protected $casts = [
        'transfer_date' => 'datetime',
        'color_details' => 'array',
        'size_details' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
