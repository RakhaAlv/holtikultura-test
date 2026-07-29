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

        $password = Hash::make('password123');
        $now = now();

        DB::table('users')->insert([
            [
                'name'          => 'Super Admin',
                'email'         => 'superadmin@hortiku.com',
                'password'      => $password,
                'role_id'       => 1,
                'direktorat_id' => null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],

            [
                'name'          => 'Admin Sayuran',
                'email'         => 'admin.sayuran@hortiku.com',
                'password'      => $password,
                'role_id'       => 2,
                'direktorat_id' => 4, // Direktorat Sayuran dan Tanaman Obat
                'created_at'    => $now,
                'updated_at'    => $now,
            ],

            [
                'name'          => 'Admin Ditjen',
                'email'         => 'admin.setditjen@hortiku.com',
                'password'      => $password,
                'role_id'       => 2,
                'direktorat_id' => 1, // Sekretariat Direktorat Jenderal
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'name'          => 'Admin Perbenihan',
                'email'         => 'admin.perbenihan@hortiku.com',
                'password'      => $password,
                'role_id'       => 2,
                'direktorat_id' => 2, // Direktorat Perbenihan
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'name'          => 'Admin Perlindungan',
                'email'         => 'admin.perlindungan@hortiku.com',
                'password'      => $password,
                'role_id'       => 2,
                'direktorat_id' => 3, // Direktorat Perlindungan
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'name'          => 'Admin Florikultura',
                'email'         => 'admin.buah@hortiku.com',
                'password'      => $password,
                'role_id'       => 2,
                'direktorat_id' => 5, // Direktorat Buah dan Florikultura
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'name'          => 'Admin Hilirisasi',
                'email'         => 'admin.hilirisasi@hortiku.com',
                'password'      => $password,
                'role_id'       => 2,
                'direktorat_id' => 6, // Direktorat Hilirisasi Hasil Hortikultura
                'created_at'    => $now,
                'updated_at'    => $now,
            ],

            [
                'name'          => 'User',
                'email'         => 'userkementrian@hortiku.com',
                'password'      => $password,
                'role_id'       => 3,
                'direktorat_id' => null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ]);
    }
}