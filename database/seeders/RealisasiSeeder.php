<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        DB::disableQueryLog();

        Schema::disableForeignKeyConstraints();
        DB::table('realisasis')->truncate();
        Schema::enableForeignKeyConstraints();

        $path = database_path('data/banper.csv');
        if (!file_exists($path)) return;

        // In-Memory Lookup & Validation Caches
        $kegiatanMap    = DB::table('kegiatans')->pluck('id', 'kode_kegiatan')->toArray();
        $desaCache      = DB::table('desas')->pluck('id')->toArray();
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
            $kodeDesa = (int) preg_replace('/[^0-9]/', '', $row[16] ?? '');

            if ($kodeDesa < 1000000000 || !in_array($kodeDesa, $desaCache)) {
                continue;
            }

            // Parse Desimal Indonesia
            $rawTarget       = trim($row[22] ?? '0');
            $rawJumlahOutput = trim($row[21] ?? '0');
            $rawAnggaran     = trim($row[23] ?? '0');

            $targetVal       = (float) str_replace(',', '.', $rawTarget);
            $jumlahOutputVal = (float) str_replace(',', '.', $rawJumlahOutput);
            $anggaranVal     = (float) str_replace(',', '.', $rawAnggaran);

            // Validasi Relasi FK
            $direktoratId = !empty($row[1]) ? (int) $row[1] : 1;
            $kodeKegiatan = trim(preg_replace('/[^\x20-\x7E]/', '', $row[3] ?? ''));
            $kegiatanId   = $kegiatanMap[$kodeKegiatan] ?? $defaultKegiatanId;

            $rawKomoditasId = !empty($row[7]) ? (int) $row[7] : 0;
            $komoditasId    = in_array($rawKomoditasId, $komoditasCache) ? $rawKomoditasId : $defaultKomoditasId;

            $rawSatuanId = !empty($row[20]) ? (int) $row[20] : 0;
            $satuanId    = in_array($rawSatuanId, $satuanCache) ? $rawSatuanId : $defaultSatuanId;

            // Extract Hierarki Wilayah
            $provinsiId  = (int) substr((string)$kodeDesa, 0, 2);
            $kabupatenId = (int) substr((string)$kodeDesa, 0, 4);
            $kecamatanId = (int) substr((string)$kodeDesa, 0, 6);

            $namaKelompok = trim(preg_replace('/[^\x20-\x7E]/', '', $row[17] ?? ''));
            $rawStatus    = trim(preg_replace('/[^\x20-\x7E]/', '', $row[24] ?? ''));

            $data[] = [
                'direktorat_id' => $direktoratId,
                'kegiatan_id'   => $kegiatanId,
                'komoditas_id'  => $komoditasId,
                'satuan_id'     => $satuanId,
                'provinsi_id'   => $provinsiId,
                'kabupaten_id'  => $kabupatenId,
                'kecamatan_id'  => $kecamatanId,
                'desa_id'       => $kodeDesa,
                'nama_kelompok' => $namaKelompok ?: '-',
                'tahun'         => !empty($row[8]) ? (int) $row[8] : 2025,
                'target'        => $targetVal,
                'jumlah_output' => $jumlahOutputVal,
                'anggaran'      => $anggaranVal,
                'status'        => $this->normalizeStatus($rawStatus),
                'created_by'    => $defaultUserId,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];

            if (count($data) >= $chunkSize) {
                DB::table('realisasis')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('realisasis')->insert($data);
        }

        fclose($file);
    }

    private function normalizeStatus(?string $status): string
    {
        $key = strtolower(trim((string) $status));

        return $this->statusMap[$key] ?? 'Usulan CPCL';
    }
}