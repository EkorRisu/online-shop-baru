<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller untuk mengelola transaksi (beli, lihat, terima/reject)
class TransactionController extends Controller
{
    // Menampilkan daftar transaksi (semua untuk admin, milik user untuk user)
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login first');
        }

        $transactions = Auth::user()->isAdmin()
            ? Transaction::all()
            : Auth::user()->transactions;
        return view('transactions.index', compact('transactions'));
    }

    // Menampilkan form untuk membeli produk
    public function create(Product $product)
    {
        return view('transactions.create', compact('product'));
    }

    // Memproses pembelian produk
    public function store(Request $request, Product $product)
    {
        // Validasi jumlah yang dibeli
        $request->validate([
            'quantity' => 'required|integer|min:1|max:'.$product->stock,
        ]);

        // Menghitung total harga
        $total_price = $product->price * $request->quantity;

        // Membuat transaksi baru
        Transaction::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'status' => 'pending',
        ]);

        // Mengurangi stok produk
        $product->update(['stock' => $product->stock - $request->quantity]);
        return redirect('/transactions')->with('success', 'Transaction created');
    }

    // Memperbarui status transaksi (hanya untuk admin)
    public function updateStatus(Request $request, Transaction $transaction)
    {
        // Validasi status
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        // Memperbarui status transaksi
        $transaction->update(['status' => $request->status]);
        return redirect('/admin/transactions')->with('success', 'Transaction updated');

    }


}
