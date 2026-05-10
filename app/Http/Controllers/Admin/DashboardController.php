<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BahanBaku; // Pastikan ini ada!

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah baris di tabel bahan_baku
        $totalBahan = BahanBaku::count(); 
        
        return view('admin.dashboard', compact('totalBahan'));
    }
}