<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use App\Models\User;

class AssignerArticlesExistants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:assigner-auteurs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assigner les articles existants sans auteur à l\'administrateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Attribution des articles existants...');
        
        // Récupérer l'admin
        $admin = User::where('email', 'admin@excellenceafrik.com')->first();
        
        if (!$admin) {
            $this->error('Aucun administrateur trouvé avec l\'email admin@excellenceafrik.com');
            return 1;
        }
        
        // Compter les articles sans auteur
        $articlesOuvert = Article::whereNull('user_id')->count();
        $this->info("Articles sans auteur trouvés : {$articlesOuvert}");
        
        if ($articlesOuvert > 0) {
            // Assigner tous les articles sans auteur à l'admin
            $updated = Article::whereNull('user_id')->update(['user_id' => $admin->id]);
            $this->info("✅ {$updated} articles attribués à {$admin->name}");
        } else {
            $this->info('✅ Tous les articles ont déjà un auteur');
        }
        
        // Créer un article de test pour la journaliste si aucun article n'existe
        $journaliste = User::where('role_utilisateur', 'journaliste')->first();
        if ($journaliste) {
            $articleJournaliste = Article::where('user_id', $journaliste->id)->count();
            if ($articleJournaliste == 0) {
                $categories = \App\Models\Category::first();
                if ($categories) {
                    Article::create([
                        'title' => 'Mon premier article - Test Journaliste',
                        'slug' => 'mon-premier-article-test-journaliste',
                        'excerpt' => 'Article de démonstration créé par ' . $journaliste->name,
                        'content' => '<p>Ceci est un article de test pour démontrer le système de rôles.</p><p>Créé par : ' . $journaliste->name . '</p>',
                        'user_id' => $journaliste->id,
                        'author_id' => $journaliste->id, // Ajouter author_id aussi
                        'category_id' => $categories->id,
                        'status' => 'published'
                    ]);
                    $this->info("✅ Article de test créé pour {$journaliste->name}");
                }
            }
        }
        
        $this->info('🎉 Attribution terminée !');
        return 0;
    }
}
