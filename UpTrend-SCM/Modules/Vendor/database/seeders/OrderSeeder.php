<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Vendor\App\Models\Order;
use Modules\Vendor\App\Models\OrderItem;
use Modules\Vendor\App\Models\Supplier;
use Modules\Vendor\App\Models\Material;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor_suppliers = Supplier::all();
        $materials = Material::all();

        if ($vendor_suppliers->isEmpty() || $materials->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'approved', 'shipped', 'received'];
        $paymentStatuses = ['pending', 'partial', 'paid'];

        for ($i = 1; $i <= 15; $i++) {
            $supplier = $vendor_suppliers->random();
            $status = $statuses[array_rand($statuses)];
            $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];
            
            $orderDate = Carbon::now()->subDays(rand(1, 60));
            $expectedDelivery = $orderDate->copy()->addDays(rand(7, 30));
            $actualDelivery = null;
            
            if ($status === 'received') {
                $actualDelivery = $expectedDelivery->copy()->addDays(rand(-3, 5));
            } elseif ($status === 'shipped') {
                $actualDelivery = null;
            }

            $order = Order::create([
                'order_number' => 'PO-' . date('Y') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'supplier_id' => $supplier->id,
                'status' => $status,
                'order_date' => $orderDate,
                'expected_delivery' => $expectedDelivery,
                'actual_delivery' => $actualDelivery,
                'total_amount' => 0,
                'shipping_cost' => rand(50, 500),
                'tax_amount' => 0,
                'grand_total' => 0,
                'notes' => 'Sample order for ' . $supplier->name,
                'shipping_address' => '123 Main St, City, State 12345',
                'payment_terms' => 'Net 30',
                'payment_status' => $paymentStatus
            ]);

            // Create 1-4 order items
            $numItems = rand(1, 4);
            $totalAmount = 0;
            
            for ($j = 0; $j < $numItems; $j++) {
                $material = $materials->random();
                $quantity = rand(10, 100);
                $unitPrice = $material->price;
                $totalPrice = $quantity * $unitPrice;
                $totalAmount += $totalPrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'material_id' => $material->id,
                    'material_name' => $material->name,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'unit' => $material->unit,
                    'notes' => 'Sample order item'
                ]);
            }

            // Update order totals
            $taxAmount = $totalAmount * 0.08; // 8% tax
            $grandTotal = $totalAmount + $order->shipping_cost + $taxAmount;
            
            $order->update([
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'grand_total' => $grandTotal
            ]);
        }
    }
}
