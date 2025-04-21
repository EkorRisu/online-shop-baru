@extends('layouts.app')
@section('content')
    <!-- Form registrasi -->
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Register</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- Input nama -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="w-full border rounded p-2" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- Input email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full border rounded p-2" required>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- Input password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full border rounded p-2" required>
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- Input konfirmasi password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border rounded p-2" required>
            </div>
            <!-- Tombol submit -->
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</button>
        </form>
    </div>
@endsection
