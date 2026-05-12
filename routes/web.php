<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventarisController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserPengaturanController; // Import Controller baru
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/* Web Routes */

// 1. Rute Publik (Login & Register)
Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::post('/', function (Request $request) {
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ]);
});

Route::get('/register', function () {
    return view('register');
});

// 2. Rute Terproteksi (Harus Login)
Route::middleware(['auth'])->group(function () {

    // Jembatan pemisah role
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
        
        // Pengaturan Admin (Ganti ke view admin)
        Route::get('/pengaturan', function () {
            return view('admin.pengaturan'); 
        })->name('pengaturan');
    });

    // --- AREA USER (PEMBELI) ---
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/belanja', [BelanjaController::class, 'index'])->name('belanja');
        Route::post('/checkout', [CheckoutController::class, 'proses'])->name('checkout.proses');
        Route::get('/transaksi', [BelanjaController::class, 'riwayat'])->name('transaksi');

        // FITUR PENGATURAN USER (Dihubungkan ke UserPengaturanController)
        Route::get('/pengaturan', [UserPengaturanController::class, 'index'])->name('pengaturan');
        Route::put('/pengaturan/update-photo', [UserPengaturanController::class, 'updatePhoto'])->name('pengaturan.update_photo');
        Route::put('/pengaturan/update-username', [UserPengaturanController::class, 'updateUsername'])->name('pengaturan.update_username');
        Route::put('/pengaturan/update-password', [UserPengaturanController::class, 'updatePassword'])->name('pengaturan.update_password');
    });

    // Logout
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});