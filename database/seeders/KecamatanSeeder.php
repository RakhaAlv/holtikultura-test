<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        Schema::disableForeignKeyConstraints();
        DB::table('kecamatans')->truncate();
        Schema::enableForeignKeyConstraints();

        $path = database_path('data/kecamatan.csv');
        if (!file_exists($path)) return;

        $file = fopen($path, 'r');
        fgetcsv($file, 1000, ';'); // Skip header

        $data = [];
        while (($row = fgetcsv($file, 1000, ';')) !== false) {
            if (!isset($row[4]) || empty($row[4])) continue;

            $data[] = [
                'id'           => (int) $row[4],
                'kabupaten_id' => (int) $row[2],
                'nama'         => trim(preg_replace('/[^\x20-\x7E]/', '', $row[5])),
                'created_at'   => now(),
                'updated_at'   => now(),
            ];

            if (count($data) >= 1000) {
                DB::table('kecamatans')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('kecamatans')->insert($data);
        }

        fclose($file);
    }
}