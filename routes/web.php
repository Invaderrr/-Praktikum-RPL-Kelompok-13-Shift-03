<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventarisController;
use Illuminate\Http\Request; // Tambahkan ini
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use App\Http\Controllers\BelanjaController;

/* Web Routes */

// 1. Rute Publik
Route::get('/', function () {
    return view('welcome');
})->name('login');

// TAMBAHKAN INI: Proses pengolahan data login
Route::post('/', function (Request $request) {
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        // Arahkan ke rute 'dashboard' (jembatan pemisah role)
        return redirect()->intended('dashboard');
    }

    // Jika gagal, balik ke halaman login dengan pesan error
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
});

Route::get('/register', function () {
    return view('register');
});

// 2. Rute Terproteksi (Harus Login)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.belanja');
    })->name('dashboard');

    // --- AREA ADMIN ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris');
        Route::get('/pengaturan', function () {
            return view('admin.pengaturan'); 
        })->name('pengaturan');
    });

    // --- AREA USER (PEMBELI) ---
    Route::prefix('user')->name('user.')->group(function () {
        // URL-nya jadi /user/belanja, nama rutenya jadi user.belanja
        Route::get('/belanja', [BelanjaController::class, 'index'])->name('belanja');
        
        // Rute untuk proses potong stok
        Route::post('/checkout', [BelanjaController::class, 'checkout'])->name('checkout');
    });

    // OPSIONAL: Tambahkan rute logout agar bisa ganti akun
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});