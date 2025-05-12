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
        User::firstOrCreate(
            ['email' => 'admin@shop.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );
    
        // Membuat akun user dengan email dan password default
        User::firstOrCreate(
            ['email' => 'user@shop.com'],
            [
                'name' => 'User', // Fixed name from 'Admin' to 'User'
                'password' => Hash::make('12345'),
                'role' => 'user'
            ]
        );
    }
    
}
