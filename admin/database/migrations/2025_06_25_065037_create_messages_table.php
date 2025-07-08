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
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // Primary key for the message
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete(); // Foreign key to conversations table
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
            // $table->foreignId('sender_id')->constrained()->cascadeOnDelete();
            // $table->foreignId('receiver_id')->constrained()->cascadeOnDelete();
            $table->text('content')->nullable(); // <<< THIS IS THE CRUCIAL COLUMN
            $table->string('type')->default('text'); // e.g., 'text', 'file', 'image'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
