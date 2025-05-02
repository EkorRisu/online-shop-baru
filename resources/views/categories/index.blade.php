@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Categories</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form untuk filter dan search -->
        <form action="{{ route('categories.index') }}" method="GET" class="mb-4">
            <div class="flex space-x-2">
                <!-- Dropdown untuk memfilter kategori -->
                <select name="category_id" class="border-gray-300 rounded-md shadow-sm p-2 w-64">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>

                <!-- Search bar untuk mencari produk -->
                <input type="text" name="search" placeholder="Search products..." class="border-gray-300 rounded-md shadow-sm p-2 w-64" value="{{ $search }}">

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filter & Search
                </button>
            </div>
        </form>

        <!-- Tombol tambah kategori (hanya untuk admin) -->
        @auth
            @if(auth()->user()->isAdmin())
                <div class="mb-4">
                    <a href="{{ route('admin.categories.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Add New Category
                    </a>
                </div>
            @endif
        @endauth

        <!-- Daftar Kategori -->
        @if ($categories->isEmpty())
            <p>No categories available.</p>
        @else
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">List of Categories</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Name</th>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <th class="py-2 px-4 border-b">Actions</th>
                                @endif
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $category->name }}</td>
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <td class="py-2 px-4 border-b">
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                                            </form>
                                        </td>
                                    @endif
                                @endauth
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Daftar Produk -->
        <h2 class="text-xl font-semibold mb-2">Products</h2>
        @if ($products->isEmpty())
            <p>No products found.</p>
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
                        <p class="text-sm">Category: {{ $product->category instanceof \App\Models\Category ? $product->category->name : 'No Category' }}</p>

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
