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
        Schema::create('mapping_jurnal', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_transaksi', 100)->unique();
            $table->foreignId('akun_debit')->constrained('coa')->onDelete('cascade');
            $table->foreignId('akun_kredit')->constrained('coa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapping_jurnal');
    }
};
