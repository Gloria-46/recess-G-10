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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('payment_method'); // mobile_money, visa_card
            $table->string('payment_provider'); // airtel_money, mtn_money, visa
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('UGX');
            $table->string('status'); // pending, processing, completed, failed, cancelled
            $table->string('phone_number')->nullable(); // for mobile money
            $table->string('card_last_four')->nullable(); // for visa cards
            $table->string('card_type')->nullable(); // visa, mastercard, etc.
            $table->text('payment_details')->nullable(); // JSON data for additional payment info
            $table->text('error_message')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
