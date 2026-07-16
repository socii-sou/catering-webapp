<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lauks', function (Blueprint $table) {
            // Nullable -> lauk lama yang belum dikategorikan tetap valid,
            // tidak wajib semua lauk punya kategori.
            $table->foreignId('kategori_lauk_id')
                ->nullable()
                ->after('nama_lauk')
                ->constrained('kategori_lauks')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lauks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('kategori_lauk_id');
        });
    }
};