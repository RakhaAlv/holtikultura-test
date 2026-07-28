<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('direktorat_id')->constrained('direktorats')->onDelete('restrict');
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->onDelete('restrict');
            $table->foreignId('komoditas_id')->constrained('komoditas')->onDelete('restrict');
            $table->foreignId('satuan_id')->constrained('satuans')->onDelete('restrict');

            // Hierarki Wilayah Tingkat Kabupaten
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kabupaten_id');

            $table->year('tahun');
            $table->decimal('target', 15, 2)->default(0);

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Foreign Keys Wilayah
            $table->foreign('provinsi_id')->references('id')->on('provinsis')->onDelete('restrict');
            $table->foreign('kabupaten_id')->references('id')->on('kabupatens')->onDelete('restrict');

            // Compound Indexing
            $table->index(['direktorat_id', 'tahun']);
            $table->index(['provinsi_id', 'tahun']);
            $table->index(['kabupaten_id', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('targets');
    }
};