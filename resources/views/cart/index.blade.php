@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">My Cart</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <p>Your cart is empty.</p>
            <a href="{{ route('products.index') }}" class="text-blue-500 hover:underline">Continue Shopping</a>
        @else
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Product</th>
                        <th class="py-2 px-4 border-b">Price</th>
                        <th class="py-2 px-4 border-b">Quantity</th>
                        <th class="py-2 px-4 border-b">Subtotal</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $cartItem)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $cartItem->product->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $cartItem->product->price }}</td>
                            <td class="py-2 px-4 border-b">{{ $cartItem->quantity }}</td>
                            <td class="py-2 px-4 border-b">{{ $cartItem->product->price * $cartItem->quantity }}</td>
                            <td class="py-2 px-4 border-b">
                                <form action="{{ route('cart.remove', $cartItem) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 flex justify-between">
                <a href="{{ route('products.index') }}" class="text-blue-500 hover:underline">Continue Shopping</a>
                <div class="space-x-2">
                    <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Clear Cart
                        </button>
                    </form>
                    <form action="{{ route('cart.buy') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Buy Now
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
