<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Membuat akun admin dengan email dan password default
        User::create([
            'name' => 'Admin',
            'email' => 'admin@shop.com',
            'password' => Hash::make('admin123'), // Password dienkripsi
            'role' => 'admin'
        ]);
    }
}
