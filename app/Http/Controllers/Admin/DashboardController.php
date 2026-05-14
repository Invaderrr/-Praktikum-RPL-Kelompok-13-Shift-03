<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class DashboardController extends Controller
{
    public function index()
    {


        // 2. Ambil Data Statistik
        $totalBahan = BahanBaku::count();
        $totalTransaksi = Transaksi::count();
        
        // Sesuai gambar image_39dd3d.png, gunakan 'subtotal' dari DetailTransaksi 
        // atau 'total_harga' jika kolom tersebut ada di tabel Transaksi
        $totalPemasukan = DetailTransaksi::sum('subtotal'); 
        
        // Stok menipis di bawah 10 unit
        $stokMenipis = BahanBaku::where('stok', '<', 10)->count();

        // 3. Perbaikan Query Transaksi Terbaru
        // Kita ambil DetailTransaksi agar bisa menampilkan Nama Bahan dan Subtotal di tabel
        $transaksiTerbaru = DetailTransaksi::with(['bahanBaku', 'transaksi'])
                            ->orderBy('id_detail', 'DESC') 
                            ->take(5)
                            ->get();

        // 4. Return View
        return view('admin.dashboard', compact(
            'totalBahan',
            'totalTransaksi',
            'totalPemasukan',
            'stokMenipis',
            'transaksiTerbaru'
        ));
    }
}