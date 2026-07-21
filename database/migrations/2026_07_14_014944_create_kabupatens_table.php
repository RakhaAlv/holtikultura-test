<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kabupatens', function (Blueprint $table) {
            // Kode BPS Kabupaten (contoh: 1216), Primary Key Non-Incrementing
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('provinsi_id');
            $table->string('nama');
            $table->timestamps();

            $table->foreign('provinsi_id')
                  ->references('id')
                  ->on('provinsis')
                  ->onDelete('cascade');

            $table->index('provinsi_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kabupatens');
    }
};