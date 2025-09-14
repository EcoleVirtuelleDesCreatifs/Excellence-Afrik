<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class AjouterNouvellesSousCategoriesSeeder extends Seeder
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

        // Récupérer la catégorie parent "Page accueil"
        $pageAccueilCategory = Category::where('slug', 'page-accueil')
            ->orWhere('name', 'Page accueil')
            ->first();

        if (!$pageAccueilCategory) {
            $this->command->error('Catégorie "Page accueil" introuvable. Veuillez exécuter PageAccueilCategorySeeder d\'abord.');
            return;
        }

        // Nouvelles sous-catégories à ajouter
        $nouvellesSousCategories = [
            [
                'name' => 'Portraits d\'entrepreneurs',
                'slug' => 'portraits-entrepreneurs-accueil',
                'description' => 'Articles de portraits d\'entrepreneurs pour la section dédiée de la page d\'accueil',
                'parent_id' => $pageAccueilCategory->id
            ]
            // Note: "Magazines" supprimé car géré depuis la section Magazine du dashboard
        ];

        foreach ($nouvellesSousCategories as $index => $sousCat) {
            // Vérifier si la sous-catégorie existe déjà
            $existingCategory = Category::where('slug', $sousCat['slug'])
                ->orWhere('name', $sousCat['name'])
                ->first();

            if (!$existingCategory) {
                Category::create([
                    'name' => $sousCat['name'],
                    'slug' => $sousCat['slug'],
                    'description' => $sousCat['description'],
                    'status' => 'active',
                    'is_active' => true,
                    'user_id' => $user->id,
                    'parent_id' => $sousCat['parent_id'],
                    'sort_order' => 10 + $index // Commencer après les catégories existantes
                ]);

                $this->command->info("Sous-catégorie '{$sousCat['name']}' créée avec succès !");
            } else {
                $this->command->info("Sous-catégorie '{$sousCat['name']}' existe déjà.");
            }
        }

        $this->command->info('Nouvelles sous-catégories ajoutées avec succès !');
    }
}