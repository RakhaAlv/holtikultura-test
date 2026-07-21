<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provinsis', function (Blueprint $table) {
            // Kode BPS Provinsi (contoh: 12), Primary Key Non-Incrementing
            $table->unsignedBigInteger('id')->primary();
            $table->string('nama');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provinsis');
    }
};