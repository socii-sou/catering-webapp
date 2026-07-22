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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // pelanggan
            $table->string('nama_acara', 150);
            $table->string('tipe_acara', 100)->nullable();
            $table->text('alamat_pengiriman');
            $table->foreignId('gubukan_id')->nullable()->constrained('gubukans')->nullOnDelete();
            $table->date('tgl_pesan');
            $table->date('tgl_acara'); // dipakai utk cek kapasitas
            $table->unsignedInteger('jumlah_pax');
            $table->string('status_pesanan')->default('menunggu_validasi');
            $table->enum('status_produksi', ['belum_diproses','diproses','selesai'])
                ->default('belum_diproses');
            $table->text('catatan')->nullable();
            $table->decimal('biaya_pengiriman', 12, 2)->default(0);
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
