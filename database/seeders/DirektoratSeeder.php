<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirektoratSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('direktorat')->insert([
            ['id' => 1, 'nama_direktorat' => 'Sekretariat Direktorat Jenderal'],
            ['id' => 2, 'nama_direktorat' => 'Direktorat Perbenihan'],
            ['id' => 3, 'nama_direktorat' => 'Direktorat Pelindungan'],
            ['id' => 4, 'nama_direktorat' => 'Direktorat Sayuran dan Tanaman Obat'],
            ['id' => 5, 'nama_direktorat' => 'Direktorat Buah dan Florikultura'],
            ['id' => 6, 'nama_direktorat' => 'Direktorat Hilirisasi Hasil Hortikultura'],
        ]);
    }
}