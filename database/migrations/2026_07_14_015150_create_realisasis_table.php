<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('direktorat_id')->constrained('direktorats')->onDelete('restrict');
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->onDelete('restrict');
            $table->foreignId('komoditas_id')->constrained('komoditas')->onDelete('restrict');
            $table->foreignId('satuan_id')->constrained('satuans')->onDelete('restrict');

            // Denormalisasi Hierarki Wilayah BPS
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kabupaten_id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('desa_id');

            $table->string('nama_kelompok');
            $table->year('tahun');
            
            $table->decimal('jumlah_output', 15, 2)->default(0);
            $table->decimal('anggaran', 15, 2)->default(0);

            $table->enum('status', [
                'Usulan CPCL',
                'Kontrak/PKS',
                'Pemberkasan Dokumen Pencairan',
                'Distribusi Bantuan',
                'Bantuan Sudah Diterima'
            ])->default('Usulan CPCL');

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Foreign Keys Wilayah
            $table->foreign('provinsi_id')->references('id')->on('provinsis')->onDelete('restrict');
            $table->foreign('kabupaten_id')->references('id')->on('kabupatens')->onDelete('restrict');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->onDelete('restrict');
            $table->foreign('desa_id')->references('id')->on('desas')->onDelete('restrict');

            // Compound Indexing
            $table->index(['direktorat_id', 'tahun']);
            $table->index(['provinsi_id', 'tahun']);
            $table->index(['desa_id', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realisasis');
    }
};