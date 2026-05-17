<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventarisController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk Halaman Depan / Welcome
Route::get('/', function () {
    return view('user.welcome');
})->name('welcome'); // Tambahkan nama route untuk memudahkan redirect

// Route Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- KELOMPOK USER ---
Route::prefix('user')->group(function () {
    
    // Halaman Belanja
    Route::get('/belanja', [BelanjaController::class, 'index'])->name('user.belanja');

    // Proses Checkout
    Route::post('/checkout/proses', [CheckoutController::class, 'proses'])->name('user.checkout.proses');

    // Halaman Transaksi
   Route::get('/transaksi', [TransaksiController::class, 'index'])->name('user.transaksi');
    

    // Halaman Pengaturan User
    Route::get('/pengaturan', function () {
        return view('user.pengaturan');
    })->name('user.pengaturan');

    // Endpoint untuk tombol-tombol di halaman user.pengaturan.blade.php
    // (dummy redirect dulu supaya tombol bisa diklik tanpa error)
    Route::put('/pengaturan/update-photo', [ProfileController::class, 'updatePhoto'])->name('user.pengaturan.update_photo');

    Route::put('/pengaturan/update-username', function () {
        return redirect()->route('user.pengaturan')->with('success', 'Username diperbarui!');
    })->name('user.pengaturan.update_username');

    Route::put('/pengaturan/update-password', function () {
        return redirect()->route('user.pengaturan')->with('success', 'Password diperbarui!');
    })->name('user.pengaturan.update_password');
});

// --- KELOMPOK ADMIN ---
Route::prefix('admin')->group(function () {
    
    // PERBAIKAN: Jangan tulis /admin lagi di sini karena sudah ada prefix
    // URL ini akan menjadi: namadomain.com/admin/dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // URL ini akan menjadi: namadomain.com/admin/inventaris
    Route::get('inventaris', [InventarisController::class, 'index'])->name('admin.inventaris');
    Route::post('inventaris', [InventarisController::class, 'store'])->name('admin.inventaris.store');
    Route::put('inventaris/{id}', [InventarisController::class, 'update'])->name('admin.inventaris.update');
    Route::delete('inventaris/{id}', [InventarisController::class, 'destroy'])->name('admin.inventaris.destroy');
    
    
    // URL ini akan menjadi: namadomain.com/admin/pengaturan
    Route::get('/pengaturan', function () {
        return view('admin.pengaturan');
    })->name('admin.pengaturan');
});