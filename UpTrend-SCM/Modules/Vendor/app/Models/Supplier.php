<?php

namespace Modules\Vendor\App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'country',
        'payment_terms',
        'lead_time_days',
        'status',
        'notes'
    ];

    protected $table = 'vendor_suppliers';

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function performance()
    {
        return $this->hasOne(SupplierPerformance::class);
    }

    public function audits()
    {
        return $this->hasMany(SupplierAudit::class);
    }

    public function certifications()
    {
        return $this->hasMany(SupplierCertification::class);
    }
}
