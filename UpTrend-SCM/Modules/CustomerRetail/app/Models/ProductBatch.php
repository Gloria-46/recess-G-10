<?php

namespace Modules\CustomerRetail\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'batch_no',
        'quantity_added',
        'received_at',
    ];

    protected $casts = [
        'received_at' => 'datetime',
    ];

    protected $table = 'customer_product_batches';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
} 