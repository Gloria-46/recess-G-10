<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Cotton T-Shirt',
                'category' => 'Ladies',
                'quantity' => 150,
                'reorder_level' => 20,
                'price' => 25000,
                'colors' => ['Red', 'Blue', 'Green', 'Black', 'White'],
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'status' => 'Active',
                'description' => 'Ladies comfortable cotton t-shirt available in multiple colors and sizes',
                'batch' => 'BATCH-001-2025',
                'date' => now(),
            ],
            [
                'name' => 'Denim Jeans',
                'category' => 'Gentlemen',
                'quantity' => 80,
                'reorder_level' => 15,
                'price' => 60000,
                'colors' => ['Blue', 'Black', 'Grey'],
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'status' => 'Active',
                'description' => 'Gentlemen classic denim jeans with perfect fit',
                'batch' => 'BATCH-002-2025',
                'date' => now(),
            ],
            [
                'name' => 'Running Shoes',
                'category' => 'Gentlemen',
                'quantity' => 45,
                'reorder_level' => 10,
                'price' => 90000,
                'colors' => ['White', 'Black', 'Red', 'Blue'],
                'sizes' => ['37', '38', '39', '40', '41', '42', '43', '44'],
                'status' => 'Active',
                'description' => 'Gentlemen comfortable running shoes for all terrains',
                'batch' => 'BATCH-003-2025',
                'date' => now(),
            ],
            [
                'name' => 'Laptop Bag',
                'category' => 'Gentlemen',
                'quantity' => 30,
                'reorder_level' => 8,
                'price' => 46000,
                'colors' => ['Black', 'Brown', 'Grey'],
                'sizes' => ['Small', 'Medium', 'Large'],
                'status' => 'Active',
                'description' => 'Gentlemen durable laptop bag with multiple compartments',
                'batch' => 'BATCH-004-2025',
                'date' => now(),
            ],
            [
                'name' => 'Wireless Headphones',
                'category' => 'Ladies',
                'quantity' => 25,
                'reorder_level' => 5,
                'price' => 130000,
                'colors' => ['Black', 'White', 'Blue'],
                'sizes' => ['One Size'],
                'status' => 'Active',
                'description' => 'Ladies high-quality wireless headphones with noise cancellation',
                'batch' => 'BATCH-005-2025',
                'date' => now(),
            ],
            [
                'name' => 'Water Bottle',
                'category' => 'Ladies',
                'quantity' => 100,
                'reorder_level' => 25,
                'price' => 20000,
                'colors' => ['Clear', 'Blue', 'Green', 'Pink'],
                'sizes' => ['500ml', '750ml', '1L'],
                'status' => 'Active',
                'description' => 'Ladies BPA-free water bottle for daily use',
                'batch' => 'BATCH-006-2025',
                'date' => now(),
            ],
            [
                'name' => 'Yoga Mat',
                'category' => 'Ladies',
                'quantity' => 60,
                'reorder_level' => 12,
                'price' => 36000,
                'colors' => ['Purple', 'Blue', 'Green', 'Black'],
                'sizes' => ['Standard', 'Extra Long'],
                'status' => 'Active',
                'description' => 'Ladies non-slip yoga mat for home and studio use',
                'batch' => 'BATCH-007-2025',
                'date' => now(),
            ],
            [
                'name' => 'Smartphone Case',
                'category' => 'Ladies',
                'quantity' => 120,
                'reorder_level' => 30,
                'price' => 16000,
                'colors' => ['Clear', 'Black', 'Red', 'Blue', 'Pink'],
                'sizes' => ['iPhone 13', 'iPhone 14', 'Samsung Galaxy'],
                'status' => 'Active',
                'description' => 'Ladies protective smartphone case with shock absorption',
                'batch' => 'BATCH-008-2025',
                'date' => now(),
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
