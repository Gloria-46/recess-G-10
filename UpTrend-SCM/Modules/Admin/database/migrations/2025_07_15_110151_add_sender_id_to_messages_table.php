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
        Schema::table('messages', function (Blueprint $table) {
            
            $table->unsignedBigInteger('sender_id')->after('conversation_id'); // Add after an existing column for order
            // Or you can make it nullable if a message might not always have a sender
            // $table->unsignedBigInteger('sender_id')->nullable()->after('conversation_id');

            // If sender_id is a foreign key to the 'users' table (highly recommended)
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Drop the foreign key constraint first (if you added it)
            $table->dropForeign(['sender_id']);

            // Then drop the column
            $table->dropColumn('sender_id');
        });
    }
};
