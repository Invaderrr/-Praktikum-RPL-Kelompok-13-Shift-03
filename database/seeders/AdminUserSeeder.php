<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder 
{ 
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'username' => 'admin123',
            'email' => 'adminstocking@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Akun User (Pembeli)
        User::create([
            'name' => 'Sarah',
            'username' => 'Sarah123',
            'email' => 'sarah@gmail.com',
            'password' => Hash::make('sarah123'),
            'role' => 'user', 
        ]);
    }
}