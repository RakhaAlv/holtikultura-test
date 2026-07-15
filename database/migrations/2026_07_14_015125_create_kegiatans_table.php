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
        
        $table->foreignId('direktorat_id')->constrained('direktorat')->onDelete('restrict');
        
        $table->string('kd_program');
        $table->string('nama_program');
        $table->string('kd_rincianoutput');
        $table->string('nama_rincianoutput');
        $table->string('jenis_output');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};