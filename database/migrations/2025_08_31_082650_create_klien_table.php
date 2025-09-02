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
        Schema::create('klien', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('alamat', 500)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->string('telepon', 50)->nullable();
            $table->string('npwp', 50)->nullable();
            $table->string('jenis_klien', 50)->nullable(); // Perorangan / Perusahaan
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klien');
    }
};
