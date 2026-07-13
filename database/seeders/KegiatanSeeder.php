<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatanSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(database_path('data/kegiatan.csv'), 'r');
        $firstline = true;
        
        while (($data = fgetcsv($file, 2000, ";")) !== FALSE) {
            if ($firstline) { $firstline = false; continue; }
            if (!isset($data[0]) || !isset($data[5])) continue;
            
            DB::table('kegiatan')->insert([
                'id_direktorat' => $data[0],
                'nama_direktorat' => $data[1],
                'id_kegiatan' => $data[2],
                'nama_kegiatan' => $data[3],
                'jenis_output' => $data[4],
                'satuan' => $data[5],
            ]);
        }
        fclose($file);
    }
}