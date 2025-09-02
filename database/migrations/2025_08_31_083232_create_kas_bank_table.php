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
        Schema::create('kas_bank', function (Blueprint $table) {
            $table->id();
            $table->string('nama_akun', 100);
            $table->string('tipe', 50); // kas / bank
            $table->string('nomor_rekening', 50)->nullable();
            $table->string('bank', 100)->nullable();
            $table->decimal('saldo_awal', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_bank');
    }
};
