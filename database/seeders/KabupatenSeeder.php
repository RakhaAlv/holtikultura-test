<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(database_path('data/kabupaten.csv'), 'r');
        $firstline = true;
        
        while (($data = fgetcsv($file, 2000, ";")) !== FALSE) {
            if ($firstline) { $firstline = false; continue; }
            if (!isset($data[0]) || !isset($data[2]) || !isset($data[3])) continue; 
            
            DB::table('kabupaten')->insert([
                'id_kab' => $data[2],
                'id_prov' => $data[0],
                'nama_kab' => $data[3],
            ]);
        }
        fclose($file);
    }
}