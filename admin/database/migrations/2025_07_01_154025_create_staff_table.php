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
        Schema::create('staff', function (Blueprint $table) {
            // $table->id();
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->string('position');
            // $table->timestamps();
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->string('phone');
            $table->string('gender');
            $table->string('email')->unique();
            // $table->string('role'); // warehouse, retailer, etc.
            $table->text('address');
            $table->date('hire_date');
            // $table->unsignedBigInteger('stage_id')->nullable(); // Foreign key
            $table->timestamps();
            $table->foreignId('stage_id')->constrained('production_stages');



            // $table->foreign('stage_id')->references('id')->on('production_stages')->onDelete('set null');
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
