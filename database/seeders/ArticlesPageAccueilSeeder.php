<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticlesPageAccueilSeeder extends Seeder
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

        // Récupérer les catégories
        $top3Category = Category::where('slug', 'top-3-actualite-du-jour')->first();
        $actualitesUneCategory = Category::where('slug', 'actualites-a-la-une')->first();

        if (!$top3Category || !$actualitesUneCategory) {
            $this->command->error('Catégories "Top 3 Actualité du jour" ou "Actualités à la une" introuvables.');
            return;
        }

        // Articles pour Top 3 Actualité du jour
        $top3Articles = [
            [
                'title' => 'L\'économie ivoirienne enregistre une croissance de 7,4% au premier trimestre 2024',
                'excerpt' => 'Les secteurs de l\'agriculture et des services tirent la croissance économique de la Côte d\'Ivoire vers des sommets inédits.',
                'content' => '<p>La Côte d\'Ivoire affiche une performance économique remarquable avec une croissance de 7,4% au premier trimestre 2024. Cette progression s\'appuie principalement sur les secteurs agricole et tertiaire.</p><p>Le secteur agricole, pilier de l\'économie ivoirienne, bénéficie de conditions climatiques favorables et d\'investissements massifs dans la mécanisation. La production de cacao, première source d\'exportation du pays, atteint des niveaux records.</p><p>Parallèlement, le secteur des services connaît une expansion soutenue, portée par le développement des technologies numériques et l\'amélioration des infrastructures télécoms.</p>',
                'category_id' => $top3Category->id,
                'featured_image_url' => 'https://images.unsplash.com/photo-1560472355-536de3962603?w=800&h=600&fit=crop'
            ],
            [
                'title' => 'Lancement du programme "Côte d\'Ivoire Numérique 2030" : 500 milliards FCFA d\'investissement',
                'excerpt' => 'Le gouvernement dévoile son ambitieux plan de transformation digitale avec des investissements massifs dans les infrastructures numériques.',
                'content' => '<p>Le Premier Ministre a officiellement lancé le programme "Côte d\'Ivoire Numérique 2030", une initiative ambitieuse dotée d\'un budget de 500 milliards de FCFA sur six ans.</p><p>Ce programme vise à faire de la Côte d\'Ivoire un hub technologique régional en développant les infrastructures de télécommunications, en formant 100 000 jeunes aux métiers du numérique et en digitalisant les services publics.</p><p>Les partenaires internationaux, notamment la Banque mondiale et l\'Union européenne, apportent leur soutien financier et technique à cette transformation.</p>',
                'category_id' => $top3Category->id
            ],
            [
                'title' => 'Le Port autonome d\'Abidjan devient le premier port vert d\'Afrique de l\'Ouest',
                'excerpt' => 'Une certification internationale récompense les efforts environnementaux du port ivoirien, renforçant sa position de leader régional.',
                'content' => '<p>Le Port autonome d\'Abidjan (PAA) vient de recevoir la certification "EcoPorts" de l\'European Sea Ports Organisation, devenant ainsi le premier port certifié vert d\'Afrique de l\'Ouest.</p><p>Cette distinction récompense les investissements considérables dans les technologies propres : systèmes de traitement des eaux, énergies renouvelables et réduction des émissions de CO2.</p><p>Avec un trafic de plus de 25 millions de tonnes par an, le PAA s\'impose comme un modèle de développement durable pour les infrastructures portuaires africaines.</p>',
                'category_id' => $top3Category->id
            ]
        ];

        // Articles pour Actualités à la une
        $actualitesUneArticles = [
            [
                'title' => 'Inauguration de la plus grande centrale solaire d\'Afrique de l\'Ouest à Bondoukou',
                'excerpt' => 'La centrale solaire de Bondoukou, d\'une capacité de 37,5 MW, marque un tournant dans la stratégie énergétique ivoirienne.',
                'content' => '<p>La Côte d\'Ivoire franchit une étape majeure dans sa transition énergétique avec l\'inauguration de la centrale solaire de Bondoukou, la plus importante d\'Afrique de l\'Ouest.</p><p>Cette infrastructure de 37,5 MW permettra d\'alimenter en électricité propre plus de 100 000 foyers et de réduire les émissions de CO2 de 45 000 tonnes par an.</p>',
                'category_id' => $actualitesUneCategory->id
            ],
            [
                'title' => 'La Côte d\'Ivoire signe un partenariat stratégique avec la Chine pour le développement industriel',
                'excerpt' => 'Un accord de coopération de 2 milliards USD vise à renforcer les capacités industrielles ivoiriennes.',
                'content' => '<p>Un mémorandum d\'entente historique a été signé entre la Côte d\'Ivoire et la République populaire de Chine, portant sur un investissement de 2 milliards USD dans l\'industrialisation.</p><p>Ce partenariat couvrira la transformation agroalimentaire, les infrastructures et le transfert de technologies.</p>',
                'category_id' => $actualitesUneCategory->id
            ],
            [
                'title' => 'Record d\'exportation pour le cacao ivoirien : 2,2 millions de tonnes en 2023-2024',
                'excerpt' => 'La filière cacao ivoirienne bat tous les records avec une production exceptionnelle soutenue par les réformes structurelles.',
                'content' => '<p>La Côte d\'Ivoire consolide sa position de leader mondial du cacao avec un record d\'exportation de 2,2 millions de tonnes pour la campagne 2023-2024.</p><p>Cette performance résulte des investissements dans la modernisation des plantations et l\'amélioration des techniques de production.</p>',
                'category_id' => $actualitesUneCategory->id
            ],
            [
                'title' => 'Lancement du métro d\'Abidjan : première ligne opérationnelle en 2026',
                'excerpt' => 'Le projet de métro de la capitale économique entre dans sa phase de construction avec un budget de 1,5 milliard EUR.',
                'content' => '<p>Les travaux de construction de la première ligne de métro d\'Abidjan ont officiellement débuté, marquant une révolution dans le transport urbain ivoirien.</p><p>Cette ligne de 37 kilomètres reliera Anyama à Plateau en passant par les principaux quartiers de la métropole.</p>',
                'category_id' => $actualitesUneCategory->id
            ],
            [
                'title' => 'La startup ivoirienne MoMo remporte le prix de l\'innovation fintech africaine',
                'excerpt' => 'Une solution de paiement mobile 100% ivoirienne se distingue sur la scène continentale des technologies financières.',
                'content' => '<p>La startup abidjanaise MoMo a remporté le prestigieux African Fintech Innovation Award 2024 lors du sommet de Lagos.</p><p>Leur solution de paiement mobile révolutionnaire compte déjà plus d\'un million d\'utilisateurs en Afrique de l\'Ouest.</p>',
                'category_id' => $actualitesUneCategory->id
            ],
            [
                'title' => 'Ouverture de l\'Université internationale de technologie d\'Abidjan',
                'excerpt' => 'Un nouveau pôle d\'excellence académique voit le jour pour former les ingénieurs et technologues de demain.',
                'content' => '<p>L\'Université internationale de technologie d\'Abidjan (UITA) accueille ses premiers étudiants dans des formations de pointe en intelligence artificielle, cybersécurité et énergies renouvelables.</p><p>Cette institution privée, soutenue par des partenaires internationaux, vise l\'excellence académique et la recherche appliquée.</p>',
                'category_id' => $actualitesUneCategory->id
            ],
            [
                'title' => 'La Côte d\'Ivoire devient membre observateur de l\'Organisation de coopération de Shanghai',
                'excerpt' => 'Une reconnaissance diplomatique majeure qui ouvre de nouvelles perspectives de coopération économique et politique.',
                'content' => '<p>La Côte d\'Ivoire a obtenu le statut de membre observateur de l\'Organisation de coopération de Shanghai (OCS), renforçant ses liens avec l\'Asie centrale et orientale.</p><p>Cette adhésion ouvre des opportunités dans les domaines du commerce, de l\'énergie et de la sécurité régionale.</p>',
                'category_id' => $actualitesUneCategory->id
            ],
            [
                'title' => 'Festival MASA 2024 : Abidjan accueille les arts de la scène africaine',
                'excerpt' => 'La 11ème édition du Marché des arts du spectacle africains rassemble 500 artistes de 40 pays africains.',
                'content' => '<p>Abidjan vibre au rythme du MASA 2024, le plus grand rendez-vous des arts de la scène en Afrique. Plus de 500 artistes de 40 pays présentent leurs créations dans 15 lieux culturels de la métropole.</p><p>Cet événement biennal confirme le rayonnement culturel de la Côte d\'Ivoire sur le continent.</p>',
                'category_id' => $actualitesUneCategory->id
            ]
        ];

        // Créer les articles Top 3
        $this->command->info('Création des articles "Top 3 Actualité du jour"...');
        foreach ($top3Articles as $index => $articleData) {
            $slug = Str::slug($articleData['title']);

            // Vérifier si l'article existe déjà
            $existingArticle = Article::where('slug', $slug)->first();

            if (!$existingArticle) {
                Article::create([
                    'title' => $articleData['title'],
                    'slug' => $slug,
                    'excerpt' => $articleData['excerpt'],
                    'content' => $articleData['content'],
                    'category_id' => $articleData['category_id'],
                    'user_id' => $user->id,
                    'author_id' => $user->id,
                    'status' => 'published',
                    'published_at' => now()->subDays($index),
                    'created_at' => now()->subDays($index),
                    'updated_at' => now()->subDays($index),
                ]);

                $this->command->info("Article créé : {$articleData['title']}");
            } else {
                $this->command->info("Article existe déjà : {$articleData['title']}");
            }
        }

        // Créer les articles Actualités à la une
        $this->command->info('Création des articles "Actualités à la une"...');
        foreach ($actualitesUneArticles as $index => $articleData) {
            $slug = Str::slug($articleData['title']);

            // Vérifier si l'article existe déjà
            $existingArticle = Article::where('slug', $slug)->first();

            if (!$existingArticle) {
                Article::create([
                    'title' => $articleData['title'],
                    'slug' => $slug,
                    'excerpt' => $articleData['excerpt'],
                    'content' => $articleData['content'],
                    'category_id' => $articleData['category_id'],
                    'user_id' => $user->id,
                    'author_id' => $user->id,
                    'status' => 'published',
                    'published_at' => now()->subHours($index * 3), // Étaler dans le temps
                    'created_at' => now()->subHours($index * 3),
                    'updated_at' => now()->subHours($index * 3),
                ]);

                $this->command->info("Article créé : {$articleData['title']}");
            } else {
                $this->command->info("Article existe déjà : {$articleData['title']}");
            }
        }

        $this->command->info('Articles de démonstration créés avec succès !');
        $this->command->info('Total : ' . count($top3Articles) . ' articles "Top 3" + ' . count($actualitesUneArticles) . ' articles "Actualités à la une"');
    }
}