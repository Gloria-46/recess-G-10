<?php
namespace Modules\Warehouse\App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'name',
        'category',
        'quantity',
        'reorder_level',
        'price',
        'colors',
        'sizes',
        'status',
        'description',
        'batch',
        'image',
        'date'
    ];

    protected $casts = [
        'colors' => 'array',
        'sizes' => 'array',
        'date' => 'datetime',
    ];

    protected $table = 'warehouse_products';

    public function stockDetails()
    {
        return $this->hasMany(ProductStockDetail::class, 'product_id', 'product_id');
    }
}