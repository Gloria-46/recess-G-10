<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_products', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_products', 'color')) {
                $table->string('color')->nullable()->after('price');
            }
            if (!Schema::hasColumn('customer_products', 'size')) {
                $table->string('size')->nullable()->after('color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_products', function (Blueprint $table) {
            if (Schema::hasColumn('customer_products', 'color')) {
                $table->dropColumn('color');
            }
            if (Schema::hasColumn('customer_products', 'size')) {
                $table->dropColumn('size');
            }
        });
    }
}; 