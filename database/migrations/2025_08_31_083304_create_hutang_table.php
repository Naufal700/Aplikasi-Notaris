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
        Schema::create('hutang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_supplier', 100);
            $table->decimal('jumlah', 15, 2);
            $table->decimal('sisa', 15, 2);
            $table->date('tanggal_faktur');
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->enum('status', ['belum_lunas', 'lunas', 'partial'])->default('belum_lunas');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutang');
    }
};
