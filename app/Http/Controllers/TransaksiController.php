<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Menampilkan riwayat transaksi pengguna.
     */
    public function index()
    {
        // Menggunakan 'id' sebagai pengganti 'created_at' karena kolom tersebut tidak ada di DB Anda.
        // Kita juga memuat relasi 'details' (pastikan sudah ada di Model Transaksi).
        $riwayat = Transaksi::with('details')
            ->orderBy('id_transaksi')
            ->get();

        return view('user.transaksi', compact('riwayat'));
    }

    /**
     * Menyimpan transaksi baru (Checkout).
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi data yang masuk
            $request->validate([
                'total_harga' => 'required',
                'items' => 'required|array'
            ]);

            // 1. Simpan Header Transaksi
            $transaksi = Transaksi::create([
                'total_harga' => $request->total_harga,
                'metode_pembayaran' => $request->metode_pembayaran ?? 'tunai',
                'status' => 'success',
            ]);

            // 2. Simpan Detail Transaksi (Looping dari keranjang)
            foreach ($request->items as $item) {
                $transaksi->details()->create([
                    'nama_item' => $item['name'],
                    'harga_satuan' => $item['price'],
                    'jumlah' => $item['qty'],
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}