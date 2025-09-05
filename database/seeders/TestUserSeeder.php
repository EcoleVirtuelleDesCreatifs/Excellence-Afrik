<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user for testing
        User::create([
            'name' => 'Deza Auguste César',
            'email' => 'admin@excellenceafrik.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create editor user for testing
        User::create([
            'name' => 'Sarah Koné',
            'email' => 'sarah@excellenceafrik.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create writer user for testing
        User::create([
            'name' => 'Kwame Asante',
            'email' => 'kwame@excellenceafrik.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
    }
}
