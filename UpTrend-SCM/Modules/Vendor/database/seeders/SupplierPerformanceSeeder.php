<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Vendor\App\Models\Supplier;
use Modules\Vendor\App\Models\SupplierPerformance;

class SupplierPerformanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor_suppliers = Supplier::all();

        foreach ($vendor_suppliers as $supplier) {
            SupplierPerformance::create([
                'supplier_id' => $supplier->id,
                'on_time_delivery' => rand(85, 98), // Random percentage between 85-98%
                'quality_issues' => rand(0, 5), // Random number of quality issues
                'average_rating' => rand(35, 50) / 10, // Random rating between 3.5-5.0
            ]);
        }
    }
}
