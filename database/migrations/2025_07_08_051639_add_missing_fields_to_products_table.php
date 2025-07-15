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
        Schema::table('products', function (Blueprint $table) {
            // Add missing fields if they don't exist
            if (!Schema::hasColumn('products', 'price')) {
                $table->decimal('price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('products', 'colors')) {
                $table->json('colors')->nullable();
            }
            if (!Schema::hasColumn('products', 'sizes')) {
                $table->json('sizes')->nullable();
            }
            if (!Schema::hasColumn('products', 'status')) {
                $table->enum('status', ['Active', 'Inactive'])->default('Active');
            }
            if (!Schema::hasColumn('products', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('products', 'batch')) {
                $table->string('batch')->nullable();
            }
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('products', 'date')) {
                $table->timestamp('date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
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
