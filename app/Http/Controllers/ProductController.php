<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

// Controller untuk mengelola produk (CRUD)
class ProductController extends Controller
{
    // Menampilkan daftar semua produk
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Menampilkan form untuk membuat produk baru
    public function create()
    {
        return view('products.create');
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image',
        ]);

        $data = $request->all();
        // Menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Membuat produk baru
        Product::create($data);
        return redirect('/admin/products')->with('success', 'Product created');
    }

    // Menampilkan form untuk mengedit produk
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Memperbarui produk di database
    public function update(Request $request, Product $product)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image',
        ]);

        $data = $request->all();
        // Memperbarui gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Memperbarui produk
        $product->update($data);
        return redirect('/admin/products')->with('success', 'Product updated');
    }

    // Menghapus produk dari database
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/admin/products')->with('success', 'Product deleted');
    }
}
