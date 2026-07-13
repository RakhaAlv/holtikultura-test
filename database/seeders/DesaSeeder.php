<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesaSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(database_path('data/desa.csv'), 'r');
        $firstline = true;
        
        while (($data = fgetcsv($file, 2000, ";")) !== FALSE) {
            if ($firstline) { $firstline = false; continue; }
            if (!isset($data[4]) || !isset($data[6]) || !isset($data[7])) continue;
            
            DB::table('desa')->insert([
                'id_desa' => $data[6],
                'id_kec' => $data[4],
                'nama_desa' => $data[7],
            ]);
        }
        fclose($file);
    }
}