<?php

use Illuminate\Support\Facades\Route;

/*Web Routes*/

// Rute untuk Halaman Login (Tampilan Utama)
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk Halaman Register (Sign Up)
Route::get('/register', function () {
    return view('register');
});

// Rute untuk Halaman Dashboard Admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});