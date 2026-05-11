<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use App\Models\Transaksi; // Tambahkan ini
use App\Models\DetailTransaksi; // Tambahkan ini
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung jumlah baris di tabel bahan_baku
        $totalBahan = BahanBaku::count();

        // 2. Menghitung Total Transaksi (Jumlah baris di tabel transaksis)
        $totalTransaksi = Transaksi::count();

        // 3. Menghitung Total Pendapatan
        $totalPemasukan = Transaksi::sum('total_harga');

        // 4. Mendeteksi Stok Menipis (Misal: stok di bawah 10)
        $stokMenipis = BahanBaku::where('stok', '<', 10)->count();

        // 5. Mengambil Transaksi Terbaru beserta detail itemnya
        // Kita panggil relasi 'details' yang sudah dibuat di Model Transaksi
        $transaksiTerbaru = Transaksi::with(['user', 'details'])
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // 6. Lempar semua variabel ke tampilan dashboard
        return view('admin.dashboard', compact(
            'totalBahan', 
            'totalTransaksi', 
            'totalPemasukan', 
            'stokMenipis', 
            'transaksiTerbaru'
        ));
    }
}