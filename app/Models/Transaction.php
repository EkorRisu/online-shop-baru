<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model untuk tabel transactions, mewakili transaksi pembelian
class Transaction extends Model
{
    // Kolom yang dapat diisi secara massal
    protected $fillable = ['user_id', 'product_id', 'quantity', 'total_price', 'status'];

    // Relasi: Transaksi milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Transaksi terkait dengan satu produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
