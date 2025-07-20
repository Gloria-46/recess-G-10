<?php

namespace Modules\CustomerRetail\App\Policies;

use Modules\CustomerRetail\App\Models\Product;
use Modules\CustomerRetail\App\Models\Retailer;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function view(Retailer $retailer, Product $product)
    {
        return $retailer->id === $product->retailer_id;
    }

    public function update(Retailer $retailer, Product $product)
    {
        return $retailer->id === $product->retailer_id;
    }

    public function delete(Retailer $retailer, Product $product)
    {
        return $retailer->id === $product->retailer_id;
    }
} 