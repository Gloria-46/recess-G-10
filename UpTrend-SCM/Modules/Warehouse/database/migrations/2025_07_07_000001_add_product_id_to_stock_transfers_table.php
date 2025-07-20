<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('stock_transfers', 'product_id')) {
            Schema::table('stock_transfers', function (Blueprint $table) {
                $table->unsignedBigInteger('product_id')->nullable()->after('id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('stock_transfers', 'product_id')) {
            Schema::table('stock_transfers', function (Blueprint $table) {
                $table->dropColumn('product_id');
            });
        }
    }
}; 