<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductStockDetail;

class StockDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            // Add stock for colors
            if ($product->colors && is_array($product->colors)) {
                foreach ($product->colors as $color) {
                    ProductStockDetail::create([
                        'product_id' => $product->product_id,
                        'color' => $color,
                        'size' => null,
                        'quantity' => rand(5, 20),
                    ]);
                }
            }

            // Add stock for sizes
            if ($product->sizes && is_array($product->sizes)) {
                foreach ($product->sizes as $size) {
                    ProductStockDetail::create([
                        'product_id' => $product->product_id,
                        'color' => null,
                        'size' => $size,
                        'quantity' => rand(3, 15),
                    ]);
                }
            }
        }
    }
}
