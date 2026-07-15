<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kabupaten', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('provinsi_id');
            $table->string('nama_kab');

            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kabupaten');
    }
};