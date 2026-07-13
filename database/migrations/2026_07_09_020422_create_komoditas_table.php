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
        Schema::create('komoditas', function (Blueprint $table) {
            $table->integer('id_komoditas')->primary();
            $table->string('kom')->nullable();
            $table->string('grpkom')->nullable();
            $table->string('nama')->nullable();
            $table->string('fgroup')->nullable();
            $table->string('fdetail')->nullable();
            $table->string('idt')->nullable();
            $table->string('jenissph')->nullable();
            $table->string('satuanluas')->nullable();
            $table->string('satuanproduksi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komoditas');
    }
};
