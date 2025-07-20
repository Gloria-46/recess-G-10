<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_certifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->string('certification');
            $table->date('issued_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->string('issuer')->nullable();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('vendor_suppliers')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('supplier_certifications');
    }
}; 