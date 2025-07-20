<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('warehouse_products', function (Blueprint $table) {
            // Add missing fields if they don't exist
            if (!Schema::hasColumn('warehouse_products', 'price')) {
                $table->decimal('price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('warehouse_products', 'colors')) {
                $table->json('colors')->nullable();
            }
            if (!Schema::hasColumn('warehouse_products', 'sizes')) {
                $table->json('sizes')->nullable();
            }
            if (!Schema::hasColumn('warehouse_products', 'status')) {
                $table->enum('status', ['Active', 'Inactive'])->default('Active');
            }
            if (!Schema::hasColumn('warehouse_products', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('warehouse_products', 'batch')) {
                $table->string('batch')->nullable();
            }
            if (!Schema::hasColumn('warehouse_products', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('warehouse_products', 'date')) {
                $table->timestamp('date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warehouse_products', function (Blueprint $table) {
            $table->dropColumn([
                'price',
                'colors', 
                'sizes',
                'status',
                'description',
                'batch',
                'image',
                'date'
            ]);
        });
    }
};
