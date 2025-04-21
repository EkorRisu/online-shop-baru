@extends('layouts.app')
@section('content')
    <!-- Form untuk mengedit produk -->
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Edit Product</h1>
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Input nama produk -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ $product->name }}" class="w-full border rounded p-2" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- Input deskripsi -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea name="description" id="description" class="w-full border rounded p-2" required>{{ $product->description }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- Input harga -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700">Price</label>
                <input type="number" name="price" id="price" value="{{ $product->price }}" class="w-full border rounded p-2" step="0.01" required>
                @error('price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- Input stok -->
            <div class="mb-4">
                <label for="stock" class="block text-gray-700">Stock</label>
                <input type="number" name="stock" id="stock" value="{{ $product->stock }}" class="w-full border rounded p-2" required>
                @error('stock')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- Input gambar -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="w-full border rounded p-2">
                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <!-- Menampilkan gambar saat ini -->
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded mt-2">
                @endif
            </div>
            <!-- Tombol submit -->
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Product</button>
        </form>
    </div>
@endsection
