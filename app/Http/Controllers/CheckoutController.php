<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function proses(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi minimal agar error tidak 500 tanpa pesan jelas
            $request->validate([
                'items' => 'required|array',
                'total_semua' => 'required',
                'metode' => 'required',
                'alamat' => 'nullable'
            ]);

            // 1. Simpan data utama transaksi
            $transaksi = Transaksi::create([
                // Kolom fillable di Model Transaksi: tanggal_transaksi, total_harga, metode_pembayaran, id_user
                'id_user' => auth()->id(),
                'total_harga' => $request->total_semua,
                'metode_pembayaran' => $request->metode,
'tanggal_transaksi' => now()->toDateString(),
                'jam_transaksi' => now()->format('H:i:s'),
            ]);


            // 2. Simpan detail item & Update Stok
            foreach ($request->items as $item) {
                // Cari bahan baku dulu supaya bisa mengisi id_bahan_baku untuk relasi di dashboard admin
                $bahan = BahanBaku::where('nama_bahan', $item['name'])->first();
                if (!$bahan) {
                    $bahan = BahanBaku::where('nama_item', $item['name'])->first();
                }

                if (!$bahan) {
                    throw new \Exception('Bahan baku tidak ditemukan untuk: ' . $item['name']);
                }

                // Simpan detail transaksi (harus pakai id_bahan_baku)
                DetailTransaksi::create([
                    'id_transaksi'    => $transaksi->id_transaksi,
                    'id_bahan_baku'   => $bahan->id_bahan_baku,
                    'harga_satuan'    => $item['price'],
                    'jumlah'          => $item['qty'],
                    'subtotal'        => $item['price'] * $item['qty'],
                ]);

                // Update stok
                $bahan->decrement('stok', $item['qty']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan Berhasil!'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }
}