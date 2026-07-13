<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(database_path('data/provinsi.csv'), 'r');
        $firstline = true;
        
        while (($data = fgetcsv($file, 2000, ";")) !== FALSE) {
            if ($firstline) { $firstline = false; continue; }
            if (!isset($data[0]) || !isset($data[1])) continue;
            
            DB::table('provinsi')->insert([
                'id_prov' => $data[0],
                'nama_prov' => $data[1],
            ]);
        }
        fclose($file);
    }
}