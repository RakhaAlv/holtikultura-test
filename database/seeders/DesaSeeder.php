<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('desa')->truncate();
        Schema::enableForeignKeyConstraints();

        $path = database_path('data/desa.csv');
        if (!file_exists($path)) return;

        $file = fopen($path, 'r');
        fgetcsv($file, 1000, ';');

        $data = [];
        $chunkSize = 2000; 

        while (($row = fgetcsv($file, 1000, ';')) !== false) {
            if (!isset($row[6]) || empty($row[6])) continue;

            $data[] = [

                'id' => (int) $row[6], 
                'kecamatan_id' => (int) $row[4],
                'nama_desa' => trim($row[7]),
            ];

            if (count($data) >= $chunkSize) {
                DB::table('desa')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) DB::table('desa')->insert($data);
        fclose($file);
    }
}