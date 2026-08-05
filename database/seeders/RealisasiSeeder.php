<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class RealisasiSeeder extends Seeder
{

    private array $statusMap = [
        'usulan cpcl'                 => 'Usulan CPCL',
        'kontrak/pks'                 => 'Kontrak/PKS',
        'kontrak / pks'               => 'Kontrak/PKS',
        'pemberkasan dokumen pencairan' => 'Pemberkasan Dokumen Pencairan',
        'distribusi bantuan'          => 'Distribusi Bantuan',
        'bantuan sudah diterima'      => 'Bantuan Sudah Diterima',
        'belum ditentukan'            => 'Usulan CPCL',
    ];

    public function run(): void
    {
        DB::disableQueryLog();

        Schema::disableForeignKeyConstraints();
        DB::table('realisasis')->truncate();
        Schema::enableForeignKeyConstraints();

        $path = database_path('data/banper.csv');
        if (!file_exists($path)) {
            throw new RuntimeException("File data banper tidak ditemukan pada path: {$path}");
        }

        $kegiatanMap    = DB::table('kegiatans')->pluck('id', 'kode_rincian_output')->toArray();
        $desaCache      = DB::table('desas')->pluck('id', 'id')->toArray();
        $komoditasCache = DB::table('komoditas')->pluck('id', 'id')->toArray();
        $satuanCache    = DB::table('satuans')->pluck('id', 'id')->toArray();
        $provinsiCache  = DB::table('provinsis')->pluck('id', 'id')->toArray();
        $kabupatenCache = DB::table('kabupatens')->pluck('id', 'id')->toArray();
        $kecamatanCache = DB::table('kecamatans')->pluck('id', 'id')->toArray();

        $defaultKegiatanId  = DB::table('kegiatans')->value('id') ?? 1;
        $defaultKomoditasId = 1;
        $defaultSatuanId    = 1;
        $defaultUserId      = 1;

        $file = fopen($path, 'r');
        fgetcsv($file, 0, ';'); // Skip Header Row

        $data = [];
        $chunkSize = 1000;

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            $kodeDesa = (int) preg_replace('/[^0-9]/', '', $row[16] ?? '');

            if ($kodeDesa < 1000000000 || !isset($desaCache[$kodeDesa])) {
                continue;
            }

            $provinsiId  = !empty($row[10]) ? (int) $row[10] : 0;
            $kabupatenId = !empty($row[12]) ? (int) $row[12] : 0;
            $kecamatanId = !empty($row[14]) ? (int) $row[14] : 0;

            if (!isset($provinsiCache[$provinsiId]) || !isset($kabupatenCache[$kabupatenId]) || !isset($kecamatanCache[$kecamatanId])) {
                continue;
            }

            $rawKomoditasId = !empty($row[7]) ? (int) $row[7] : 0;
            $komoditasId    = isset($komoditasCache[$rawKomoditasId]) ? $rawKomoditasId : $defaultKomoditasId;

            $rawSatuanId = !empty($row[20]) ? (int) $row[20] : 0;
            $satuanId    = isset($satuanCache[$rawSatuanId]) ? $rawSatuanId : $defaultSatuanId;

            $direktoratId = !empty($row[1]) ? (int) $row[1] : 1;
            $kodeKegiatan = trim(preg_replace('/[^\x20-\x7E]/', '', $row[5] ?? ''));
            $kegiatanId   = $kegiatanMap[$kodeKegiatan] ?? $defaultKegiatanId;

            $namaKelompok = trim(preg_replace('/[^\x20-\x7E]/', '', $row[17] ?? ''));
            $rawStatus    = trim(preg_replace('/[^\x20-\x7E]/', '', $row[24] ?? ''));
            $tahun        = !empty($row[8]) ? (int) $row[8] : 2025;

            if ($tahun <= 2025) {
                $status = 'Bantuan Sudah Diterima';
            } else {
                $status = $this->normalizeStatus($rawStatus);
            }

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
                'tahun'         => $tahun,
                'jumlah_output' => $this->sanitizeDecimal($row[21] ?? '0'),
                'anggaran'      => $this->sanitizeDecimal($row[23] ?? '0'),
                'status'        => $status,
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

    private function sanitizeDecimal(?string $value): float
    {
        if (empty($value)) return 0.0;
        
        // Bersihkan non-breaking space & whitespace
        $value = trim(preg_replace('/[^\x20-\x7E]/', '', $value));

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

    private function normalizeStatus(?string $status): string
    {
        $key = strtolower(trim((string) $status));

        return $this->statusMap[$key] ?? 'Usulan CPCL';
    }
}