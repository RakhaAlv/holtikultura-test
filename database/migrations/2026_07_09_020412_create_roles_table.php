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
        Schema::create('roles', function (Blueprint $table) {
            $table->id('id_role');
            $table->unsignedBigInteger('id_user');
            $table->string('nama_role');
            
            // Scope Akses Wilayah
            $table->string('id_direktorat')->nullable();
            $table->string('id_prov', 2)->nullable();
            $table->string('id_kab', 4)->nullable();

            $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnDelete();
            $table->foreign('id_prov')->references('id_prov')->on('provinsi')->cascadeOnDelete();
            $table->foreign('id_kab')->references('id_kab')->on('kabupaten')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
