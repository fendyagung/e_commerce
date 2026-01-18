<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SlideshowController;
use App\Http\Controllers\ProdukPromoController; // Tambahkan ini
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartDetailController;
use App\Http\Controllers\AlamatPengirimanController;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::any('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/dashboard', function () {
    return redirect('/admin');
});
Route::get('/produk/promo', function () {
    return redirect('/admin/produk/promo');
});

Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/about', [HomepageController::class, 'about'])->name('about');
Route::get('/kontak', [HomepageController::class, 'kontak'])->name('kontak');
Route::get('/kategori', [HomepageController::class, 'kategori'])->name('homepage.kategori');
Route::get('/kategori/{slug}', [HomepageController::class, 'kategori'])->name('kategori.detail');
Route::get('/produk', [HomepageController::class, 'produk'])->name('homepage.produk');
Route::get('/produk/{id}', [HomepageController::class, 'produkdetail'])->name('produk.detail');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin');

    // Tambahan route package kategori
    Route::resource('/kategori', KategoriController::class)->names('kategori');
    Route::post('imagekategori', [KategoriController::class, 'uploadimage']);
    Route::delete('imagekategori/{id}', [KategoriController::class, 'deleteimage']);

    // Tambahan route package produk promo
    Route::resource('produk/promo', ProdukPromoController::class)->names('promo');

    // Route untuk load async produk (digunakan di JavaScript edit/create promo)
    Route::get('loadprodukasync/{id}', [ProdukController::class, 'loadasync']);

    // Tambahan route package produk
    Route::resource('/produk', ProdukController::class)->names('produk');

    // Route Khusus untuk Multi-Image Produk (Sesuai view produk.show)
    Route::post('produkimage', [ProdukController::class, 'uploadimage']);
    Route::delete('produkimage/{id}', [ProdukController::class, 'deleteimage']);

    // Tambahan route package slideshow
    Route::resource('/slideshow', SlideshowController::class)->names('slideshow');

    // Tambahan route package customer
    Route::resource('/customer', CustomerController::class)->names('customer');

    // Tambahan route package transaksi
    Route::resource('/transaksi', TransaksiController::class)->names('transaksi');

    // Tambahan route package user
    Route::get('/profil', [UserController::class, 'index'])->name('profil');
    Route::get('/setting', [UserController::class, 'setting'])->name('setting');
    Route::post('/updateprofil', [UserController::class, 'updateprofil'])->name('user.updateprofil');
    Route::post('/uploadfoto', [UserController::class, 'uploadfoto'])->name('user.uploadfoto');

    // Tambahan route untuk Image Manager
    Route::get('image', [ImageController::class, 'index'])->name('image.index');
    Route::post('image', [ImageController::class, 'store'])->name('image.store');
    Route::delete('image/{id}', [ImageController::class, 'destroy'])->name('image.destroy');

    // Alamat Pengiriman
    Route::resource('alamatpengiriman', AlamatPengirimanController::class);

    // Laporan
    Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/proses', [App\Http\Controllers\LaporanController::class, 'proses'])->name('laporan.proses');
});

// shopping cart
Route::group(['middleware' => 'auth'], function () {
    // cart
    Route::resource('/cart', CartController::class);
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::patch('kosongkan/{id}', [CartController::class, 'kosongkan']);
    // cart detail
    Route::resource('/cartdetail', CartDetailController::class);
});