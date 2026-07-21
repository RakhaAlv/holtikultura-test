<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DirektoratSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('direktorats')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('direktorats')->insert([
            ['id' => 1, 'nama' => 'Sekretariat Direktorat Jenderal', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'Direktorat Perbenihan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'Direktorat Pelindungan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama' => 'Direktorat Sayuran dan Tanaman Obat', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nama' => 'Direktorat Buah dan Florikultura', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'nama' => 'Direktorat Hilirisasi Hasil Hortikultura', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}