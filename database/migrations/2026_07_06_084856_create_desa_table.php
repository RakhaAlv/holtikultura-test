<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('desa', function (Blueprint $table) {
            $table->string('id', 10)->primary(); // Maksimal 10 digit
            $table->string('kecamatan_id', 6); 
            $table->string('nama_desa');
            $table->timestamps();

            // Relasi ke tabel kecamatan
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desa');
    }
};