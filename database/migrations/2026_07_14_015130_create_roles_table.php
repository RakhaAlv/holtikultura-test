<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_role');
            $table->unsignedBigInteger('provinsi_id')->nullable();
            $table->unsignedBigInteger('kabupaten_id')->nullable();

            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('restrict');
            $table->foreign('kabupaten_id')->references('id')->on('kabupaten')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};