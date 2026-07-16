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
            $table->year('tahun')->index();
            
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('restrict');
            $table->foreignId('komoditas_id')->constrained('komoditas')->onDelete('restrict');
            $table->foreignId('satuan_id')->constrained('satuan')->onDelete('restrict');
            
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kabupaten_id');
            
            $table->decimal('target_output', 12, 2);
            
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('restrict');
            $table->foreign('kabupaten_id')->references('id')->on('kabupaten')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target');
    }
};