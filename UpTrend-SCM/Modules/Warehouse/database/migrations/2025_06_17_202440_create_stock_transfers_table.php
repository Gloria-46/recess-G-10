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
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('to_branch');
            $table->integer('quantity');
            $table->unsignedBigInteger('staff_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('stock_transfers',function (Blueprint $table){
            $table->id();
$table->foreignId('product_id')->constrained();
$table->string('to_branch');
$table->integer('quantity');
$table->foreignId('staff_id')->constrained('users');
$table->timestamps();
        });
    }
};
