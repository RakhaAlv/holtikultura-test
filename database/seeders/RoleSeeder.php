<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'nama_role' => 'Super Admin', 'provinsi_id' => null, 'kabupaten_id' => null],
            ['id' => 2, 'nama_role' => 'Admin Direktorat', 'provinsi_id' => null, 'kabupaten_id' => null],
            ['id' => 3, 'nama_role' => 'User', 'provinsi_id' => null, 'kabupaten_id' => null], 
        ]);
    }
}