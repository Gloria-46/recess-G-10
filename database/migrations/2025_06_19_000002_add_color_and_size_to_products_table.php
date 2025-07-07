<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'color')) {
                $table->string('color')->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'size')) {
                $table->string('size')->nullable()->after('color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'color')) {
                $table->dropColumn('color');
            }
            if (Schema::hasColumn('products', 'size')) {
                $table->dropColumn('size');
            }
        });
    }
}; 