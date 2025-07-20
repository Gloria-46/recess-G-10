<?php

namespace Modules\Vendor\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'tracking_number',
        'carrier',
        'status',
        'estimated_delivery',
        'actual_delivery',
        'shipping_cost',
        'origin',
        'destination',
        'notes',
    ];

    protected $casts = [
        'estimated_delivery' => 'date',
        'actual_delivery' => 'date',
        'shipping_cost' => 'decimal:2',
    ];

    protected $table = 'vendor_shipments';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
