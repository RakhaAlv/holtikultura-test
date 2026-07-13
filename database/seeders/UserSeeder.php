<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Akun User
        $userId = DB::table('users')->insertGetId([
            'id_user' => 1,
            'name' => 'Super Admin',
            'email' => 'admin@hortiku.go.id',
            'password' => Hash::make('password123'),
        ]);

        // 2. Berikan Role Super Admin di Tabel 'roles'
        DB::table('roles')->insert([
            'id_user' => $userId,
            'nama_role' => 'super admin',
            'id_direktorat' => null,
            'id_prov' => null,
            'id_kab' => null,
        ]);
    }
}