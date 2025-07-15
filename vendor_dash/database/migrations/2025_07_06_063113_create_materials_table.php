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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category'); // e.g., Fabric, Accessories, Packaging
            $table->string('subcategory')->nullable(); // e.g., Cotton, Polyester, Buttons, Zippers
            $table->string('unit'); // e.g., meters, pieces, kg
            $table->decimal('unit_price', 15, 2);
            $table->integer('moq'); // Minimum Order Quantity
            $table->integer('lead_time_days');
            $table->unsignedBigInteger('supplier_id');
            $table->string('status')->default('available'); // available, discontinued, out_of_stock
            $table->text('specifications')->nullable(); // Technical specifications
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
