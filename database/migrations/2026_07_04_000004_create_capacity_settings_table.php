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
        Schema::create('capacity_settings', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable()->unique(); // null = default/global
            $table->unsignedInteger('kapasitas_maks_pax');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacity_settings');
    }
};
