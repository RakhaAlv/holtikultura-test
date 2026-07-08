<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kabupaten', function (Blueprint $table) {
            $table->string('id', 4)->primary(); // Maksimal 4 digit (contoh: 3374)
            $table->string('provinsi_id', 2);   // Harus sama persis dengan PK provinsi
            $table->string('nama_kabupaten');
            $table->timestamps();

            // Relasi ke tabel provinsi
            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kabupaten');
    }
};