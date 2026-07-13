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
        Schema::create('pesanan_paket_lauk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_paket_id')->constrained('pesanan_paket')->cascadeOnDelete();
            $table->foreignId('lauk_id')->constrained('lauks')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_paket_lauk');
    }
};
