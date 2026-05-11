<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\DB;

class BelanjaController extends Controller
{
    public function index()
    {
        // Mengambil produk yang stoknya masih ada (di atas 0)
        $produk = BahanBaku::where('stok', '>', 0)->get();

        return view('user.belanja', compact('produk'));
    }

    public function checkout(Request $request)
    {
        // 'items' dikirim dari JavaScript (isi variabel cart)
        $cart = $request->items;

        if (!$cart) {
            return response()->json(['error' => 'Keranjang kosong!'], 400);
        }

        try {
            // Gunakan Database Transaction agar jika satu gagal, semua dibatalkan
            DB::beginTransaction();

            foreach ($cart as $id => $details) {
                $produk = BahanBaku::find($id);

                if ($produk) {
                    // Cek apakah stok cukup sebelum dikurangi
                    if ($produk->stok >= $details['qty']) {
                        $produk->stok -= $details['qty'];
                        $produk->save();
                    } else {
                        throw new \Exception("Stok {$produk->nama_item} tidak mencukupi!");
                    }
                }
            }

            DB::commit();
            return response()->json(['success' => 'Pembayaran berhasil, stok diperbarui!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function riwayat()
{
    // Mengambil transaksi milik user yang sedang login saja
    $riwayat = \App\Models\Transaksi::with('details')
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

    return view('user.transaksi', compact('riwayat'));
}
}