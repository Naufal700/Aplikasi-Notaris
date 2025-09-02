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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_order', 100)->unique();
            $table->foreignId('klien_id')->constrained('klien')->onDelete('cascade');
            $table->foreignId('jenis_akta_id')->constrained('jenis_akta')->onDelete('cascade');
            $table->date('tanggal_order');
            $table->enum('status', ['draft', 'proses', 'selesai', 'batal'])->default('draft');
            $table->decimal('biaya', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
