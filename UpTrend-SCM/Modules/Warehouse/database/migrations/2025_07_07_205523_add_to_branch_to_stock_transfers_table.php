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
        if (!Schema::hasColumn('stock_transfers', 'to_branch')) {
            Schema::table('stock_transfers', function (Blueprint $table) {
                $table->string('to_branch')->after('product_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('stock_transfers', 'to_branch')) {
            Schema::table('stock_transfers', function (Blueprint $table) {
                $table->dropColumn('to_branch');
            });
        }
    }
};
