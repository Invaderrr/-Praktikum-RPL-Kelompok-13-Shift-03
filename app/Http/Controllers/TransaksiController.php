<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Menampilkan riwayat transaksi pengguna.
     */
    public function index()
    {
        $userId = session('user_id');
        $role = session('role');

        // Jika admin, tampilkan semua transaksi, kalau bukan tampilkan milik user saja
        $query = Transaksi::with('details')->orderBy('id_transaksi', 'desc');

        if ($role !== 'admin') {
            if (!$userId) {
                // Tidak ada user pada session -> kosongkan hasil
                $riwayat = collect();
                return view('user.transaksi', compact('riwayat'));
            }
            $query->where('id_user', $userId);
        }

        $riwayat = $query->get();

        return view('user.transaksi', compact('riwayat'));
    }

    /**
     * Menyimpan transaksi baru (Checkout).
     */
    public function store(Request $request)
    {
        // Ambil user dari session terlebih dahulu sebelum jalankan database transaction
        $userId = session('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'error' => 'User tidak terautentikasi pada session. Silakan login kembali.'], 401);
        }

        // Validasi data awal yang masuk
        $request->validate([
            'total_harga' => 'required|numeric',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.qty' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            // 1. Simpan Header Transaksi (simpan tanggal/jam dan id_user)
            $transaksi = Transaksi::create([
                'id_user' => $userId,
                'tanggal_transaksi' => date('Y-m-d'),
                'jam_transaksi' => date('H:i:s'),
                'total_harga' => $request->total_harga,
                'metode_pembayaran' => $request->metode_pembayaran ?? ($request->metode ?? 'tunai'),
            ]);

            // 2. Simpan Detail Transaksi & Kurangi Stok Bahan Baku
            foreach ($request->items as $item) {
                // Cari bahan baku berdasarkan nama_bahan atau nama_item
                $bahan = BahanBaku::where('nama_bahan', $item['name'])
                                  ->orWhere('nama_item', $item['name'])
                                  ->first();

                if (!$bahan) {
                    throw new \Exception("Bahan baku dengan nama '" . $item['name'] . "' tidak ditemukan di sistem.");
                }

                // Cek apakah stok mencukupi
                if ($bahan->stok < $item['qty']) {
                    throw new \Exception("Stok '" . $bahan->nama_bahan . "' tidak mencukupi. Sisa stok: " . $bahan->stok);
                }

                // Hitung subtotal
                $subtotal = $item['price'] * $item['qty'];

                // Simpan ke tabel detail_transaksi
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_bahan_baku' => $bahan->id_bahan_baku, // Menggunakan ID asli dari database
                    'harga_satuan' => $item['price'],
                    'jumlah' => $item['qty'],
                    'subtotal' => $subtotal,
                ]);

                // Kurangi stok bahan baku secara otomatis
                $bahan->decrement('stok', $item['qty']);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan dan stok telah diperbarui']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}