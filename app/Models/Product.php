<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'retailer_id',
        'name',
        'description',
        'price',
        'color',
        'size',
        'image',
        'current_stock',
        'is_active',
        'category',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function batches()
    {
        return $this->hasMany(ProductBatch::class);
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\OrderItem::class, 'product_id');
    }
}
