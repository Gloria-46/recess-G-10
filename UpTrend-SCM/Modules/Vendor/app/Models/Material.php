<?php

namespace Modules\Vendor\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'subcategory',
        'unit',
        'unit_price',
        'moq',
        'lead_time_days',
        'supplier_id',
        'status',
        'specifications',
        'notes'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'moq' => 'integer',
        'lead_time_days' => 'integer'
    ];

    protected $table = 'vendor_materials';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
