<?php

namespace Modules\Vendor\App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'description',
        'quantity',
        'unit_price',
        'reorder_point',
        'reorder_quantity',
        'location',
        'category',
        'supplier_id',
        'status'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'reorder_point' => 'decimal:2',
        'reorder_quantity' => 'decimal:2'
    ];

    protected $table = 'vendor_inventories';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
