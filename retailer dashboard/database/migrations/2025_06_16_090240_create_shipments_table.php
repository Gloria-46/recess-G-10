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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->string('tracking_number')->unique();
            $table->string('carrier');
            $table->enum('status', ['pending', 'in_transit', 'delivered', 'delayed', 'cancelled']);
            $table->date('estimated_delivery');
            $table->date('actual_delivery')->nullable();
            $table->decimal('shipping_cost', 10, 2);
            $table->string('origin');
            $table->string('destination');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
