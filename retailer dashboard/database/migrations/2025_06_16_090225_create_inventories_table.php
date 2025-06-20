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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->text('description');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('reorder_point', 10, 2);
            $table->decimal('reorder_quantity', 10, 2);
            $table->string('location');
            $table->string('category');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['in_stock', 'low_stock', 'out_of_stock']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
