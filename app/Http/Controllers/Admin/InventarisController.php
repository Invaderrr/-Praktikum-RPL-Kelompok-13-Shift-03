<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Models\AdminStocking;

class InventarisController extends Controller
{
    public function index()
    {
        // Mengambil semua data bahan baku dan diurutkan berdasarkan ID terbaru
        $inventaris = BahanBaku::orderBy('id_bahan_baku', 'desc')->get();
        
        // Kirim data ke view admin
        return view('admin.inventaris', compact('inventaris'));
    }

    public function store(Request $request)
    {
        // Contoh fungsi tambah data sesuai kolom di image_476d38.png
        $request->validate([
            'nama_bahan' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required',
        ]);

        BahanBaku::create([
            'nama_bahan' => $request->nama_bahan,
            'stok' => $request->stok,
            'kategori' => $request->kategori,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
         
        ]);

        return redirect()->back()->with('success', 'Bahan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required',
        ]);

        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->update([
            'nama_bahan' => $request->nama_bahan,
            'stok' => $request->stok,
            'kategori' => $request->kategori,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Bahan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->delete();

        return redirect()->back()->with('success', 'Bahan berhasil dihapus!');
    }
}
