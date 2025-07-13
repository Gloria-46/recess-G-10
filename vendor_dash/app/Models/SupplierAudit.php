<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'audit_date',
        'auditor',
        'notes',
        'rating',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
