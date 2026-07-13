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
        Schema::create('gubukans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gubukan');
            $table->decimal('harga_gubukan', 12, 2);
            $table->unsignedInteger('kapasitas_orang');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gubukans');
    }
};
