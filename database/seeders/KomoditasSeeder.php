<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KomoditasSeeder extends Seeder
{
    public function run(): void
    {
        $file = fopen(database_path('data/masterkom.csv'), 'r');
        fgetcsv($file);
        $data = [];
        while (($row = fgetcsv($file, 1000, ";")) !== false) {
            if (!isset($row[0]) || empty($row[0])) continue;
            $data[] = [
                'id'     => (int) $row[0],
                'kd_kom' => $row[1],
                'nama'   => $row[3],
            ];
            if (count($data) >= 500) { DB::table('komoditas')->insert($data); $data = []; }
        }
        if (!empty($data)) DB::table('komoditas')->insert($data);
        fclose($file);
    }
}