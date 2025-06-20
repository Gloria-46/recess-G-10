<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function view(Vendor $vendor, Product $product)
    {
        return $vendor->id === $product->vendor_id;
    }

    public function update(Vendor $vendor, Product $product)
    {
        return $vendor->id === $product->vendor_id;
    }

    public function delete(Vendor $vendor, Product $product)
    {
        return $vendor->id === $product->vendor_id;
    }
} 