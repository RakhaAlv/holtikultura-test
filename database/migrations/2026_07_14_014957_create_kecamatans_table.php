<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('kabupaten_id');
            $table->string('nama_kec');

            $table->foreign('kabupaten_id')->references('id')->on('kabupaten')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatan');
    }
};