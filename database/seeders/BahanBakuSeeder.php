<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Pakai DB facade agar lebih ringan

class BahanBakuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bahan_baku')->insert([
            [
                'nama_item' => 'Gula Pasir',
                'kategori' => 'Bahan Pokok',
                'stok' => 50,
                'stok_min' => 10,
                'satuan' => 'kg',
                'harga' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_item' => 'Tepung Terigu',
                'kategori' => 'Bahan Pokok',
                'stok' => 20,
                'stok_min' => 5,
                'satuan' => 'kg',
                'harga' => 12000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_item' => 'Kopi Arabika',
                'kategori' => 'Minuman',
                'stok' => 10,
                'stok_min' => 2,
                'satuan' => 'kg',
                'harga' => 85000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}