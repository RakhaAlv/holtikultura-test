<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(database_path('data/kecamatan.csv'), 'r');
        $firstline = true;
        
        while (($data = fgetcsv($file, 2000, ";")) !== FALSE) {
            if ($firstline) { $firstline = false; continue; }
            if (!isset($data[2]) || !isset($data[4]) || !isset($data[5])) continue;
            
            DB::table('kecamatan')->insert([
                'id_kec' => $data[4],
                'id_kab' => $data[2],
                'nama_kec' => $data[5],
            ]);
        }
        fclose($file);
    }
}