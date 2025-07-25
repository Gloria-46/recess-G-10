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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('is_group')->default(false);
            $table->foreignId('user_one_id')->constrained('users')->cascadeOnDelete(); 
            $table->foreignId('user_two_id')->constrained('users')->cascadeOnDelete(); 
            $table->timestamps();
            $table->unique(['user_one_id', 'user_two_id']); 
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
