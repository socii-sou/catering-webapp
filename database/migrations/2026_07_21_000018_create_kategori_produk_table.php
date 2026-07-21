<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori'); // mis. "Nasi Kotak", "Prasmanan", "Tumpeng"
            $table->string('slug')->unique(); // mis. "nasi-kotak" -> dipakai di URL/filter frontend
            $table->boolean('mendukung_gubukan')->default(false); // cuma Prasmanan yang true
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_produks');
    }
};