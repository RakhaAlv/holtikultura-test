<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SatuanSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        Schema::disableForeignKeyConstraints();
        DB::table('satuans')->truncate();
        Schema::enableForeignKeyConstraints();

        // Master Satuan Baku
        $satuans = [
            ['id' => 1, 'nama' => 'Ha', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'Kelompok', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'Kg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama' => 'Batang', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nama' => 'Unit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'nama' => 'Paket', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('satuans')->insert($satuans);
    }
}