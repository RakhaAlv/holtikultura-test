<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        $file = fopen(database_path('data/desa.csv'), 'r');
        fgetcsv($file);
        $data = [];
        while (($row = fgetcsv($file, 1000, ";")) !== false) {
            if (!isset($row[6]) || empty($row[6])) continue;
            $data[] = [
                'id' => (int) $row[6],
                'kecamatan_id' => (int) $row[4],
                'nama_desa' => $row[7],
            ];
            if (count($data) >= 1000) { DB::table('desa')->insert($data); $data = []; }
        }
        if (!empty($data)) DB::table('desa')->insert($data);
        fclose($file);
    }
}