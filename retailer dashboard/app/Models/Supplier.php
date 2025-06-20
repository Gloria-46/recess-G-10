<?php

namespace App\Models;

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

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
