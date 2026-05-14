<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\DB;

class BelanjaController extends Controller
{
    public function index()
    {
        // Proteksi: Gunakan auth() check jika menggunakan sistem login Laravel standar
        // atau tetap gunakan session jika kamu mengaturnya manual
        if (session('role') !== 'user') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai user.');
        }

        // PERBAIKAN: Ubah nama variabel menjadi $produk agar sesuai dengan @foreach di Blade
        $produk = BahanBaku::where('stok', '>', 0)->get();

        return view('user.belanja', compact('produk'));
    }

    public function checkout(Request $request)
    {
        $cart = $request->items;
        $alamat = $request->alamat;
        $metode = $request->metode;

        if (!$cart || count($cart) == 0) {
            return response()->json(['error' => 'Keranjang kosong!'], 400);
        }

        if (empty($alamat)) {
            return response()->json(['error' => 'Alamat pengiriman wajib diisi!'], 400);
        }

        try {
            DB::beginTransaction();

            foreach ($cart as $id => $details) {
                // Mencari berdasarkan ID primer (Primary Key)
                $produk = BahanBaku::find($id);

                if (!$produk) {
                    throw new \Exception("Produk dengan ID {$id} tidak ditemukan!");
                }

                if ($produk->stok < $details['qty']) {
                    // Gunakan nama kolom yang benar sesuai database (nama_item atau nama_bahan)
                    $namaProduk = $produk->nama_item ?? $produk->nama_bahan;
                    throw new \Exception("Stok {$namaProduk} tidak mencukupi!");
                }

                // Kurangi stok
                $produk->decrement('stok', $details['qty']);
            }

            // Optional: Tambahkan simpan data ke tabel Transaksi di sini
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil, stok telah diperbarui!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}