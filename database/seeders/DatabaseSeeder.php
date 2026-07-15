<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // 1. Master Wilayah BPS
            ProvinsiSeeder::class,
            KabupatenSeeder::class,
            KecamatanSeeder::class,
            DesaSeeder::class,

            // 2. Sistem Role & Direktorat
            RoleSeeder::class,
            DirektoratSeeder::class,
            UserSeeder::class,

            // 3. Master Data Hortikultura
            KomoditasSeeder::class,
            KegiatanSeeder::class,

            // 4. Data Transaksional
            TargetSeeder::class,
            RealisasiSeeder::class,
        ]);
    }
}