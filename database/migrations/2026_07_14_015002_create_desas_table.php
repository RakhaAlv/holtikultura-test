<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('desa', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('kecamatan_id');
            $table->string('nama_desa');

            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desa');
    }
};