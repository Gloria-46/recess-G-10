<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Vendor\App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::insert([
            [
                'name' => 'Global Textiles Ltd.',
                'contact_person' => 'Alice Kim',
                'email' => 'alice@globaltextiles.com',
                'phone' => '+256700111222',
                'address' => 'Industrial Area, Kampala',
                'country' => 'Uganda',
                'payment_terms' => 'Net 30',
                'lead_time_days' => 14,
                'status' => 'active',
                'notes' => 'Main supplier for cotton fabrics.'
            ],
            [
                'name' => 'ButtonWorks Co.',
                'contact_person' => 'John Doe',
                'email' => 'john@buttonworks.com',
                'phone' => '+256701234567',
                'address' => 'Plot 12, Makerere Rd, Kampala',
                'country' => 'Uganda',
                'payment_terms' => 'Net 15',
                'lead_time_days' => 7,
                'status' => 'active',
                'notes' => 'Supplies buttons and zippers.'
            ],
            [
                'name' => 'East Africa Dye House',
                'contact_person' => 'Grace N.',
                'email' => 'grace@eadye.com',
                'phone' => '+256702345678',
                'address' => 'Jinja Rd, Kampala',
                'country' => 'Uganda',
                'payment_terms' => 'Net 30',
                'lead_time_days' => 10,
                'status' => 'active',
                'notes' => 'Dyes and finishing chemicals.'
            ],
            [
                'name' => 'Sewing Accessories Ltd.',
                'contact_person' => 'Peter Okello',
                'email' => 'peter@sewingacc.com',
                'phone' => '+256703456789',
                'address' => 'Nkrumah Rd, Kampala',
                'country' => 'Uganda',
                'payment_terms' => 'Net 20',
                'lead_time_days' => 5,
                'status' => 'active',
                'notes' => 'Supplies threads and needles.'
            ],
        ]);
    }
}
