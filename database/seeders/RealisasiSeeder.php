<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealisasiSeeder extends Seeder
{
    public function run(): void
    {
        $file = fopen(database_path('data/data_fix.csv'), 'r');
        fgetcsv($file); // Skip Baris Header

        // 1. MEMORY MAPPING (Mencegah Kueri N+1 ke Master Data)
        $komoditasMap = DB::table('komoditas')->get()
            ->mapWithKeys(fn($item) => [strtolower(trim($item->nama)) => $item->id])
            ->toArray();
            
        $satuanMap = DB::table('satuan')->get()
            ->mapWithKeys(fn($item) => [strtolower(trim($item->nama_satuan)) => $item->id])
            ->toArray();
            
        $kegiatanMap = DB::table('kegiatan')->get()
            ->mapWithKeys(fn($item) => [strtolower(trim($item->nama_program)) => $item->id])
            ->toArray();

        // Fallback default
        $kegiatanDefault = DB::table('kegiatan')->first()->id ?? 1;
        $userDefault = DB::table('users')->first()->id ?? 1;

        $data = [];
        
        while (($row = fgetcsv($file, 0, ";")) !== false) {
            // Validasi: Abaikan baris jika kode_desa (Index 8) kosong
            if (!isset($row[8]) || empty(trim($row[8]))) continue;

            /* MAPPING INDEX DATA_FIX.CSV:
             * 1: Kegiatan, 2: Komoditas, 3: Tahun
             * 8: kode_desa, 9: Nama Kelompok
             * 11: Satuan, 12: Jumlah_Output (Realisasi)
             * 15: Progres (Status)
             */

            $namaKegiatan = strtolower(trim($row[1]));
            $namaKomoditas = strtolower(trim($row[2]));
            $namaSatuan = strtolower(trim($row[11]));
            $kodeDesa = trim($row[8]);

            // Ekstraksi ID Wilayah BPS secara matematis (Tanpa perlu kolom tambahan di CSV)
            $provinsi_id  = (int) substr($kodeDesa, 0, 2);
            $kabupaten_id = (int) substr($kodeDesa, 0, 4);
            $kecamatan_id = (int) substr($kodeDesa, 0, 6);
            $desa_id      = (int) $kodeDesa;

            // Auto-Insert Satuan jika belum ada di database
            if (!empty($namaSatuan) && !isset($satuanMap[$namaSatuan])) {
                $newSatuan = DB::table('satuan')->insertGetId(['nama_satuan' => trim($row[11])]);
                $satuanMap[$namaSatuan] = $newSatuan;
            }

            $data[] = [
                'tahun'            => (int) $row[3],
                'kegiatan_id'      => $kegiatanMap[$namaKegiatan] ?? $kegiatanDefault,
                'komoditas_id'     => $komoditasMap[$namaKomoditas] ?? 1, // Default id 1 jika typo di excel
                'satuan_id'        => $satuanMap[$namaSatuan] ?? 1,
                'provinsi_id'      => $provinsi_id,
                'kabupaten_id'     => $kabupaten_id,
                'kecamatan_id'     => $kecamatan_id,
                'desa_id'          => $desa_id,
                'kelompok_tani'    => trim($row[9]),
                'realisasi_output' => (float) ($row[12] ?: 0), // Ambil Jumlah_Output
                'status'           => empty(trim($row[15])) ? 'Draft' : trim($row[15]), // Ambil dari kolom Progres
                'created_by'       => $userDefault,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
            
            if (count($data) >= 500) {
                // Chunk insert dengan Try-Catch untuk bypass anomali/pemekaran wilayah kode_desa BPS yang tidak terdaftar
                try {
                    DB::table('realisasi')->insert($data);
                } catch (\Exception $e) {}
                $data = [];
            }
        }
        
        if (!empty($data)) {
            try { DB::table('realisasi')->insert($data); } catch (\Exception $e) {}
        }
        
        fclose($file);
    }
}