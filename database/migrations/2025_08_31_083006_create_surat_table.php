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
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 100)->nullable();
            $table->string('perihal', 255);
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->date('tanggal_surat')->nullable();
            $table->foreignId('klien_id')->nullable()->constrained('klien')->onDelete('set null');
            $table->text('keterangan')->nullable();
            $table->string('file_path', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
