<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCertification extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'certification',
        'issued_at',
        'expires_at',
        'issuer',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
