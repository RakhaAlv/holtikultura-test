<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KomoditasSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        Schema::disableForeignKeyConstraints();
        DB::table('komoditas')->truncate();
        Schema::enableForeignKeyConstraints();

        $komoditas = [
            ['id' => 1, 'kode_komoditas' => 'BPT', 'nama' => 'Bawang Putih', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'kode_komoditas' => 'BMR', 'nama' => 'Bawang Merah', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'kode_komoditas' => 'CBI', 'nama' => 'Cabai',        'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'kode_komoditas' => 'KTG', 'nama' => 'Kentang',      'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'kode_komoditas' => 'DRN', 'nama' => 'Durian',       'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'kode_komoditas' => 'JGM', 'nama' => 'Jagung Manis', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'kode_komoditas' => 'P2B', 'nama' => 'P2B',          'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('komoditas')->insert($komoditas);
    }
}