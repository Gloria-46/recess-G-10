<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_performances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->decimal('on_time_delivery', 5, 2)->default(0); // percentage
            $table->integer('quality_issues')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0); // 1-5 scale
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('vendor_suppliers')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('supplier_performances');
    }
}; 