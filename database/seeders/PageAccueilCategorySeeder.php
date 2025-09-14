<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageAccueilCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer le premier utilisateur (admin)
        $user = User::first();
        if (!$user) {
            $this->command->error('Aucun utilisateur trouvé. Veuillez créer un utilisateur d\'abord.');
            return;
        }

        // Créer catégorie parent "Page accueil"
        $pageAccueilCategory = Category::create([
            'name' => 'Page accueil',
            'slug' => 'page-accueil',
            'description' => 'Catégorie pour les contenus de la page d\'accueil',
            'status' => 'active',
            'is_active' => true,
            'user_id' => $user->id,
            'sort_order' => 1
        ]);

        // Créer sous-catégories pour la page d'accueil
        $sousCategories = [
            [
                'name' => 'Top 3 Actualité du jour',
                'slug' => 'top-3-actualite-du-jour',
                'description' => 'Les 3 articles principaux en vedette sur la page d\'accueil',
                'parent_id' => $pageAccueilCategory->id
            ],
            [
                'name' => 'Actualités à la une',
                'slug' => 'actualites-a-la-une',
                'description' => 'Section des actualités mises en avant sur la page d\'accueil',
                'parent_id' => $pageAccueilCategory->id
            ],
            [
                'name' => 'Portraits d\'entrepreneurs',
                'slug' => 'portraits-entrepreneurs-accueil',
                'description' => 'Articles de portraits d\'entrepreneurs pour la section dédiée de la page d\'accueil',
                'parent_id' => $pageAccueilCategory->id
            ],
            [
                'name' => 'Magazines',
                'slug' => 'magazines-accueil',
                'description' => 'Articles liés aux magazines pour la section dédiée de la page d\'accueil',
                'parent_id' => $pageAccueilCategory->id
            ]
        ];

        foreach ($sousCategories as $index => $sousCat) {
            Category::create([
                'name' => $sousCat['name'],
                'slug' => $sousCat['slug'],
                'description' => $sousCat['description'],
                'status' => 'active',
                'is_active' => true,
                'user_id' => $user->id,
                'parent_id' => $sousCat['parent_id'],
                'sort_order' => $index + 1
            ]);
        }

        $this->command->info('Catégorie "Page accueil" et ses sous-catégories créées avec succès !');
    }
}