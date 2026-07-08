<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->string('id', 6)->primary(); // Maksimal 6 digit
            $table->string('kabupaten_id', 4); 
            $table->string('nama_kecamatan');
            $table->timestamps();

            // Relasi ke tabel kabupaten
            $table->foreign('kabupaten_id')->references('id')->on('kabupaten')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatan');
    }
};