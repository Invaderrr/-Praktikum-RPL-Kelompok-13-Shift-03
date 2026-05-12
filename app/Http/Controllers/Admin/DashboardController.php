<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku; // <--- Sangat penting supaya bisa ambil data stok
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung jumlah baris di tabel bahan_baku
        $totalBahan = BahanBaku::count();

        // 2. Lempar angka tersebut ke tampilan dashboard
        return view('admin.dashboard', compact('totalBahan'));
    }
}