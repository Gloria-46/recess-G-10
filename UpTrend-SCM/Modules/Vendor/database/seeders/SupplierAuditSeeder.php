<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Vendor\App\Models\Supplier;
use Modules\Vendor\App\Models\SupplierAudit;
use Carbon\Carbon;

class SupplierAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor_suppliers = Supplier::all();
        $auditors = ['John Smith', 'Sarah Johnson', 'Mike Davis', 'Lisa Wilson', 'David Brown'];

        foreach ($vendor_suppliers as $supplier) {
            // Create 1-3 audits per supplier
            $numAudits = rand(1, 3);
            
            for ($i = 0; $i < $numAudits; $i++) {
                $auditDate = Carbon::now()->subDays(rand(30, 365));
                
                SupplierAudit::create([
                    'supplier_id' => $supplier->id,
                    'audit_date' => $auditDate,
                    'auditor' => $auditors[array_rand($auditors)],
                    'rating' => rand(3, 5), // Random rating between 3-5
                    'notes' => $this->getRandomAuditNotes(),
                ]);
            }
        }
    }

    private function getRandomAuditNotes()
    {
        $notes = [
            'Quality standards met. Minor improvements needed in packaging.',
            'Excellent performance. All requirements exceeded.',
            'Good overall performance. Some delays in delivery noted.',
            'Satisfactory audit results. Recommended for continued partnership.',
            'Strong quality control processes. No major issues found.',
            'Minor quality issues identified. Corrective actions implemented.',
            'Outstanding supplier performance. Exceeds all expectations.',
            'Good communication and responsiveness. Quality standards maintained.',
            'Satisfactory audit with room for improvement in documentation.',
            'Excellent supplier relationship. High quality products delivered.'
        ];

        return $notes[array_rand($notes)];
    }
}
