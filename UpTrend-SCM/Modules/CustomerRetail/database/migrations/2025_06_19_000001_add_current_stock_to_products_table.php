<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_products', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_products', 'current_stock')) {
                $table->integer('current_stock')->nullable()->after('image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_products', function (Blueprint $table) {
            if (Schema::hasColumn('customer_products', 'current_stock')) {
                $table->dropColumn('current_stock');
            }
        });
    }
}; 