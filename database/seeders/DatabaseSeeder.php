<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil seeder yang sudah kita buat tadi
        $this->call([
            UserSeeder::class,
            MasterSeeder::class,
        ]);
    }
}