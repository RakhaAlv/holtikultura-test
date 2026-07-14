<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provinsi', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // Kode BPS
            $table->string('nama_prov');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provinsi');
    }
};