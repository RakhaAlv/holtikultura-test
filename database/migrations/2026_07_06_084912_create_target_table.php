<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->unsignedBigInteger('kegiatan_id'); // Menyambung ke tabel kegiatan
            
            // Relasi Wilayah (Hanya sampai Kabupaten)
            $table->string('provinsi_id', 2);
            $table->string('kabupaten_id', 4);
            $table->decimal('target_output', 15, 2);
            
            // Jejak Audit (Audit Trail)
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Definisi Relasi (Foreign Keys)
            $table->foreign('kegiatan_id')->references('id')->on('kegiatan')->onDelete('cascade');
            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('cascade');
            $table->foreign('kabupaten_id')->references('id')->on('kabupaten')->onDelete('cascade');
            
            // Relasi ke tabel Users untuk Audit Trail
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target');
    }
};