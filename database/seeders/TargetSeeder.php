<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TargetSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(database_path('data/target.csv'), 'r');
        $firstline = true;
        
        // Cek ID Kegiatan pertama sebagai fallback
        $fallbackKegiatan = DB::table('kegiatan')->first();
        $fallbackIdK = $fallbackKegiatan ? $fallbackKegiatan->id_kegiatan : '1771.QDD.011';

        while (($data = fgetcsv($file, 2000, ";")) !== FALSE) {
            if ($firstline) { $firstline = false; continue; }
            
            // --- KODE PENYELAMAT SUPER KUAT ---
            // Jika kolom tahun (index 0) tidak ada atau hanya berisi string kosong, lewati baris ini!
            if (!isset($data[0]) || trim($data[0]) == '') {
                continue;
            }
            // ----------------------------------
            
            $komoditas = DB::table('komoditas')->where('nama', 'LIKE', '%' . $data[2] . '%')->first();
            $id_kom = $komoditas ? $komoditas->id_komoditas : 1; 

            // ... (lanjutkan kodenya ke bawah seperti biasa)

            // Cari relasi ID Kegiatan ($data[1] berisi nama kegiatan)
            $kegiatan = DB::table('kegiatan')->where('nama_kegiatan', 'LIKE', '%' . $data[1] . '%')->first();
            $id_keg = $kegiatan ? $kegiatan->id_kegiatan : $fallbackIdK; 

            DB::table('target')->insert([
                'tahun' => $data[0],
                'id_kegiatan' => $id_keg,
                'id_komoditas' => $id_kom,
                'id_prov' => str_pad($data[3], 2, '0', STR_PAD_LEFT), // Format 2 digit (misal 5 jadi 05)
                'id_kab' => $data[4],
                'target_output' => $data[7],
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        fclose($file);
    }
}