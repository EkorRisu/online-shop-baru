<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model untuk tabel products, mewakili produk di toko
class Product extends Model
{
    // Kolom yang dapat diisi secara massal
    protected $fillable = ['name', 'description', 'price', 'stock', 'image'];
}
