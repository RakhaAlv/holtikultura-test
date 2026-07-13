<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
    {
        Schema::create('realisasi', function (Blueprint $table) {
            $table->id('id_realisasi');
            $table->integer('tahun');
            $table->string('id_kegiatan');
            $table->integer('id_komoditas');
            $table->string('id_prov', 2);
            $table->string('id_kab', 4);
            $table->string('id_kec', 6);
            $table->string('id_desa', 10);
            $table->string('kelompok_tani');
            $table->decimal('realisasi_output', 15, 2);
            
            // KODE PERUBAHAN ENUM STATUS
            $table->enum('status', [
                'usulan CPCL', 
                'Kontrak/PKS', 
                'Pemberkasan dokumen pencairan', 
                'distribusi bantuan', 
                'bantuan sudah diterima'
            ]);
            
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('id_kegiatan')->references('id_kegiatan')->on('kegiatan')->cascadeOnDelete();
            $table->foreign('id_komoditas')->references('id_komoditas')->on('komoditas')->cascadeOnDelete();
            $table->foreign('id_prov')->references('id_prov')->on('provinsi')->cascadeOnDelete();
            $table->foreign('id_kab')->references('id_kab')->on('kabupaten')->cascadeOnDelete();
            $table->foreign('id_kec')->references('id_kec')->on('kecamatan')->cascadeOnDelete();
            $table->foreign('id_desa')->references('id_desa')->on('desa')->cascadeOnDelete();
            $table->foreign('created_by')->references('id_user')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id_user')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasi');
    }
};
