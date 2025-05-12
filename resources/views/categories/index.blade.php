@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <div class="bg-white p-8 rounded-xl shadow-md">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <h1 class="text-3xl font-bold text-gray-800">📂 Categories</h1>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition flex items-center">
                        <i class="fas fa-plus mr-2"></i> Add New Category
                    </a>
                @endif
            @endauth
        </div>

        <!-- Filter & Search -->
        <form action="{{ route('categories.index') }}" method="GET" class="mb-6">
            <div class="flex flex-col md:flex-row gap-2">
                <select name="category_id" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="search" placeholder="Search products..." value="{{ $search ?? '' }}"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-5 py-2 rounded-lg transition">
                    <i class="fas fa-search mr-2"></i> Filter & Search
                </button>
            </div>
        </form>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- List of Categories -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">List of Categories</h2>
            @if ($categories->isEmpty())
                <p class="text-gray-500">No categories available.</p>
            @else
                <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Name</th>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <th class="py-2 px-4 border-b text-left">Actions</th>
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
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">Delete</button>
                                            </form>
                                        </td>
                                    @endif
                                @endauth
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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