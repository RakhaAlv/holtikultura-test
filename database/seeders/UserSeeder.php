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
            [
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'superadmin@hortiku.com',
                'password' => Hash::make('password123'),
                'role_id' => 1,
                'direktorat_id' => null,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Admin Sayuran',
                'email' => 'admin.sayuran@hortiku.com',
                'password' => Hash::make('password123'),
                'role_id' => 2,
                'direktorat_id' => 4,
                'created_at' => now(),
                    ],

            [
                'id' => 3,
                'name' => 'User',
                'email' => 'userkementrian@hortiku.com',
                'password' => Hash::make('password123'),
                'role_id' => 3,
                'direktorat_id' => null,
                'created_at' => now(),
                    ]
            
        ]);
    }
}