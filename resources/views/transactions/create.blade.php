@extends('layouts.app')
@section('content')
    <!-- Form untuk membeli produk -->
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Buy {{ $product->name }}</h1>
        <form method="POST" action="{{ route('transactions.store', $product) }}">
            @csrf
            <!-- Informasi produk -->
            <div class="mb-4">
                <p class="text-lg font-bold">Price: Rp {{ number_format($product->price, 2) }}</p>
                <p class="text-sm">Stock: {{ $product->stock }}</p>
            </div>
            <!-- Input jumlah -->
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="w-full border rounded p-2" min="1" max="{{ $product->stock }}" required>
                @error('quantity')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- Tombol submit -->
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Checkout</button>
        </form>
    </div>
@endsection
