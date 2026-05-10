<?php

use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventarisController;
>>>>>>> Stashed changes

/*Web Routes*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('register');
});

<<<<<<< Updated upstream
// Rute untuk Halaman Dashboard Admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
=======
// Rute Admin
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/inventaris', [InventarisController::class, 'index'])->name('admin.inventaris');

// Rute untuk Halaman Pengaturan Admin
Route::get('/admin/pengaturan', function () {
    return view('admin.pengaturan'); 
})->name('admin.pengaturan');
>>>>>>> Stashed changes
