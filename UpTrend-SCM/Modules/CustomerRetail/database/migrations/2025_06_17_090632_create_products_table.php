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
        Schema::create('customer_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('color');
            $table->string('size');
            $table->string('image')->nullable();
            $table->integer('current_stock')->nullable();
            // $table->string('category')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('retailers')->onDelete('cascade');
        });

        Schema::create('customer_product_batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('batch_no');
            $table->integer('quantity_added');
            $table->dateTime('received_at');
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('customer_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_product_batches');
        Schema::dropIfExists('customer_products');
    }
};
