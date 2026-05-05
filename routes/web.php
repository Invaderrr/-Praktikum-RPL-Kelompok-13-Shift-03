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