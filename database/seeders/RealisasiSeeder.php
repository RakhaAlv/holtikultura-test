<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RealisasiSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(database_path('data/realisasi.csv'), 'r');
        $firstline = true;
        
        $fallbackKegiatan = DB::table('kegiatan')->first();
        $fallbackIdK = $fallbackKegiatan ? $fallbackKegiatan->id_kegiatan : '1771.QDD.011';

        while (($data = fgetcsv($file, 2000, ";")) !== FALSE) {
            if ($firstline) { $firstline = false; continue; }
            if (!isset($data[0]) || trim($data[0]) == '') continue;
            
            $komoditas = DB::table('komoditas')->where('nama', 'LIKE', '%' . $data[2] . '%')->first();
            $id_kom = $komoditas ? $komoditas->id_komoditas : 1;
            
            $kegiatan = DB::table('kegiatan')->where('nama_kegiatan', 'LIKE', '%' . $data[1] . '%')->first();
            $id_keg = $kegiatan ? $kegiatan->id_kegiatan : $fallbackIdK;

            DB::table('realisasi')->insert([
                'tahun' => $data[0],
                'id_kegiatan' => $id_keg,
                'id_komoditas' => $id_kom,
                'id_prov' => str_pad($data[3], 2, '0', STR_PAD_LEFT),
                'id_kab' => $data[4],
                'id_kec' => $data[5],
                'id_desa' => $data[6],
                'kelompok_tani' => $data[11],
                'realisasi_output' => str_replace(',', '.', $data[14]),
                
                // KODE PERUBAHAN STATUS DEFAULT
                'status' => 'usulan CPCL',
                
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        fclose($file);
    }
}