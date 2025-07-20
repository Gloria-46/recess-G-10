<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Vendor\App\Models\Supplier;
use Modules\Vendor\App\Models\SupplierCertification;
use Carbon\Carbon;

class SupplierCertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor_suppliers = Supplier::all();
        $certifications = [
            ['name' => 'ISO 9001', 'issuer' => 'ISO', 'expires' => true],
            ['name' => 'ISO 14001', 'issuer' => 'ISO', 'expires' => true],
            ['name' => 'Fair Trade', 'issuer' => 'Fair Trade International', 'expires' => true],
            ['name' => 'Organic Certified', 'issuer' => 'USDA', 'expires' => true],
            ['name' => 'B Corp', 'issuer' => 'B Lab', 'expires' => false],
            ['name' => 'LEED Certified', 'issuer' => 'USGBC', 'expires' => true],
            ['name' => 'FSC Certified', 'issuer' => 'Forest Stewardship Council', 'expires' => true],
            ['name' => 'GOTS Certified', 'issuer' => 'Global Organic Textile Standard', 'expires' => true],
            ['name' => 'SA8000', 'issuer' => 'SAI', 'expires' => true],
            ['name' => 'OHSAS 18001', 'issuer' => 'BSI', 'expires' => true],
        ];

        foreach ($vendor_suppliers as $supplier) {
            // Give each supplier 1-4 random certifications
            $numCertifications = rand(1, 4);
            $selectedCerts = array_rand($certifications, $numCertifications);
            
            if (!is_array($selectedCerts)) {
                $selectedCerts = [$selectedCerts];
            }

            foreach ($selectedCerts as $certIndex) {
                $cert = $certifications[$certIndex];
                $issuedAt = Carbon::now()->subDays(rand(100, 1000));
                $expiresAt = $cert['expires'] ? $issuedAt->copy()->addYears(rand(1, 3)) : null;

                SupplierCertification::create([
                    'supplier_id' => $supplier->id,
                    'certification' => $cert['name'],
                    'issued_at' => $issuedAt,
                    'expires_at' => $expiresAt,
                    'issuer' => $cert['issuer'],
                ]);
            }
        }
    }
}
