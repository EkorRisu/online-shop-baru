@extends('layouts.app')
@section('content')
    <!-- Daftar produk -->
    <h1 class="text-2xl font-bold mb-4">Products</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="bg-white p-4 rounded-lg shadow-md">
                <!-- Gambar produk -->
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded">
                @endif
                <!-- Informasi produk -->
                <h2 class="text-xl font-semibold mt-2">{{ $product->name }}</h2>
                <p class="text-gray-600">{{ $product->description }}</p>
                <p class="text-lg font-bold mt-2">Rp {{ number_format($product->price, 2) }}</p>
                <p class="text-sm">Stock: {{ $product->stock }}</p>
                @auth
                    @if(!auth()->user()->isAdmin())
                        <!-- Tombol beli untuk user -->
                        <a href="{{ route('transactions.create', $product) }}" class="bg-blue-600 text-white px-4 py-2 rounded mt-2 inline-block hover:bg-blue-700">Buy Now</a>
                    @endif
                @endauth
            </div>
        @endforeach
    </div>
    @auth
        @if(auth()->user()->isAdmin())
            <!-- Tombol tambah produk untuk admin -->
            <a href="{{ route('admin.products.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mt-4 inline-block hover:bg-green-700">Add Product</a>
        @endif
    @endauth
@endsection
