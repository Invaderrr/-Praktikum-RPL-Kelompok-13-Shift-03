<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventarisController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/* Web Routes */

// 1. Rute Publik (Login & Register)
Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::post('/', function (Request $request) {
    // Sesuaikan 'username' atau 'email' dengan yang ada di database kamu
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    // Pastikan key error sesuai dengan input (username)
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
        Route::get('/pengaturan', function () {
            return view('admin.pengaturan'); 
        })->name('pengaturan');
    });

    // --- AREA USER (PEMBELI) ---
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/belanja', [BelanjaController::class, 'index'])->name('belanja');
        
        // Rute Checkout yang benar-benar akan mengisi tabel Transaksi Terbaru
        Route::post('/checkout', [CheckoutController::class, 'proses'])->name('checkout.proses');
    });

    // Logout
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});