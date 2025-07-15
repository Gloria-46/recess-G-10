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
        if (!Schema::hasColumn('stock_transfers', 'quantity')) {
            Schema::table('stock_transfers', function (Blueprint $table) {
                $table->integer('quantity')->default(0)->after('to_branch');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('stock_transfers', 'quantity')) {
            Schema::table('stock_transfers', function (Blueprint $table) {
                $table->dropColumn('quantity');
            });
        }
    }
};
