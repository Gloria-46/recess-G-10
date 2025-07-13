<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'on_time_delivery',
        'quality_issues',
        'average_rating',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
