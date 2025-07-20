<?php

namespace Modules\CustomerRetail\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'retailer_id',
        'user_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    protected $table = 'customer_orders';

    public function retailer()
    {
        return $this->belongsTo(Retailer::class, 'retailer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship to Warehouse order (Retailer's order from Warehouse)
    // We'll use the order_number to link orders since we can't add new fields
    public function warehouseOrder(): HasOne
    {
        return $this->hasOne(\Modules\Warehouse\App\Models\Order::class, 'order_number', 'order_number');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    // Coordination methods using existing fields
    public function getCoordinationStatusAttribute()
    {
        // Check if there's a matching warehouse order by order number
        $warehouseOrder = $this->warehouseOrder;
        if ($warehouseOrder) {
            return 'coordinated';
        }
        return 'standalone';
    }

    public function isCoordinated()
    {
        return $this->warehouseOrder()->exists();
    }

    public function getWarehouseOrderStatus()
    {
        if ($this->warehouseOrder) {
            return $this->warehouseOrder->status;
        }
        return null;
    }

    // Get the complete order chain status
    public function getOrderChainStatus()
    {
        $status = [
            'customer_order' => $this->status,
            'warehouse_order' => $this->getWarehouseOrderStatus(),
            'vendor_order' => null
        ];

        if ($this->warehouseOrder && $this->warehouseOrder->vendorOrder) {
            $status['vendor_order'] = $this->warehouseOrder->vendorOrder->status;
        }

        return $status;
    }

    // Method to coordinate with warehouse order by creating a matching order number
    public function coordinateWithWarehouseOrder($warehouseOrder)
    {
        // Update the warehouse order's order number to match this customer order
        $warehouseOrder->update(['order_number' => $this->order_number]);
        return true;
    }

    // Find matching warehouse order by customer details
    public function findMatchingWarehouseOrder()
    {
        return \Modules\Warehouse\App\Models\Order::where('retailer_email', $this->customer_email)
            ->orWhere('retailer_name', $this->customer_name)
            ->where('coordination_status', 'standalone')
            ->first();
    }
}
