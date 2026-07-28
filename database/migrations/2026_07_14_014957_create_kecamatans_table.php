<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('kabupaten_id');
            $table->string('nama');
            $table->timestamps();

            $table->foreign('kabupaten_id')
                  ->references('id')
                  ->on('kabupatens')
                  ->onDelete('cascade');

            $table->index('kabupaten_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};