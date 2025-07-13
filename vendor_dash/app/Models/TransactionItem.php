<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [
        // Add your fillable fields here, e.g.:
        'product_id',
        'quantity',
        'price',
        // ...
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
