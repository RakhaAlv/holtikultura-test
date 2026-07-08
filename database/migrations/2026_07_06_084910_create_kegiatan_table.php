<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_direktorat');
            $table->string('nama_direktorat');
            $table->string('kode_kegiatan');
            $table->string('nama_kegiatan');
            $table->string('jenis_output');
            $table->string('satuan_output');
            $table->string('komoditas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};