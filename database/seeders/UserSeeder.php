<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'username' => 'admin',
                'email' => 'admin@anekasandal.com',
                'password' => Hash::make('password'),
                'full_name' => 'Administrator',
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1, Jakarta',
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'username' => 'customer1',
                'email' => 'customer1@gmail.com',
                'password' => Hash::make('password'),
                'full_name' => 'Budi Santoso',
                'phone' => '081234567891',
                'address' => 'Jl. Mawar No. 10, Bandung',
                'role' => 'customer',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'username' => 'customer2',
                'email' => 'customer2@gmail.com',
                'password' => Hash::make('password'),
                'full_name' => 'Siti Nurhaliza',
                'phone' => '081234567892',
                'address' => 'Jl. Melati No. 15, Surabaya',
                'role' => 'customer',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'username' => 'customer3',
                'email' => 'customer3@gmail.com',
                'password' => Hash::make('password'),
                'full_name' => 'Ahmad Fauzi',
                'phone' => '081234567893',
                'address' => 'Jl. Kenanga No. 20, Yogyakarta',
                'role' => 'customer',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'username' => 'customer4',
                'email' => 'customer4@gmail.com',
                'password' => Hash::make('password'),
                'full_name' => 'Rina Kartika',
                'phone' => '081234567894',
                'address' => 'Jl. Anggrek No. 25, Semarang',
                'role' => 'customer',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('users')->insert($users);
    }
}
