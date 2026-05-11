<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder yang sudah kamu buat di sini
        $this->call([
            AdminUserSeeder::class,
            BahanBakuSeeder::class,
        ]);
    }
}