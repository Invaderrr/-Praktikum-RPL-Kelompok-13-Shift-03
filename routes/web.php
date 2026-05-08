<?php

use Illuminate\Support\Facades\Route;
// Import Controller agar lebih rapi
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventarisController;

/* Web Routes */

// Rute untuk Halaman Login (Tampilan Utama)
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk Halaman Register (Sign Up)
Route::get('/register', function () {
    return view('register');
});

// Rute Dashboard Admin (Sekarang lewat Controller)
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// Rute untuk Halaman Inventaris Admin
Route::get('/admin/inventaris', [InventarisController::class, 'index'])->name('admin.inventaris');