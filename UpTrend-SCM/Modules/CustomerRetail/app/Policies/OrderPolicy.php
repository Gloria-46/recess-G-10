<?php

namespace App\Policies;

use Modules\CustomerRetail\App\Models\Order;
use Modules\CustomerRetail\App\Models\Retailer;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function view(Retailer $retailer, Order $order)
    {
        // Ensure both retailer and order exist
        if (!$retailer || !$order) {
            return false;
        }
        
        return $retailer->id === $order->retailer_id;
    }

    public function update(Retailer $retailer, Order $order)
    {
        // Ensure both retailer and order exist
        if (!$retailer || !$order) {
            return false;
        }
        
        return $retailer->id === $order->retailer_id;
    }
} 