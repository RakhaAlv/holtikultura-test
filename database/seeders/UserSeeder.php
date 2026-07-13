<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@hortiku.go.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'kode_direktorat' => null,
        ]);
    }
}