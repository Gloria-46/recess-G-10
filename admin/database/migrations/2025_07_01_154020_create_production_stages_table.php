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
        Schema::create('production_stages', function (Blueprint $table) {
            // $table->id(); // Auto-incrementing primary key
            // $table->string('name')->unique(); // For the stage name (e.g., "Designing", "Cutting", "Sewing")
            // $table->text('description')->nullable(); // Optional description
            // // Add any other columns your ProductionStage model needs
            // // For example, if you have a display order:
            // // $table->integer('order')->nullable();
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->integer('max_staff')->nullable(); // Maximum number of staff allowed in this stage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_stages');
    }
};
