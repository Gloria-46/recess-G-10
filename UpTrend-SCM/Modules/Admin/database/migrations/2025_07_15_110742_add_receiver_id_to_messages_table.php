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
            // Add the receiver_id column
            // Assuming receiver_id refers to a user ID, it should be unsignedBigInteger
            $table->unsignedBigInteger('receiver_id')->after('sender_id'); // Add after sender_id

            // If receiver_id is a foreign key to the 'users' table (highly recommended)
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Drop the foreign key constraint first (if you added it)
            $table->dropForeign(['receiver_id']);

            // Then drop the column
            $table->dropColumn('receiver_id');
        });
    }
};