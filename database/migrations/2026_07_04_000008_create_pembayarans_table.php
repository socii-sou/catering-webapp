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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->cascadeOnDelete();
            $table->dateTime('tgl_bayar');
            $table->decimal('jml_bayar', 12, 2);
            $table->string('metode_bayar');
            $table->enum('status_bayar', ['pending','dp','lunas','gagal'])->default('pending');
            $table->string('bukti_bayar')->nullable(); // path di storage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
