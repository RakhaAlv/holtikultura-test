<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realisasi', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('restrict');
            $table->foreignId('komoditas_id')->constrained('komoditas')->onDelete('restrict');
            $table->foreignId('satuan_id')->constrained('satuan')->onDelete('restrict');
            
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kabupaten_id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('desa_id');
            
            $table->string('kelompok_tani');
            $table->decimal('realisasi_output', 12, 2);
            $table->string('status', 30)->default('Draft');
            
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('restrict');
            $table->foreign('kabupaten_id')->references('id')->on('kabupaten')->onDelete('restrict');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('restrict');
            $table->foreign('desa_id')->references('id')->on('desa')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realisasi');
    }
};