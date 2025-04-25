<?php
namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Cart;
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

    // Menampilkan form untuk membeli produk atau menambah ke keranjang
    public function create(Product $product)
    {
        return view('transactions.create', compact('product'));
    }

    // Memproses pembelian produk langsung
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

    // Menambahkan produk ke keranjang
    public function addToCart(Request $request, Product $product)
    {
        // Validasi jumlah
        $request->validate([
            'quantity' => 'required|integer|min:1|max:'.$product->stock,
        ]);

        // Cek apakah produk sudah ada di keranjang pengguna
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            // Jika sudah ada, tambahkan jumlahnya
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
            ]);
        } else {
            // Jika belum ada, buat item baru di keranjang
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect('/cart')->with('success', 'Product added to cart');
    }

    // Menampilkan halaman keranjang
    public function cart()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login first');
        }

        $cartItems = Cart::where('user_id', Auth::id())->get();
        return view('cart.index', compact('cartItems'));
    }

    // Menghapus item dari keranjang
    public function removeFromCart(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return redirect('/cart')->with('error', 'Unauthorized action');
        }

        $cart->delete();
        return redirect('/cart')->with('success', 'Item removed from cart');
    }

    // Membersihkan semua item di keranjang (clear cart)
    public function clearCart()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login first');
        }

        Cart::where('user_id', Auth::id())->delete();
        return redirect('/cart')->with('success', 'Cart cleared');
    }

    // Memproses pembelian langsung dari keranjang
    public function buyFromCart()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login first');
        }

        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Your cart is empty');
        }

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;

            // Validasi stok
            if ($cartItem->quantity > $product->stock) {
                return redirect('/cart')->with('error', "Not enough stock for {$product->name}");
            }

            // Buat transaksi
            Transaction::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $cartItem->quantity,
                'total_price' => $product->price * $cartItem->quantity,
                'status' => 'pending',
            ]);

            // Kurangi stok produk
            $product->update(['stock' => $product->stock - $cartItem->quantity]);
        }

        // Kosongkan keranjang setelah pembelian
        Cart::where('user_id', Auth::id())->delete();

        return redirect('/transactions')->with('success', 'Purchase completed');
    }

    // Memperbarui status transaksi (hanya untuk admin)
    public function updateStatus(Request $request, Transaction $transaction)
    {
        // Validasi status
        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        // Memperbarui status transaksi
        $transaction->update(['status' => $request->status]);
        return redirect('/admin/transactions')->with('success', 'Transaction updated');
    }
}
