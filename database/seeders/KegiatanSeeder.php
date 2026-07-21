<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        Schema::disableForeignKeyConstraints();
        DB::table('kegiatans')->truncate();
        Schema::enableForeignKeyConstraints();

        $path = database_path('data/kegiatan.csv');
        if (!file_exists($path)) return;

        $file = fopen($path, 'r');
        fgetcsv($file, 1000, ';'); // Skip header

        $data = [];
        while (($row = fgetcsv($file, 1000, ';')) !== false) {
            if (!isset($row[0]) || empty($row[0])) continue;

            $data[] = [
                'kode_kegiatan'       => trim(preg_replace('/[^\x20-\x7E]/', '', $row[2] ?? '1771')),
                'nama_kegiatan'       => trim(preg_replace('/[^\x20-\x7E]/', '', $row[3] ?? $row[1])),
                'kode_rincian_output' => trim(preg_replace('/[^\x20-\x7E]/', '', $row[0])),
                'nama_rincian_output' => trim(preg_replace('/[^\x20-\x7E]/', '', $row[1])),
                'created_at'          => now(),
                'updated_at'          => now(),
            ];

            if (count($data) >= 500) {
                DB::table('kegiatans')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('kegiatans')->insert($data);
        }

        fclose($file);
    }
}