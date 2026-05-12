<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserPengaturanController extends Controller
{
    /**
     * Menampilkan halaman pengaturan user.
     */
    public function index()
    {
        return view('user.pengaturan'); 
    }

    /**
     * Update foto profil user (Logika disamakan dengan Admin).
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama dari storage jika ada untuk menghemat ruang
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }

            // Simpan foto baru ke folder public/profile_photos
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            
            // Update path di database
            $user->update([
                'profile_photo' => $path
            ]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Update Username melalui Modal Pop-up.
     */
    public function updateUsername(Request $request)
    {
        $request->validate([
            'new_username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'current_password' => 'required',
        ], [
            'new_username.unique' => 'Username sudah digunakan oleh orang lain.',
            'current_password.required' => 'Password wajib diisi untuk konfirmasi.',
        ]);

        $user = Auth::user();

        // Verifikasi apakah password yang dimasukkan di modal benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password yang anda masukkan salah.']);
        }

        $user->update([
            'username' => $request->new_username
        ]);

        return back()->with('success', 'Username berhasil diubah menjadi ' . $request->new_username);
    }

    /**
     * Update Password melalui Modal Pop-up.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8'],
            'current_password' => 'required',
        ], [
            'new_password.min' => 'Password baru minimal harus 8 karakter.',
            'current_password.required' => 'Password saat ini wajib diisi.',
        ]);

        $user = Auth::user();

        // Verifikasi password lama sebelum mengganti ke yang baru
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama anda tidak sesuai.']);
        }

        // Simpan password baru dengan enkripsi Hash
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}