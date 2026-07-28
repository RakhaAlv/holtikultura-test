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

        $satuans = [
            ['id' => 1, 'nama' => 'HA',       'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'Kelompok', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'Kilogram', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama' => 'Unit',     'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('satuans')->insert($satuans);
    }
}