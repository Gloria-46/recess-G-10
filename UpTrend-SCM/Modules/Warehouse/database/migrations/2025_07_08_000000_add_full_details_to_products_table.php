<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('warehouse_products', function (Blueprint $table) {
            if (!Schema::hasColumn('warehouse_products', 'price')) {
                $table->decimal('price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('warehouse_products', 'colors')) {
                $table->string('colors')->nullable();
            }
            if (!Schema::hasColumn('warehouse_products', 'sizes')) {
                $table->string('sizes')->nullable();
            }
            if (!Schema::hasColumn('warehouse_products', 'status')) {
                $table->string('status')->default('Active');
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
                $table->dateTime('date')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('warehouse_products', function (Blueprint $table) {
            $drop = [];
            foreach(['price', 'colors', 'sizes', 'status', 'description', 'batch', 'image', 'date'] as $col) {
                if (Schema::hasColumn('warehouse_products', $col)) {
                    $drop[] = $col;
                }
            }
            if ($drop) {
                $table->dropColumn($drop);
            }
        });
    }
}; 