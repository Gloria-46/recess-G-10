<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function view(Vendor $vendor, Order $order)
    {
        return $vendor->id === $order->vendor_id;
    }

    public function update(Vendor $vendor, Order $order)
    {
        return $vendor->id === $order->vendor_id;
    }
} 