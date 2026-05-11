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
            // 1. Simpan data utama transaksi
            $transaksi = Transaksi::create([
                'user_id' => auth()->id(),
                'total_harga' => $request->total_semua,
                'metode_pembayaran' => $request->metode,
                'alamat' => $request->alamat ?? '-',
                'status' => 'success'
            ]);

            // 2. Simpan detail item & Update Stok
            foreach ($request->items as $item) {
                // Simpan ke tabel detail_transaksis
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'nama_item'    => $item['name'], 
                    'harga_satuan' => $item['price'], 
                    'jumlah'       => $item['qty'],   
                    'subtotal'     => $item['price'] * $item['qty'],
                ]); // <-- Kurung penutup create detail harus di sini

                // 3. Update stok bahan baku (HARUS di dalam foreach)
                $bahan = BahanBaku::where('nama_item', $item['name'])->first(); 
                if ($bahan) {
                    $bahan->decrement('stok', $item['qty']);
                }
            } // <-- Kurung penutup foreach dipindah ke sini

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