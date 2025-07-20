<?php

namespace Modules\CustomerRetail\App\Models;

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

    protected $table = 'customer_products';

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
        return $this->hasMany(ProductBatch::class, 'product_id');
    }

    public function orders()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
