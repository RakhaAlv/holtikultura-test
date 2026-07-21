<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KabupatenSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        Schema::disableForeignKeyConstraints();
        DB::table('kabupatens')->truncate();
        Schema::enableForeignKeyConstraints();

        $path = database_path('data/kabupaten.csv');
        if (!file_exists($path)) return;

        $file = fopen($path, 'r');
        fgetcsv($file, 1000, ';'); // Skip header

        $data = [];
        while (($row = fgetcsv($file, 1000, ';')) !== false) {
            if (!isset($row[2]) || empty($row[2])) continue;

            $data[] = [
                'id'          => (int) $row[2],
                'provinsi_id' => (int) $row[0],
                'nama'        => trim(preg_replace('/[^\x20-\x7E]/', '', $row[3])),
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            if (count($data) >= 1000) {
                DB::table('kabupatens')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('kabupatens')->insert($data);
        }

        fclose($file);
    }
}