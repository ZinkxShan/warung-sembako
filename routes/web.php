<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BonController;

// Halaman utama redirect ke daftar harga
Route::get('/', function () {
    return redirect()->route('harga');
});

// Halaman daftar harga (publik)
Route::get('/harga', [ProdukController::class, 'harga'])->name('harga');

// Halaman kelola produk (CRUD)
Route::resource('/produk', ProdukController::class)->except(['show']);

// Sistem Bon
Route::get('/bon', [BonController::class, 'index'])->name('bon.index');
Route::get('/bon/riwayat', [BonController::class, 'riwayat'])->name('bon.riwayat');
Route::get('/bon/create', [BonController::class, 'create'])->name('bon.create');
Route::post('/bon', [BonController::class, 'store'])->name('bon.store');
Route::get('/bon/{bon}', [BonController::class, 'show'])->name('bon.show');
Route::post('/bon/{bon}/bayar', [BonController::class, 'bayar'])->name('bon.bayar');
Route::delete('/bon/{bon}', [BonController::class, 'destroy'])->name('bon.destroy');
Route::post('/bon/{bon}/tambah-item', [BonController::class, 'tambahItem'])->name('bon.tambahItem');
Route::delete('/bon-item/{bonItem}/hapus', [BonController::class, 'hapusItem'])->name('bon.hapusItem');