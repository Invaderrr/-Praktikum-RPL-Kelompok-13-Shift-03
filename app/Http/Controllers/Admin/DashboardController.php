<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Data Statistik
        $totalBahan = BahanBaku::count();
        $totalTransaksi = Transaksi::count();
        
        // Gunakan 'subtotal' dari DetailTransaksi atau 'total_harga' jika ada di tabel Transaksi
        $totalPemasukan = DetailTransaksi::sum('subtotal'); 
        
        // Stok menipis di bawah 10 unit
        $stokMenipis = BahanBaku::where('stok', '<', 10)->count();

        // 2. Query Transaksi Terbaru (semua transaksi untuk admin)
        // Kita ambil DetailTransaksi agar bisa menampilkan Nama Bahan dan Subtotal di tabel
        $transaksiTerbaru = DetailTransaksi::with(['bahanBaku', 'transaksi'])
                            ->orderBy('id_detail', 'DESC') 
                            ->take(5)
                            ->get();

        // 3. Return View
        return view('admin.dashboard', compact(
            'totalBahan',
            'totalTransaksi',
            'totalPemasukan',
            'stokMenipis',
            'transaksiTerbaru'
        ));
    }
}
