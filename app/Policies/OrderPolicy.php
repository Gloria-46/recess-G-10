<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Retailer;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function view(Retailer $retailer, Order $order)
    {
        return $retailer->id === $order->retailer_id;
    }

    public function update(Retailer $retailer, Order $order)
    {
        return $retailer->id === $order->retailer_id;
    }
} 