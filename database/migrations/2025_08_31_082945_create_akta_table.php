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
        Schema::create('akta', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_akta', 100)->unique();
            $table->foreignId('klien_id')->constrained('klien')->onDelete('cascade');
            $table->foreignId('jenis_akta_id')->constrained('jenis_akta')->onDelete('cascade');
            $table->foreignId('staf_id')->nullable()->constrained('staf')->onDelete('set null');
            $table->enum('tipe', ['perusahaan', 'perorangan']);
            $table->date('tanggal_akta');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['draft', 'proses', 'selesai', 'batal'])->default('draft');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akta');
    }
};
