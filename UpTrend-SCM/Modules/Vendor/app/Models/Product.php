<?php

namespace Modules\Vendor\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Vendor\App\Models\TransactionItem;

class Product extends Model
{
    protected $table = 'vendor_inventories';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}