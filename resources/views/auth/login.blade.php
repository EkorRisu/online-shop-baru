@extends('layouts.app')
@section('content')
<div class="min-h-screen flex flex-col md:flex-row">
    <!-- Left Side - Form -->
    <div class="w-full md:w-1/2 min-h-screen p-6 md:p-12 flex items-center justify-center bg-white">
        <div class="w-full max-w-md space-y-8">
            <!-- Logo -->
            <div class="flex justify-center md:justify-start">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8">
            </div>

            <!-- Header -->
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Welcome back!</h2>
                <p class="mt-2 text-sm text-gray-600">Please enter your login details to continue</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                @csrf
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="mt-1">
                        <input type="email" name="email" 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
                            focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-500 @enderror" 
                            placeholder="Enter your email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1 relative">
                        <input type="password" name="password" id="password"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
                            focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password') border-red-500 @enderror" 
                            placeholder="Enter password">
                        <button type="button" onclick="togglePassword()" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="far fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" 
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Keep me logged in</label>
                    </div>
                    <a href="" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                        Forgot password?
                    </a>
                </div>

                <!-- Login Button -->
                <button type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium 
                    text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                    transition duration-150 ease-in-out">
                    Log in
                </button>
            </form>

            <!-- Social Login -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-4 gap-3">
                    <a href="#" class="flex justify-center items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                        hover:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fab fa-google text-xl text-red-500"></i>
                    </a>
                    <a href="#" class="flex justify-center items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                        hover:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fab fa-facebook-f text-xl text-blue-600"></i>
                    </a>
                    <a href="#" class="flex justify-center items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                        hover:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fab fa-apple text-xl text-gray-800"></i>
                    </a>
                    <a href="#" class="flex justify-center items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                        hover:bg-gray-50 transition duration-150 ease-in-out">
                        <i class="fab fa-twitter text-xl text-blue-400"></i>
                    </a>
                </div>
            </div>

            <!-- Register Link -->
            <p class="mt-8 text-center text-sm text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Create account
                </a>
            </p>
        </div>
    </div>

    <!-- Right Side - Image -->
    <div class="w-full md:w-1/2 min-h-screen bg-gradient-to-br from-blue-600 to-purple-700 
        p-6 md:p-12 flex items-center justify-center relative overflow-hidden">
        <!-- Decorative circles -->
        <div class="absolute top-0 right-0 -mt-12 -mr-12 w-64 h-64 rounded-full bg-purple-500 opacity-20"></div>
        <div class="absolute bottom-0 left-0 -mb-12 -ml-12 w-64 h-64 rounded-full bg-blue-500 opacity-20"></div>
        
        <div class="text-white text-center max-w-lg relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Welcome back!</h1>
            <p class="text-xl md:text-2xl text-white/90 mb-12">Sign in to continue your journey with us</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const icon = event.currentTarget.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endpush
@endsection
