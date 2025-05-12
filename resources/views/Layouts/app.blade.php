<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acheron Shop</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Memuat CSS dan JS yang dikompilasi oleh Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <!-- Navbar untuk navigasi -->
    <nav
        class="fixed top-0 left-0 right-0 z-50 {{ Route::is(patterns: 'login') || Route::is('register') ? 'bg-transparent' : 'bg-purple-800' }} transition-all duration-300">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo dan link ke halaman utama -->
                <a href="{{ route('home') }}"
                    class="text-xl font-bold text-white hover:text-gray-200 transition {{ Route::is(patterns: 'login') || Route::is('register') ? 'text-purple-600' : 'text-white' }}">
                    CheronShop
                </a>

                <div class="flex items-center space-x-4">
                    @auth
                    @if(auth()->user()->isAdmin())
                    <!-- Link khusus untuk admin -->
                    <a href="{{ route('admin.products.index') }}" class="text-white hover:text-gray-200 transition">
                        Manage Products
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="text-white hover:text-gray-200 transition">
                        Manage Transactions
                    </a>
                    <a href="{{ route('categories.index') }}" class="text-white hover:text-gray-200 transition">
                        Categories
                    </a>
                    @else
                    <!-- Link untuk user -->
                    <a href="{{ route('transactions.index') }}" class="text-white hover:text-gray-200 transition">
                        My Transactionste
                    </a>
                    <a href="{{ route('cart.index') }}" class="text-white hover:text-gray-200 transition">
                        My Cart
                    </a>
                    @endif
                    <!-- Form logout -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-200 transition">
                            Logout
                        </button>
                    </form>

                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten utama -->
    <main class="{{ Route::is('login') || Route::is('register') ? '' : 'container mx-auto mt-16 px-4' }} min-h-screen bg-gray-00">
        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif
        @yield('content')
    </main>
    <!-- Footer -->
    <footer class="w-full bg-gradient-to-r from-blue-600 to-purple-700 py-6 mt-auto">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
            <div class="text-white text-center md:text-left text-sm font-medium">
                &copy; {{ date('Y') }} CheronShop. All rights reserved.
            </div>
            <div class="flex space-x-4 mt-4 md:mt-0 justify-center">
                <a href="#" class="text-white hover:text-blue-200 transition">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="text-white hover:text-blue-200 transition">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-white hover:text-blue-200 transition">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>

</html>