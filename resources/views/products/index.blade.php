@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10">
    <div class="bg-white p-8 rounded-xl shadow-md">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <h1 class="text-3xl font-bold text-gray-800">🛒 Our Products</h1>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.products.create') }}"
                        class="bg-gradient-to-r from-blue-600 to-purple-700 hover:from-blue-700 hover:to-purple-800 text-white font-semibold px-5 py-2 rounded-lg shadow transition flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add Product
                    </a>
                @endif
            @endauth
        </div>

        <!-- Filter & Search -->
        <form action="{{ route('products.index') }}" method="GET" class="mb-8">
            <div class="flex flex-col md:flex-row gap-2">
                <select name="category_id" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category_id==$category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="search" placeholder="Search products..." value="{{ $search }}"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-5 py-2 rounded-lg transition">
                    <i class="fas fa-search mr-2"></i> Filter & Search
                </button>
            </div>
        </form>

        <!-- Daftar produk -->
        @if ($products->isEmpty())
            <p class="text-gray-500 text-center py-8">No products found.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($products as $product)
                <div class="bg-gray-50 p-5 rounded-lg shadow hover:shadow-lg transition">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-48 object-cover rounded mb-3">
                    @endif
                    <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
                    <p class="text-gray-600 text-sm mb-2">{{ $product->description }}</p>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="text-blue-700 font-bold">Rp {{ number_format($product->price, 2) }}</span>
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded">Stock: {{ $product->stock }}</span>
                        <span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded">
                            {{ $product->category instanceof \App\Models\Category ? $product->category->name : 'No Category' }}
                        </span>
                    </div>
                    @auth
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('transactions.create', $product) }}"
                                class="block bg-gradient-to-r from-blue-600 to-purple-700 text-white px-4 py-2 rounded mt-2 text-center font-semibold hover:from-blue-700 hover:to-purple-800 transition">
                                Buy Now
                            </a>
                        @else
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">Delete</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
                @endforeach
            </div>
        @endif
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