<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder 
{ // <--- KURUNG INI HARUS ADA
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'username' => 'admin123',
            'email' => 'adminstocking@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    }
}