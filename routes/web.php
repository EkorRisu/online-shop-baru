<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Rute untuk autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('home');

    // Tambahan: Rute produk untuk user biasa
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Rute untuk pencarian berdasarkan kategori
    Route::get('/products/search', [ProductController::class, 'searchByCategory'])->name('products.search');

    // Rute untuk user
    Route::get('/buy/{product}', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/buy/{product}', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // Rute untuk keranjang
    Route::post('/cart/add/{product}', [TransactionController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [TransactionController::class, 'cart'])->name('cart.index');
    Route::delete('/cart/remove/{cart}', [TransactionController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/buy', [TransactionController::class, 'buyFromCart'])->name('cart.buy');
    Route::post('/cart/clear', [TransactionController::class, 'clearCart'])->name('cart.clear');

    // Rute untuk admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Produk
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Transaksi
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::put('/transactions/{transaction}', [TransactionController::class, 'updateStatus'])->name('transactions.update');
    });
});
