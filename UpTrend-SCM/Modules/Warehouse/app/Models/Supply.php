<?php

namespace Modules\Warehouse\App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $primaryKey = 'supply_id';
    protected $fillable = [
        'supplier_id',
        'product_id',
        'quantity',
        'date_received',
        'status',
        'notes',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
} 