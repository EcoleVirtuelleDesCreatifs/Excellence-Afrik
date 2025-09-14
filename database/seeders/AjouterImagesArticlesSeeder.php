<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AjouterImagesArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Images Unsplash avec des thèmes appropriés pour les articles économiques/actualités
        $imagesUrls = [
            // Économie et croissance
            'https://images.unsplash.com/photo-1560472355-536de3962603?w=800&h=600&fit=crop', // Économie
            'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=600&fit=crop', // Technologie
            'https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?w=800&h=600&fit=crop', // Port/Transport
            'https://images.unsplash.com/photo-1466611653911-95081537e5b7?w=800&h=600&fit=crop', // Énergie solaire
            'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=800&h=600&fit=crop', // Partenariat/Business
            'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&h=600&fit=crop', // Agriculture/Cacao
            'https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?w=800&h=600&fit=crop', // Infrastructure/Métro
            'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=600&fit=crop', // Fintech/Mobile
            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop', // Université/Éducation
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop', // Diplomatie
            'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop', // Arts/Culture
        ];

        // Récupérer tous les articles récemment créés (sans images)
        $articles = Article::whereNull('featured_image_url')
            ->whereNull('featured_image_path')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        if ($articles->isEmpty()) {
            $this->command->info('Aucun article sans image trouvé.');
            return;
        }

        $this->command->info("Ajout d'images à {$articles->count()} articles...");

        foreach ($articles as $index => $article) {
            // Utiliser une image différente pour chaque article
            $imageUrl = $imagesUrls[$index % count($imagesUrls)];

            $article->update([
                'featured_image_url' => $imageUrl,
                'featured_image_alt' => 'Image pour : ' . substr($article->title, 0, 50) . '...'
            ]);

            $this->command->info("Image ajoutée à l'article : " . Str::limit($article->title, 50));
        }

        $this->command->info('Images ajoutées avec succès à tous les articles !');
    }
}