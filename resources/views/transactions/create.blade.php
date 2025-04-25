@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Buy Product: {{ $product->name }}</h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <p><strong>Price:</strong> {{ $product->price }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>

            <form action="{{ route('transactions.store', $product) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="1" max="{{ $product->stock }}" value="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('quantity')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Buy Now
                </button>
            </form>

            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="quantity_cart" class="block text-sm font-medium text-gray-700">Quantity (Add to Cart)</label>
                    <input type="number" name="quantity" id="quantity_cart" min="1" max="{{ $product->stock }}" value="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('quantity')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>
@endsection
