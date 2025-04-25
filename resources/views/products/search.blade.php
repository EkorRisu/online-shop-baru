@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Search Results {{ $category ? "for Category: $category" : '' }}</h1>

        <!-- Form Pencarian -->
        <form action="{{ route('products.search') }}" method="GET" class="mb-4">
            <div class="flex space-x-2">
                <input type="text" name="category" placeholder="Search by category (e.g., electronics)" class="border-gray-300 rounded-md shadow-sm p-2 w-64" value="{{ $category }}">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Search
                </button>
            </div>
        </form>

        @if ($products->isEmpty())
            <p>No products found for category "{{ $category }}".</p>
        @else
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
                            @else
                                <!-- Tombol edit dan delete untuk admin -->
                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>

                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('products.index') }}" class="text-blue-500 hover:underline">Back to All Products</a>
        </div>
    </div>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection
