<?php

namespace Modules\Warehouse\App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'contact',
    ];

    protected $table = 'warehouse_suppliers';

    public function supplies()
    {
        return $this->hasMany(Supply::class, 'supplier_id', 'id');
    }
} 