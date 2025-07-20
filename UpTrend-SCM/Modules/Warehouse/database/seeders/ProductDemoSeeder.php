<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Warehouse\App\Models\Product;

class ProductDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => "Men's Jacket",
            'category' => 'gentlemen',
            'price' => 50000,
            'colors' => 'Grey,Black',
            'sizes' => 'M,L,XL',
            'status' => 'Active',
            'quantity' => 10,
            'description' => 'Cool, leather and linen jacket.',
            'batch' => 'BATCH-001-2025',
            'image' => null,
            'date' => '2025-07-04 08:41',
            'reorder_level' => 3,
        ]);
        Product::create([
            'name' => "Ladies Floral Dress",
            'category' => 'ladies',
            'price' => 45000,
            'colors' => 'Blue,White',
            'sizes' => 'S,M,L',
            'status' => 'Active',
            'quantity' => 15,
            'description' => 'Elegant and comfortable summer dress.',
            'batch' => 'BATCH-002-2025',
            'image' => null,
            'date' => '2025-07-04 08:41',
            'reorder_level' => 5,
        ]);
        Product::create([
            'name' => "Neck Ties",
            'category' => 'gentlemen',
            'price' => 10000,
            'colors' => 'Red,Blue,Black,Grey',
            'sizes' => 'One Size',
            'status' => 'Active',
            'quantity' => 200,
            'description' => 'Classic neck ties for formal wear.',
            'batch' => 'BATCH-003-2025',
            'image' => null,
            'date' => '2025-07-04 08:41',
            'reorder_level' => 20,
        ]);
        Product::create([
            'name' => "Men's Polo Tshirt",
            'category' => 'gentlemen',
            'price' => 25000,
            'colors' => 'Cream,White,Blue',
            'sizes' => 'M,L,XL,XXL',
            'status' => 'Active',
            'quantity' => 144,
            'description' => 'Custom made printed cotton polo tshirts.',
            'batch' => 'BATCH-004-2025',
            'image' => null,
            'date' => '2025-07-03 14:46',
            'reorder_level' => 15,
        ]);
        Product::create([
            'name' => "Ladies Tops",
            'category' => 'ladies',
            'price' => 18000,
            'colors' => 'Black,White,Red,Pink',
            'sizes' => 'S,M,L,XL',
            'status' => 'Active',
            'quantity' => 127,
            'description' => 'Trendy ladies tops for all occasions.',
            'batch' => 'BATCH-005-2025',
            'image' => null,
            'date' => '2025-07-03 14:37',
            'reorder_level' => 10,
        ]);
        Product::create([
            'name' => "Men's Plain T-Shirt",
            'category' => 'gentlemen',
            'price' => 12000,
            'colors' => 'Black,White,Grey,Blue',
            'sizes' => 'M,L,XL,XXL',
            'status' => 'Active',
            'quantity' => 200,
            'description' => 'Comfortable plain t-shirts for men.',
            'batch' => 'BATCH-006-2025',
            'image' => null,
            'date' => '2025-07-04 08:43',
            'reorder_level' => 25,
        ]);
        Product::create([
            'name' => "Ladies Long Dresses",
            'category' => 'ladies',
            'price' => 35000,
            'colors' => 'Red,Blue,Pink',
            'sizes' => 'S,M,L,XL',
            'status' => 'Active',
            'quantity' => 140,
            'description' => 'Long and elegant summer floral dresses.',
            'batch' => 'BATCH-007-2025',
            'image' => null,
            'date' => '2025-07-04 08:41',
            'reorder_level' => 8,
        ]);
        Product::create([
            'name' => "Men's Gentle Shirts",
            'category' => 'gentlemen',
            'price' => 30000,
            'colors' => 'White,Blue,Green',
            'sizes' => 'M,L,XL,XXL',
            'status' => 'Active',
            'quantity' => 174,
            'description' => 'Gentlemen\'s formal shirts in various colors.',
            'batch' => 'BATCH-008-2025',
            'image' => null,
            'date' => '2025-07-04 08:43',
            'reorder_level' => 12,
        ]);
        Product::create([
            'name' => "Ladies Floral Skirts",
            'image' => "products/ladiesfloralskirts.jpg",
            'batch' => "BATCH-005-2025",
            'date' => "2025-07-04 08:42",
            'quantity' => 147,
        ]);
        Product::create([
            'name' => "Plain Hoodies.",
            'image' => "products/plainhoodies.jpg",
            'batch' => "BATCH-002-2025",
            'date' => "2025-07-04 08:41",
            'quantity' => 147,
        ]);
    }
}
