<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TargetSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        Schema::disableForeignKeyConstraints();
        DB::table('targets')->truncate();
        Schema::enableForeignKeyConstraints();

        $path = database_path('data/banper.csv');
        if (!file_exists($path)) return;

        // In-Memory Lookup & Validation Caches (Cegah N+1 Query & FK Failure)
        $kegiatanMap    = DB::table('kegiatans')->pluck('id', 'kode_kegiatan')->toArray();
        $desaCache      = DB::table('desas')->pluck('id')->toArray();
        $komoditasCache = DB::table('komoditas')->pluck('id')->toArray();
        $satuanCache    = DB::table('satuans')->pluck('id')->toArray();

        $defaultKegiatanId  = DB::table('kegiatans')->value('id') ?? 1;
        $defaultKomoditasId = 1; // Fallback ke Bawang Putih
        $defaultSatuanId    = 1; // Fallback ke Ha
        $defaultUserId      = 1; // Super Admin

        $file = fopen($path, 'r');
        fgetcsv($file, 0, ';'); // Skip Header

        $data = [];
        $chunkSize = 1000;

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            $kodeDesa = (int) preg_replace('/[^0-9]/', '', $row[16] ?? '');

            // Skip jika Kode Desa tidak valid atau tidak terdaftar di DB
            if ($kodeDesa < 1000000000 || !in_array($kodeDesa, $desaCache)) {
                continue;
            }

            // Parse Desimal Indonesia (koma ke titik)
            $rawTarget = trim($row[22] ?? '0');
            $targetVal = (float) str_replace(',', '.', $rawTarget);

            // Tentukan ID Relasi dengan Fallback Validasi FK
            $direktoratId = !empty($row[1]) ? (int) $row[1] : 1;
            $kodeKegiatan = trim(preg_replace('/[^\x20-\x7E]/', '', $row[3] ?? ''));
            $kegiatanId   = $kegiatanMap[$kodeKegiatan] ?? $defaultKegiatanId;

            $rawKomoditasId = !empty($row[7]) ? (int) $row[7] : 0;
            $komoditasId    = in_array($rawKomoditasId, $komoditasCache) ? $rawKomoditasId : $defaultKomoditasId;

            $rawSatuanId = !empty($row[20]) ? (int) $row[20] : 0;
            $satuanId    = in_array($rawSatuanId, $satuanCache) ? $rawSatuanId : $defaultSatuanId;

            // Extract Hierarki Wilayah dari Kode BPS Desa
            $provinsiId  = (int) substr((string)$kodeDesa, 0, 2);
            $kabupatenId = (int) substr((string)$kodeDesa, 0, 4);
            $kecamatanId = (int) substr((string)$kodeDesa, 0, 6);

            $data[] = [
                'direktorat_id' => $direktoratId,
                'kegiatan_id'   => $kegiatanId,
                'komoditas_id'  => $komoditasId,
                'satuan_id'     => $satuanId,
                'provinsi_id'   => $provinsiId,
                'kabupaten_id'  => $kabupatenId,
                'kecamatan_id'  => $kecamatanId,
                'desa_id'       => $kodeDesa,
                'tahun'         => !empty($row[8]) ? (int) $row[8] : 2025,
                'target'        => $targetVal,
                'created_by'    => $defaultUserId,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];

            if (count($data) >= $chunkSize) {
                DB::table('targets')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('targets')->insert($data);
        }

        fclose($file);
    }
}