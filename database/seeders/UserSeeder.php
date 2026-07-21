<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('users')->insert([
            [
                'name'          => 'Super Admin',
                'email'         => 'superadmin@hortiku.com',
                'password'      => Hash::make('password123'),
                'role_id'       => 1,
                'direktorat_id' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Admin Sayuran',
                'email'         => 'admin.sayuran@hortiku.com',
                'password'      => Hash::make('password123'),
                'role_id'       => 2,
                'direktorat_id' => 4, // Direktorat Sayuran dan Tanaman Obat
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'User',
                'email'         => 'userkementrian@hortiku.com',
                'password'      => Hash::make('password123'),
                'role_id'       => 3,
                'direktorat_id' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}