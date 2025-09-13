<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Création de l'utilisateur de test (Journaliste par défaut)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Création de l'utilisateur Administrateur
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role_utilisateur' => 'admin',
        ]);
    }
}
