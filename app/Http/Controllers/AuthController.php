<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminStocking;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('user.welcome');
    }

    public function showRegister()
    {
        return view('user.register');
    }

    public function register(Request $request)

    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',

            'password' => 'required|string|min:1|confirmed',
        ]);



        // Tabel users pada migration pakai kolom: name, email, password
        \App\Models\User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }


    public function login(Request $request)
    {

        $username = trim($request->username);
        $password = trim($request->password);

        // Hapus session lama
        session()->flush();

        // =========================
        // LOGIN ADMIN
        // =========================
        $admin = AdminStocking::where('username', $username)->first();

        if ($admin && Hash::check($password, $admin->password)) {
            session([
                'admin_id' => $admin->id_admin,
                'username' => $admin->username,
                'role' => 'admin'
            ]);

            return redirect('/admin/dashboard');
        }

        // =========================
        // LOGIN USER
        // =========================
        // tabel users menggunakan kolom: name, email, password
        $user = User::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            session([
                'user_id' => $user->id_user,
                'username' => $user->username,
                'role' => 'user'
            ]);

            return redirect()->route('user.belanja');
        }


        // =========================
        // LOGIN GAGAL
        // =========================
        return back()->with(
            'error',
            'Username atau password salah!'
        );
    }

    public function logout()
    {
        session()->flush();

        return redirect('/');
    }

    /**
     * Tambahkan akun user ke database.
     * Format request: username, email, password
     */
    
}