@extends('layouts.app')
@section('content')
<div class="flex min-h-screen">
    <!-- Left Side - Image -->
    <div class="w-1/2 bg-gradient-to-br from-blue-600 to-purple-700 p-12 flex items-center justify-center">
        <div class="text-white text-center">
            <h1 class="text-4xl font-bold mb-4">Let's Get Started!</h1>
            <div class="relative">
                <img src="{{ asset('images/abstract-bg.jpg') }}" alt="Background" class="rounded-lg opacity-70">
            </div>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="w-1/2 p-12 flex items-center justify-center">
        <div class="w-full max-w-md">
            <h2 class="text-2xl font-bold mb-2">Create Account</h2>

            <form method="POST" action="{{ route('register') }}" class="mt-8">
                @csrf
                <!-- Name Field -->
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Name</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border rounded-md"
                        placeholder="Enter your name" required>
                    @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded-md"
                        placeholder="Enter your email" required>
                    @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Password</label>
                    <div class="relative">
                        <input type="password" name="password" class="w-full px-3 py-2 border rounded-md"
                            placeholder="Create password" required>
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="mb-6">
                    <label class="text-sm text-gray-600">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-md"
                        placeholder="Confirm password" required>
                    @error('password_confirmation')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Terms Checkbox -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox text-blue-600" required>
                        <span class="ml-2 text-sm text-gray-600">I agree with Terms and Privacy Policy</span>
                    </label>
                </div>

                <!-- Create Account Button -->
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
                    Create Account
                </button>
            </form>

            <!-- Social Login -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">OR</span>
                    </div>
                </div>

                <button
                    class="mt-4 w-full flex items-center justify-center gap-2 border border-gray-300 rounded-md py-2 hover:bg-gray-50">
                    <i class="fab fa-google text-red-500"></i>
                    <span>Sign up with Google</span>
                </button>
            </div>

            <!-- Login Link -->
            <p class="mt-8 text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a>
            </p>
        </div>
    </div>
</div>
@endsection