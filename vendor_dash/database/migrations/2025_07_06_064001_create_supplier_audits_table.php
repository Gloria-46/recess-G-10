<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_audits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->date('audit_date');
            $table->string('auditor');
            $table->text('notes')->nullable();
            $table->integer('rating')->nullable(); // 1-5 scale
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('supplier_audits');
    }
}; 