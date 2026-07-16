<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealisasiSeeder extends Seeder
{

    private array $statusMap = [
        'usulan cpcl'                   => 'Usulan CPCL',
        'kontrak/pks'                   => 'Kontrak/PKS',
        'kontrak / pks'                 => 'Kontrak/PKS',
        'pemberkasan dokumen pencairan' => 'Pemberkasan Dokumen Pencairan',
        'distribusi bantuan'            => 'Distribusi Bantuan',
        'bantuan sudah diterima'        => 'Bantuan Sudah Diterima',
        'belum ditentukan'              => 'Usulan CPCL',
    ];

    public function run(): void
    {
        $filePath = database_path('data/data_fix.csv');

        if (!file_exists($filePath)) {
            $this->command->error("File tidak ditemukan di: {$filePath}.");
            return;
        }

        $file = fopen($filePath, 'r');
        fgetcsv($file, 0, ";"); 

        $komoditasMap = DB::table('komoditas')->get()->mapWithKeys(fn($item) => [strtolower(trim($item->nama)) => $item->id])->toArray();
        $satuanMap    = DB::table('satuan')->get()->mapWithKeys(fn($item) => [strtolower(trim($item->nama_satuan)) => $item->id])->toArray();
        $kegiatanMap  = DB::table('kegiatan')->get()->mapWithKeys(fn($item) => [strtolower(trim($item->nama_program)) => $item->id])->toArray();

        $existingDesa = DB::table('desa')->pluck('id')->toArray();

        $kegiatanDefault = DB::table('kegiatan')->first()->id ?? 1;
        $userDefault      = DB::table('users')->first()->id ?? 1;

        $data = [];
        $rowCount = 0;
        $skippedCount = 0;
        $skippedLog = []; 

        while (($row = fgetcsv($file, 0, ";")) !== false) {
            if (!isset($row[8]) || empty(trim($row[8]))) continue;

            $namaKegiatan   = strtolower(trim(preg_replace('/[^\x20-\x7E]/', '', $row[1])));
            $namaKomoditas  = strtolower(trim(preg_replace('/[^\x20-\x7E]/', '', $row[2])));
            $namaSatuan     = strtolower(trim(preg_replace('/[^\x20-\x7E]/', '', $row[11])));
            $namaDesaBersih = trim(preg_replace('/[^\x20-\x7E]/', '', $row[7]));
            $kelompokTani   = trim(preg_replace('/[^\x20-\x7E]/', '', $row[9]));
            $statusBersih   = trim(preg_replace('/[^\x20-\x7E]/', '', $row[15]));

            $kodeDesa = (int) preg_replace('/[^0-9]/', '', $row[8]);

            if ($kodeDesa < 1000000000) {
                $skippedCount++;
                $skippedLog[] = "SKIP (kode desa tidak valid): {$row[7]} | kode: {$row[8]}";
                continue;
            }

            $provinsi_id  = (int) substr($kodeDesa, 0, 2);
            $kabupaten_id = (int) substr($kodeDesa, 0, 4);
            $kecamatan_id = (int) substr($kodeDesa, 0, 6);
            $desa_id      = $kodeDesa;

            if (!in_array($desa_id, $existingDesa)) {
                $skippedCount++;
                $skippedLog[] = "SKIP (desa tidak ditemukan di master): {$namaDesaBersih} | kode: {$desa_id}";
                continue;
            }

            if (!empty($namaSatuan) && !isset($satuanMap[$namaSatuan])) {
                $newSatuan = DB::table('satuan')->insertGetId(['nama_satuan' => $namaSatuan]);
                $satuanMap[$namaSatuan] = $newSatuan;
            }

            $data[] = [
                'tahun'            => (int) $row[3],
                'kegiatan_id'      => $kegiatanMap[$namaKegiatan] ?? $kegiatanDefault,
                'komoditas_id'     => $komoditasMap[$namaKomoditas] ?? 1,
                'satuan_id'        => $satuanMap[$namaSatuan] ?? 1,
                'provinsi_id'      => $provinsi_id,
                'kabupaten_id'     => $kabupaten_id,
                'kecamatan_id'     => $kecamatan_id,
                'desa_id'          => $desa_id,
                'kelompok_tani'    => $kelompokTani ?: '-',
                'realisasi_output' => (float) str_replace(',', '.', $row[12]),
                'status'           => $this->normalizeStatus($statusBersih),
                'created_by'       => $userDefault,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];

            if (count($data) >= 500) {
                DB::table('realisasi')->insert($data);
                $rowCount += count($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('realisasi')->insert($data);
            $rowCount += count($data);
        }

        fclose($file);

        if (!empty($skippedLog)) {
            file_put_contents(
                storage_path('logs/realisasi_skipped_' . now()->format('Ymd_His') . '.log'),
                implode("\n", $skippedLog)
            );
        }

        $this->command->info("Berhasil menambahkan {$rowCount} data realisasi ");
        $this->command->warn("{$skippedCount} baris Dilewati karena kode desa tidak valid");
    }

    private function normalizeStatus(?string $status): string
    {
        $key = strtolower(trim((string) $status));

        return $this->statusMap[$key] ?? 'Usulan CPCL';
    }
}