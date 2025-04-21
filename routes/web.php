<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Rute untuk autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); // Halaman login
Route::post('/login', [AuthController::class, 'login']); // Proses login
Route::get('/register', [AuthController::class, 'showRegister'])->name('register'); // Halaman registrasi
Route::post('/register', [AuthController::class, 'register']); // Proses registrasi
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Proses logout

// Rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('home'); // Halaman utama (daftar produk)

    // Tambahan: Rute produk untuk user biasa
    Route::get('/products', [ProductController::class, 'index'])->name('products.index'); // Daftar produk

    // Rute untuk user
    Route::get('/buy/{product}', [TransactionController::class, 'create'])->name('transactions.create'); // Form pembelian
    Route::post('/buy/{product}', [TransactionController::class, 'store'])->name('transactions.store'); // Proses pembelian
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index'); // Daftar transaksi user

    // Rute untuk download PDF (dipindahkan ke sini agar bisa diakses oleh user dan admin)
    Route::get('/transactions/download-pdf', [TransactionController::class, 'downloadPDF'])->name('transactions.downloadPDF');

    // Rute untuk admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Produk
        Route::get('/products', [ProductController::class, 'index'])->name('products.index'); // Daftar produk admin
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); // Form tambah produk
        Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // Simpan produk
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit'); // Form edit produk
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update'); // Update produk
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy'); // Hapus produk

        // Transaksi
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index'); // Daftar transaksi admin
        Route::put('/transactions/{transaction}', [TransactionController::class, 'updateStatus'])->name('transactions.update'); // Update status transaksi
    });
});
