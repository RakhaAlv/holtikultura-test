<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenSeeder extends Seeder
{
    public function run(): void
    {
        $file = fopen(database_path('data/kabupaten.csv'), 'r');
        fgetcsv($file); 
        $data = [];
        while (($row = fgetcsv($file, 1000, ";")) !== false) {
            if (!isset($row[2]) || empty($row[2])) continue;
            $data[] = [
                'id' => (int) $row[2],
                'provinsi_id' => (int) $row[0],
                'nama_kab' => $row[3],
            ];
            if (count($data) >= 1000) { DB::table('kabupaten')->insert($data); $data = []; }
        }
        if (!empty($data)) DB::table('kabupaten')->insert($data);
        fclose($file);
    }
}