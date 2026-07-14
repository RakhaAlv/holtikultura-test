<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        $file = fopen(database_path('data/kecamatan.csv'), 'r');
        fgetcsv($file);
        $data = [];
        while (($row = fgetcsv($file, 1000, ";")) !== false) {
            if (!isset($row[4]) || empty($row[4])) continue;
            $data[] = [
                'id' => (int) $row[4],
                'kabupaten_id' => (int) $row[2],
                'nama_kec' => $row[5],
            ];
            if (count($data) >= 1000) { DB::table('kecamatan')->insert($data); $data = []; }
        }
        if (!empty($data)) DB::table('kecamatan')->insert($data);
        fclose($file);
    }
}