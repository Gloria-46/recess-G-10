<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::table('production_stages', function (Blueprint $table) {
    //         //
    //     });
    // }
    public function up()
    {
        Schema::table('production_stages', function (Blueprint $table) {
            $table->unique('order');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('production_stages', function (Blueprint $table) {
            $table->dropUnique(['order']);
        });
    }
};
