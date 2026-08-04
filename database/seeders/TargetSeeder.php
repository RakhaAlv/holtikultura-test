<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

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
            throw new RuntimeException("File data target tidak ditemukan pada path: {$path}");
        }

        $kegiatanMap    = DB::table('kegiatans')->pluck('id', 'kode_rincian_output')->toArray();
        $provinsiCache  = DB::table('provinsis')->pluck('id')->toArray();
        $kabupatenCache = DB::table('kabupatens')->pluck('id')->toArray();
        $komoditasCache = DB::table('komoditas')->pluck('id')->toArray();
        $satuanCache    = DB::table('satuans')->pluck('id')->toArray();

        $defaultKegiatanId  = DB::table('kegiatans')->value('id') ?? 1;
        $defaultKomoditasId = 1;
        $defaultSatuanId    = 1;
        $defaultUserId      = 1;

        $file = fopen($path, 'r');
        fgetcsv($file, 0, ';'); // Skip Header Row

        $data = [];
        $chunkSize = 1000;

        // --- TAHAP A: Import Data Target 2026 dari target.csv ---
        while (($row = fgetcsv($file, 0, ';')) !== false) {
            if (!isset($row[0]) || empty(trim($row[0]))) continue;

            $provinsiId  = (int) preg_replace('/[^0-9]/', '', $row[12] ?? '');
            $kabupatenId = (int) preg_replace('/[^0-9]/', '', $row[14] ?? '');

            // Validasi Relasi Wilayah Master
            if (!in_array($provinsiId, $provinsiCache) || !in_array($kabupatenId, $kabupatenCache)) {
                continue;
            }

            // Sanitasi Desimal Format Indonesia (e.g. "1.000" -> 1000)
            $targetVal = $this->sanitizeDecimal($row[16] ?? '0');

            $direktoratId   = !empty($row[1]) ? (int) $row[1] : 1;
            $kodeKegiatan   = trim(preg_replace('/[^\x20-\x7E]/', '', $row[5] ?? ''));
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

        //Auto-Generate Target 2025 dari Data Realisasi 2025
        DB::statement("
            INSERT INTO targets (
                direktorat_id, kegiatan_id, komoditas_id, satuan_id, 
                provinsi_id, kabupaten_id, tahun, target, created_by, created_at, updated_at
            )
            SELECT 
                direktorat_id, kegiatan_id, komoditas_id, satuan_id, 
                provinsi_id, kabupaten_id, 2025, SUM(jumlah_output), ?, NOW(), NOW()
            FROM realisasis
            WHERE tahun = 2025
            GROUP BY direktorat_id, kegiatan_id, komoditas_id, satuan_id, provinsi_id, kabupaten_id
        ", [$defaultUserId]);
    }

    private function sanitizeDecimal(?string $value): float
    {
        if (empty($value)) return 0.0;
        $value = trim($value);

        if (strpos($value, '.') !== false && strpos($value, ',') !== false) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        } elseif (strpos($value, ',') !== false) {
            $value = str_replace(',', '.', $value);
        } elseif (preg_match('/^\d{1,3}(\.\d{3})+$/', $value)) {
            $value = str_replace('.', '', $value);
        }

        return (float) $value;
    }
}