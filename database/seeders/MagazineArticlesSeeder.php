<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MagazineArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer un utilisateur pour associer aux articles
        $user = User::first();
        if (!$user) {
            $this->command->error('Aucun utilisateur trouvé. Veuillez créer un utilisateur d\'abord.');
            return;
        }

        // Récupérer la catégorie "Magazines" de la page accueil
        $magazinesCategory = Category::where('slug', 'magazines-accueil')->first();

        if (!$magazinesCategory) {
            $this->command->error('Catégorie "Magazines" (Page accueil) introuvable.');
            return;
        }

        // Articles magazines avec images
        $magazineArticles = [
            [
                'title' => 'Excellence Afrik Magazine N°12 - L\'entrepreneuriat féminin en Côte d\'Ivoire',
                'excerpt' => 'Découvrez les portraits inspirants de 15 femmes entrepreneures qui transforment l\'économie ivoirienne.',
                'content' => '<p>Ce numéro spécial met à l\'honneur les femmes qui révolutionnent le paysage entrepreneurial ivoirien. De la fintech à l\'agrobusiness, elles redéfinissent les codes du succès.</p><p>Retrouvez des interviews exclusives, des analyses de marché et des conseils pratiques pour développer votre entreprise.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop',
                'category_id' => $magazinesCategory->id
            ],
            [
                'title' => 'Excellence Afrik Magazine N°11 - Innovation et technologie en Afrique',
                'excerpt' => 'Les startups africaines qui révolutionnent les secteurs traditionnels : fintech, agritech, edtech.',
                'content' => '<p>Un panorama complet des innovations technologiques qui transforment le continent africain. Des solutions locales aux ambitions globales.</p><p>Analyse approfondie des écosystèmes startup d\'Abidjan, Lagos, Nairobi et Le Cap avec nos correspondants sur le terrain.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=600&fit=crop',
                'category_id' => $magazinesCategory->id
            ],
            [
                'title' => 'Excellence Afrik Magazine N°10 - Développement durable et économie verte',
                'excerpt' => 'Comment l\'Afrique de l\'Ouest devient un laboratoire d\'innovation pour l\'économie circulaire.',
                'content' => '<p>De la gestion des déchets aux énergies renouvelables, découvrez les initiatives qui placent la région à l\'avant-garde du développement durable.</p><p>Reportages exclusifs sur les projets solaires, éoliens et les innovations en matière de recyclage.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?w=800&h=600&fit=crop',
                'category_id' => $magazinesCategory->id
            ],
            [
                'title' => 'Excellence Afrik Magazine N°9 - Le boom de l\'agriculture moderne',
                'excerpt' => 'Transformation digitale et mécanisation : la révolution agricole ivoirienne en marche.',
                'content' => '<p>Plongée au cœur de l\'agribusiness ivoirien avec les nouvelles technologies qui optimisent les rendements et améliorent la qualité.</p><p>Focus sur les coopératives innovantes, les techniques de transformation et les circuits de distribution modernisés.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&h=600&fit=crop',
                'category_id' => $magazinesCategory->id
            ]
        ];

        $this->command->info('Création des articles magazines...');

        foreach ($magazineArticles as $index => $articleData) {
            $slug = Str::slug($articleData['title']);

            // Vérifier si l'article existe déjà
            $existingArticle = Article::where('slug', $slug)->first();

            if (!$existingArticle) {
                Article::create([
                    'title' => $articleData['title'],
                    'slug' => $slug,
                    'excerpt' => $articleData['excerpt'],
                    'content' => $articleData['content'],
                    'featured_image_url' => $articleData['featured_image_url'],
                    'featured_image_alt' => 'Couverture : ' . $articleData['title'],
                    'category_id' => $articleData['category_id'],
                    'user_id' => $user->id,
                    'author_id' => $user->id,
                    'status' => 'published',
                    'published_at' => now()->subDays($index),
                    'created_at' => now()->subDays($index),
                    'updated_at' => now()->subDays($index),
                ]);

                $this->command->info("Article magazine créé : {$articleData['title']}");
            } else {
                $this->command->info("Article existe déjà : {$articleData['title']}");
            }
        }

        $this->command->info('Articles magazines créés avec succès !');
    }
}