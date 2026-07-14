<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        $file = fopen(database_path('data/provinsi.csv'), 'r');
        fgetcsv($file); 
        $data = [];
        while (($row = fgetcsv($file, 1000, ";")) !== false) {
            if (!isset($row[0]) || empty($row[0])) continue;
            $data[] = [
                'id' => (int) $row[0],
                'nama_prov' => $row[1],
            ];
            if (count($data) >= 1000) { DB::table('provinsi')->insert($data); $data = []; }
        }
        if (!empty($data)) DB::table('provinsi')->insert($data);
        fclose($file);
    }
}