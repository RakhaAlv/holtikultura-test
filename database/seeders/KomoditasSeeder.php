<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KomoditasSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(database_path('data/masterkom.csv'), 'r');
        $firstline = true;
        
        while (($data = fgetcsv($file, 2000, ";")) !== FALSE) {
            if ($firstline) { $firstline = false; continue; }
            if (!isset($data[0]) || !isset($data[3])) continue; 
            
            DB::table('komoditas')->insert([
                'id_komoditas' => $data[0],
                'kom' => $data[1],
                'grpkom' => $data[2],
                'nama' => $data[3],
                'fgroup' => $data[4],
                'fdetail' => $data[5],
                'idt' => $data[6],
                'jenissph' => $data[7],
                'satuanluas' => $data[8],
                'satuanproduksi' => $data[9],
            ]);
        }
        fclose($file);
    }
}