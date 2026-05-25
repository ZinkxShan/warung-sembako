<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

// Halaman utama redirect ke daftar harga
Route::get('/', function () {
    return redirect()->route('harga');
});

// Halaman daftar harga (publik)
Route::get('/harga', [ProdukController::class, 'harga'])->name('harga');

// Halaman kelola produk (CRUD)
Route::resource('/produk', ProdukController::class)->except(['show']);