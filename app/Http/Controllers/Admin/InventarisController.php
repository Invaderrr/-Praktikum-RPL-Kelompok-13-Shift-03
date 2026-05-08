<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku; // <--- WAJIB ADA: Biar Controller kenal sama Tabel Bahan Baku
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data dari tabel bahan_baku di database
        $bahan = BahanBaku::all();

        // 2. Lempar data tersebut ke file tampilan (view) kita
        // Path: resources/views/admin/inventaris.blade.php
        return view('admin.inventaris', compact('bahan'));
    }
}