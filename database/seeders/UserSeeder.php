<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Administrator Utama',
            'email' => 'admin@surat.com',
            'role' => 'admin', // Penting: role admin
            'password' => Hash::make('password'), // Passwordnya: password
        ]);

        // 2. Buat Akun User Biasa (Staff)
        User::create([
            'name' => 'Staff Administrasi',
            'email' => 'staff@surat.com',
            'role' => 'user', // Penting: role user
            'password' => Hash::make('password'),
        ]);
    }
}