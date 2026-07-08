<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provinsi', function (Blueprint $table) {
            $table->string('id', 2)->primary(); // Maksimal 2 digit (contoh: 33)
            $table->string('nama_provinsi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provinsi');
    }
};