<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        Schema::disableForeignKeyConstraints();
        DB::table('provinsis')->truncate();
        Schema::enableForeignKeyConstraints();

        $path = database_path('data/provinsi.csv');
        if (!file_exists($path)) return;

        $file = fopen($path, 'r');
        fgetcsv($file, 1000, ';'); // Skip header

        $data = [];
        while (($row = fgetcsv($file, 1000, ';')) !== false) {
            if (!isset($row[0]) || empty($row[0])) continue;

            $data[] = [
                'id'         => (int) $row[0],
                'nama'       => trim(preg_replace('/[^\x20-\x7E]/', '', $row[1])),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($data) >= 1000) {
                DB::table('provinsis')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('provinsis')->insert($data);
        }

        fclose($file);
    }
}