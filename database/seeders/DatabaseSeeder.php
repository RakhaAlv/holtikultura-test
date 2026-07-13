<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // 1. Master Data Utama
            UserSeeder::class,

            // 2. Master Wilayah
            ProvinsiSeeder::class,
            KabupatenSeeder::class,
            KecamatanSeeder::class,
            DesaSeeder::class,

            // 3. Master Operasional
            KegiatanSeeder::class,
            KomoditasSeeder::class,
            
            // 4. Transaksional
            TargetSeeder::class,
            RealisasiSeeder::class,
        ]);
    }
}