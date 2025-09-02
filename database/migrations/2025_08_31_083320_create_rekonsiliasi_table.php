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
        Schema::create('rekonsiliasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kas_bank_id')->constrained('kas_bank')->onDelete('cascade');
            $table->date('tanggal');
            $table->decimal('saldo_bank', 15, 2);
            $table->decimal('saldo_software', 15, 2);
            $table->text('selisih')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekonsiliasi');
    }
};
