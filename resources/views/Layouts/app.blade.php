<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shop</title>
    <!-- Memuat CSS dan JS yang dikompilasi oleh Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Navbar untuk navigasi -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between">
            <!-- Logo dan link ke halaman utama -->
            <a href="{{ route('home') }}" class="text-xl font-bold">Online Shop</a>
            <div>
                @auth
                    @if(auth()->user()->isAdmin())
                        <!-- Link khusus untuk admin -->
                        <a href="{{ route('admin.products.index') }}" class="mr-4">Manage Products</a>
                        <a href="{{ route('admin.transactions.index') }}" class="mr-4">Manage Transactions</a>
                        <a href="{{ route('categories.index') }}" class="text-white hover:text-gray-300">Categories</a>
                    @else
                        <!-- Link untuk user -->
                        <a href="{{ route('transactions.index') }}" class="mr-4">My Transactions</a>
                    @endif
                    <!-- Form logout -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-white">Logout</button>
                    </form>
                @else
                    <!-- Link untuk pengguna yang belum login -->
                    <a href="{{ route('login') }}" class="mr-4">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>
    <!-- Konten utama -->
    <main class="container mx-auto mt-8">
        <!-- Menampilkan pesan sukses -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <!-- Menampilkan pesan clamor -->
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
