<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inventory::insert([
            [
                'sku' => 'FAB-COT-001',
                'name' => 'Cotton Fabric (White)',
                'description' => '100% cotton, 60 inch width',
                'quantity' => 500,
                'unit_price' => 8000,
                'reorder_point' => 100,
                'reorder_quantity' => 400,
                'location' => 'Warehouse A',
                'category' => 'Fabric',
                'supplier_id' => 1,
                'status' => 'in_stock',
            ],
            [
                'sku' => 'BTN-PLS-001',
                'name' => 'Plastic Buttons (Black, 4-hole)',
                'description' => 'Pack of 1000, 12mm diameter',
                'quantity' => 2000,
                'unit_price' => 50,
                'reorder_point' => 500,
                'reorder_quantity' => 1500,
                'location' => 'Warehouse B',
                'category' => 'Accessories',
                'supplier_id' => 2,
                'status' => 'in_stock',
            ],
            [
                'sku' => 'ZIP-MTL-001',
                'name' => 'Metal Zippers (YKK, 20cm)',
                'description' => 'Pack of 100',
                'quantity' => 300,
                'unit_price' => 200,
                'reorder_point' => 100,
                'reorder_quantity' => 200,
                'location' => 'Warehouse B',
                'category' => 'Accessories',
                'supplier_id' => 2,
                'status' => 'in_stock',
            ],
            [
                'sku' => 'DYE-BLU-001',
                'name' => 'Blue Dye (Reactive)',
                'description' => 'For cotton fabrics, 1kg pack',
                'quantity' => 20,
                'unit_price' => 15000,
                'reorder_point' => 5,
                'reorder_quantity' => 15,
                'location' => 'Warehouse C',
                'category' => 'Chemicals',
                'supplier_id' => 3,
                'status' => 'in_stock',
            ],
            [
                'sku' => 'THR-POL-001',
                'name' => 'Polyester Thread (White)',
                'description' => '5000m cone',
                'quantity' => 100,
                'unit_price' => 500,
                'reorder_point' => 20,
                'reorder_quantity' => 80,
                'location' => 'Warehouse D',
                'category' => 'Thread',
                'supplier_id' => 4,
                'status' => 'in_stock',
            ],
            [
                'sku' => 'SHIRT-MEN-001',
                'name' => 'Men\'s Formal Shirt (Blue, L)',
                'description' => 'Finished product, 100% cotton',
                'quantity' => 60,
                'unit_price' => 25000,
                'reorder_point' => 10,
                'reorder_quantity' => 50,
                'location' => 'Warehouse E',
                'category' => 'Finished Goods',
                'supplier_id' => 1,
                'status' => 'in_stock',
            ],
        ]);
    }
}
