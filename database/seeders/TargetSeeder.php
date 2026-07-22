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

        $path = database_path('data/target.csv');
        if (!file_exists($path)) {
            $path = database_path('data/harmonisasi_target_horti.csv');
            if (!file_exists($path)) return;
        }

        // In-Memory Lookup Caches (Mencegah N+1 Query)
        $kegiatanMap    = DB::table('kegiatans')->pluck('id', 'kode_kegiatan')->toArray();
        $provinsiCache  = DB::table('provinsis')->pluck('id')->toArray();
        $kabupatenCache = DB::table('kabupatens')->pluck('id')->toArray();
        $komoditasCache = DB::table('komoditas')->pluck('id')->toArray();
        $satuanCache    = DB::table('satuans')->pluck('id')->toArray();

        $defaultKegiatanId  = DB::table('kegiatans')->value('id') ?? 1;
        $defaultKomoditasId = 1;
        $defaultSatuanId    = 1;
        $defaultUserId      = 1;

        $file = fopen($path, 'r');
        fgetcsv($file, 0, ';'); // Skip Header

        $data = [];
        $chunkSize = 1000;

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            if (!isset($row[0]) || empty(trim($row[0]))) continue;

            $provinsiId  = (int) preg_replace('/[^0-9]/', '', $row[12] ?? '');
            $kabupatenId = (int) preg_replace('/[^0-9]/', '', $row[14] ?? '');

            // Validasi Relasi Wilayah
            if (!in_array($provinsiId, $provinsiCache) || !in_array($kabupatenId, $kabupatenCache)) {
                continue;
            }

            $rawTarget = trim($row[16] ?? '0');
            $targetVal = (float) str_replace(',', '.', $rawTarget);

            $direktoratId   = !empty($row[1]) ? (int) $row[1] : 1;
            $kodeKegiatan   = trim(preg_replace('/[^\x20-\x7E]/', '', $row[3] ?? ''));
            $kegiatanId     = $kegiatanMap[$kodeKegiatan] ?? $defaultKegiatanId;

            $rawKomoditasId = !empty($row[8]) ? (int) $row[8] : 0;
            $komoditasId    = in_array($rawKomoditasId, $komoditasCache) ? $rawKomoditasId : $defaultKomoditasId;

            $rawSatuanId    = !empty($row[10]) ? (int) $row[10] : 0;
            $satuanId       = in_array($rawSatuanId, $satuanCache) ? $rawSatuanId : $defaultSatuanId;

            $data[] = [
                'direktorat_id' => $direktoratId,
                'kegiatan_id'   => $kegiatanId,
                'komoditas_id'  => $komoditasId,
                'satuan_id'     => $satuanId,
                'provinsi_id'   => $provinsiId,
                'kabupaten_id'  => $kabupatenId,
                'tahun'         => !empty($row[0]) ? (int) $row[0] : 2026,
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