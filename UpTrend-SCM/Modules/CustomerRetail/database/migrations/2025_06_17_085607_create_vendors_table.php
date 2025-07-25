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
        Schema::create('retailers', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('about')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('application_form')->nullable();
            $table->string('compliance_certificate')->nullable();
            $table->string('bank_statement')->nullable();
            $table->string('businessName')->nullable();
            $table->string('contact')->nullable();
            $table->integer('yearOfEstablishment')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('status')->default('pending');
            $table->timestamp('visit_date')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retailers');
    }
};
