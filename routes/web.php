<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventarisController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('register');
});

// --- BAGIAN ADMIN ---

// Cukup pakai yang ini saja (yang ada Controller-nya)
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/inventaris', [InventarisController::class, 'index'])->name('admin.inventaris');

// Rute untuk Halaman Pengaturan Admin
Route::get('/admin/pengaturan', function () {
    return view('admin.pengaturan'); 
})->name('admin.pengaturan');