<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel ini OPSIONAL per paket -- kalau suatu paket tidak punya baris
        // di sini sama sekali, berarti paket itu tetap pakai aturan lama:
        // bebas pilih N lauk dari mana saja (N = pakets.jumlah_lauk_pilihan).
        // Kalau paket PUNYA baris di sini, aturan kuota per kategori inilah
        // yang berlaku, menggantikan hitungan total biasa.
        Schema::create('paket_kategori_kuota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained('pakets')->cascadeOnDelete();
            $table->foreignId('kategori_lauk_id')->constrained('kategori_lauks')->cascadeOnDelete();
            $table->unsignedInteger('jumlah_pilihan'); // wajib pilih berapa dari kategori ini
            $table->timestamps();

            $table->unique(['paket_id', 'kategori_lauk_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_kategori_kuota');
    }
};