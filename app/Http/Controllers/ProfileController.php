<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminStocking; 
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updatePhoto(Request $request)
    {
        // 1. Validasi: Pastikan yang diunggah benar-benar gambar, maksimal 2MB
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Deteksi Role dari Session Manual
        $role = session('role');
        $account = null;
        $prefixNamaFile = 'user_';

        if ($role === 'admin') {
            $adminId = session('admin_id');
            $account = AdminStocking::where('id_admin', $adminId)->first();
            $prefixNamaFile = 'admin_';
        } elseif ($role === 'user') {
            $userId = session('user_id');
            $account = User::where('id_user', $userId)->first();
            $prefixNamaFile = 'user_';
        }

        // Jika data akun tidak ditemukan di database
        if (!$account) {
            return redirect()->back()->with('error', 'Akun tidak ditemukan.');
        }

        // 3. Proses Upload File jika ada file yang masuk
if ($request->hasFile('foto')) {
    $file = $request->file('foto');
    
    $idAktif = ($role === 'admin') ? session('admin_id') : session('user_id');
    $namaFile = $prefixNamaFile . $idAktif . '_' . time() . '.' . $file->getClientOriginalExtension();
    
    // PERBAIKAN: Langsung pindahkan file ke folder public/avatars asli laptop Anda
    $file->move(public_path('avatars'), $namaFile);

    // 4. Hapus foto lama di folder public jika bukan foto default
    if ($account->foto && $account->foto !== 'default.png') {
        $pathFotoLama = public_path('avatars/' . $account->foto);
        if (file_exists($pathFotoLama)) {
            unlink($pathFotoLama); // Menghapus file secara langsung lewat PHP
        }
    }

    // 5. Simpan langsung menggunakan objek $account->save()
    $account->foto = $namaFile;
    $account->save(); 

    // 6. Update data foto yang ada di session
    session(['foto' => $namaFile]);
}

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
    }
}