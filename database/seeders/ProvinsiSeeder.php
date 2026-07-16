<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kosongkan tabel untuk mencegah error Duplicate Entry
        DB::table('provinsi')->delete();

        $path = database_path('data/provinsi.csv');
        
        // 2. Validasi file untuk mencegah Fatal Error
        if (!file_exists($path)) {
            return;
        }

        $file = fopen($path, 'r');
        fgetcsv($file); 
        
        $data = [];
        while (($row = fgetcsv($file, 1000, ";")) !== false) {
            if (!isset($row[0]) || empty($row[0])) continue;
            
            $data[] = [
                'id' => (int) $row[0],
                // 3. Gunakan trim() untuk membersihkan spasi tersembunyi
                'nama_prov' => trim($row[1]), 
            ];
            
            if (count($data) >= 1000) { 
                DB::table('provinsi')->insert($data); 
                $data = []; 
            }
        }
        
        if (!empty($data)) {
            DB::table('provinsi')->insert($data);
        }
        
        fclose($file);
    }
}