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
        Schema::table('stock_transfers', function (Blueprint $table) {
            $table->dateTime('transfer_date')->nullable()->after('staff_id');
            $table->enum('priority', ['normal', 'urgent', 'express'])->default('normal')->after('transfer_date');
            $table->text('notes')->nullable()->after('priority');
            $table->json('color_details')->nullable()->after('notes');
            $table->json('size_details')->nullable()->after('color_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_transfers', function (Blueprint $table) {
            $table->dropColumn(['transfer_date', 'priority', 'notes', 'color_details', 'size_details']);
        });
    }
};
