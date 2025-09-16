<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

//======================================================================
// PUBLIC ROUTES
//======================================================================

Route::get('/', function () {
    // ... (Your existing homepage logic) ...
    $dailyNewsSlugEnv = env('DAILY_NEWS_CATEGORY_SLUG');
    $dailyNewsIdEnv   = env('DAILY_NEWS_CATEGORY_ID');
    $figuresSlugEnv   = env('FIGURES_CATEGORY_SLUG');
    $figuresIdEnv     = env('FIGURES_CATEGORY_ID');
    $dailyQuery = \App\Models\Category::where('status', 'active')->where('is_active', 1);
    if ($dailyNewsIdEnv) {
        $dailyQuery->where('id', $dailyNewsIdEnv);
    } elseif ($dailyNewsSlugEnv) {
        $dailyQuery->where('slug', $dailyNewsSlugEnv);
    } else {
        $dailyQuery->where(function($q) {
            $q->where('slug', 'top-3-actualite-du-jour')
              ->orWhere('name', 'Top 3 Actualité du jour');
        });
    }
    $dailyNewsCategory = $dailyQuery->first();
    $dailyNews = collect();
    if ($dailyNewsCategory) {
        $dailyNews = \App\Models\Article::with(['category', 'user'])
            ->where('category_id', $dailyNewsCategory->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
    }
    $figuresQuery = \App\Models\Category::where('status', 'active')->where('is_active', 1);
    if ($figuresIdEnv) {
        $figuresQuery->where('id', $figuresIdEnv);
    } elseif ($figuresSlugEnv) {
        $figuresQuery->where('slug', $figuresSlugEnv);
    } else {
        $figuresQuery->where(function($q) {
            $q->whereIn('slug', ['figures-de-leconomie', 'figures-de-l-economie'])
              ->orWhere('name', "Figures de l'Economie");
        });
    }
    $figuresCategory = $figuresQuery->first();
    $figuresArticles = collect();
    if ($figuresCategory) {
        $figuresArticles = \App\Models\Article::with(['category', 'user'])
            ->where('category_id', $figuresCategory->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
    }
    $featuredWebtv = \App\Models\Webtv::query()
        ->where('est_actif', true)
        ->whereIn('statut', ['en_direct', 'programme', 'termine'])
        ->orderByRaw("CASE statut WHEN 'en_direct' THEN 0 WHEN 'programme' THEN 1 ELSE 2 END")
        ->orderByRaw('CASE WHEN date_programmee IS NULL THEN 1 ELSE 0 END')
        ->orderByDesc('date_programmee')
        ->orderByDesc('created_at')
        ->first();
    $prochainLive = null;
    if (!$featuredWebtv || $featuredWebtv->statut !== 'en_direct') {
        $prochainLive = \App\Models\Webtv::query()
            ->where('est_actif', true)
            ->where('statut', 'programme')
            ->whereNotNull('date_programmee')
            ->where('date_programmee', '>', now())
            ->orderBy('date_programmee')
            ->first();
    }



    $portraitsAccueilCategory = \App\Models\Category::where('status', 'active')
        ->where('is_active', 1)
        ->where('slug', 'portraits-entrepreneurs-accueil')
        ->first();
    $entrepreneurArticles = collect();
    if ($portraitsAccueilCategory) {
        $entrepreneurArticles = \App\Models\Article::with(['category', 'user'])
            ->where('category_id', $portraitsAccueilCategory->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(7)
            ->get();
    }
    if ($entrepreneurArticles->isEmpty()) {
        $oldEntrepreneurCategory = \App\Models\Category::where('status', 'active')
            ->where('is_active', 1)
            ->whereIn('slug', ['portrait-de-l-entrepreneur', 'portrait-de-lentrepreneur'])
            ->orWhere('name', "Portrait de l'entrepreneur")
            ->first();
        if ($oldEntrepreneurCategory) {
            $entrepreneurArticles = \App\Models\Article::with(['category', 'user'])
                ->where('category_id', $oldEntrepreneurCategory->id)
                ->where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->limit(7)
                ->get();
        }
    }
    $latestMagazines = \App\Models\Magazine::where('status', 'published')
        ->orderBy('created_at', 'desc')
        ->limit(4)
        ->get();
    $flashInfos = \App\Models\FlashInfo::affichage()->limit(10)->get();
    // Fetch articles for the new unified "À LA UNE" section
    $homepageAlaUneArticles = collect();
    $actualiteDuJourCategory = \App\Models\Category::where('slug', 'actualite-du-jour')->first();
    if ($actualiteDuJourCategory) {
        $homepageAlaUneArticles = \App\Models\Article::with(['category', 'user'])
            ->where('category_id', $actualiteDuJourCategory->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(15) // Fetch 15 articles for the new 3+12 layout
            ->get();
    }
    $bottomBannerAd = \App\Models\Advertisement::active()->forPosition('home', null, 'bottom_banner')->first();
    return view('home', compact('dailyNews', 'figuresArticles', 'featuredWebtv', 'prochainLive', 'flashInfos', 'entrepreneurArticles', 'latestMagazines', 'homepageAlaUneArticles', 'bottomBannerAd'));
})->name('home');

// Public static pages
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/presentation', function () { return view('pages.presentation'); })->name('presentation');
    Route::get('/equipe', function () { return view('pages.equipe'); })->name('equipe');
    Route::get('/editorial', function () { return view('pages.editorial'); })->name('editorial');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [PageController::class, 'sendContactForm'])->name('contact.send');
    Route::get('/advertise', function () { return view('pages.advertise'); })->name('advertise');
    Route::get('/sponsor', function () { return view('pages.sponsor'); })->name('sponsor');
    Route::get('/awards', function () { return view('pages.awards'); })->name('awards');
    Route::get('/legal', function () { return view('pages.legal'); })->name('legal');
    Route::get('/privacy', function () { return view('pages.privacy'); })->name('privacy');
    Route::get('/terms', function () { return view('pages.terms'); })->name('terms');
});

// Articles routes
Route::prefix('articles')->name('articles.')->group(function () {
    Route::get('/', function () {
        $articles = \App\Models\Article::with(['category', 'user'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        $categories = \App\Models\Category::where('status', 'active')
            ->withCount('articles')
            ->orderBy('name')
            ->get();
        
        return view('articles.index', compact('articles', 'categories')); 
    })->name('index');
    
    Route::get('/category/{slug}', function ($slug) {
        $category = \App\Models\Category::where('slug', $slug)->first();

        // Robust resolution for "Figures de l'économie" page
        if (!$category && in_array($slug, ['figures-economie', 'figures-de-leconomie', 'figures-de-l-economie'])) {
            $category = \App\Models\Category::whereIn('slug', ['figures-economie', 'figures-de-leconomie', 'figures-de-l-economie'])
                ->where('status', 'active')
                ->first();
        }

        // Robust resolution for "Portrait de l'entrepreneur" page
        if (!$category && in_array($slug, ['portrait-de-l-entreprise', 'portrait-de-l-entrepreneur', 'portrait-d-entrepreneur'])) {
            $category = \App\Models\Category::whereIn('slug', ['portrait-de-l-entreprise', 'portrait-de-l-entrepreneur', 'portrait-d-entrepreneur'])
                ->where('status', 'active')
                ->first();
        }

        // Robust resolution for "Actualités à la une" page
        if (!$category && in_array($slug, ['actualites-a-la-une', 'actualite-a-la-une'])) {
            // Find the category by name first to get the correct, current slug
            $actualitesCategory = \App\Models\Category::where('name', 'Actualités à la une')->first();
            
            if ($actualitesCategory) {
                // Now, find the category using its actual slug from the database
                $category = \App\Models\Category::where('slug', $actualitesCategory->slug)->first();
            } else {
                // Fallback: If the name doesn't match, try finding a category that contains 'Actualit' in its name
                $category = \App\Models\Category::where('name', 'LIKE', '%Actualit%')->where('status', 'active')->first();
            }
        }

        // Robust resolution for "Startup de la diaspora" page
        if (!$category && in_array($slug, ['startup-de-la-diaspora', 'start-up-de-la-diaspora'])) {
            $category = \App\Models\Category::whereIn('slug', ['startup-de-la-diaspora', 'start-up-de-la-diaspora'])
                ->where('status', 'active')
                ->first();
        }

        // Robust resolution for "Parole d'experts" page
        if (!$category && in_array($slug, ['parole-experts', 'parole-d-experts', 'paroles-d-experts'])) {
            $slugVariants = ['parole-experts', 'parole-d-experts', 'paroles-d-experts'];
            $nameVariants = ["Parole d'experts", "Parole D'Experts", "Paroles d'experts"];

            // First, try to find the category with an 'active' status.
            $category = \App\Models\Category::where(function ($query) use ($slugVariants, $nameVariants) {
                $query->whereIn('slug', $slugVariants)
                      ->orWhereIn('name', $nameVariants);
            })
            ->where('status', 'active')
            ->first();

            // If it's still not found, try again without the status constraint as a fallback.
            if (!$category) {
                $category = \App\Models\Category::where(function ($query) use ($slugVariants, $nameVariants) {
                    $query->whereIn('slug', $slugVariants)
                          ->orWhereIn('name', $nameVariants);
                })
                ->first();
            }
        }
        if (!$category) {
            abort(404, 'Catégorie non trouvée');
        }
        
        $query = \App\Models\Article::with(['category', 'user'])
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc');

        $articles = $query->paginate(12)->appends(request()->query());
            
        $relatedCategories = \App\Models\Category::where('status', 'active')
            ->where('id', '!=', $category->id)
            ->withCount('articles')
            ->limit(8)
            ->get();

        return view('articles.category', compact('category', 'articles', 'relatedCategories', 'slug')); 
    })->name('category');
    
    Route::get('/{slug}', function ($slug) {
        $article = \App\Models\Article::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
            
        $article->increment('view_count');
        
        $relatedArticles = \App\Models\Article::with(['category', 'user'])
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $sidebarCategories = collect();
        if ($article->category && $article->category->parent) {
            $sidebarCategories = \App\Models\Category::where('parent_id', $article->category->parent_id)
                ->where('id', '!=', $article->category_id)
                ->where('status', 'active')
                ->where('is_active', 1)
                ->with(['articles' => function ($query) {
                    $query->where('status', 'published')
                          ->orderBy('created_at', 'desc')
                          ->limit(10);
                }])
                ->get();
        }

        return view('articles.show', compact('article', 'relatedArticles', 'sidebarCategories')); 
    })->name('show');
    
    Route::get('/search', function () { 
        return view('articles.search'); 
    })->name('search');
});

// Magazines routes
Route::prefix('magazines')->name('magazines.')->group(function () {
    Route::get('/', [App\Http\Controllers\MagazineController::class, 'publicIndex'])->name('index');
    Route::get('/{slug}', [App\Http\Controllers\MagazineController::class, 'publicShow'])->name('show');
    Route::get('/{id}/download', function ($id) {
        // Here you would implement PDF download logic
        return redirect()->back()->with('info', 'Téléchargement du PDF N° ' . $id);
    })->name('download')->where('id', '[0-9]+');
    Route::get('/archive', function () { 
        return view('magazines.archive'); 
    })->name('archive');
    Route::get('/subscribe', function () { 
        return view('magazines.subscribe'); 
    })->name('subscribe');
    Route::get('/newsletter/subscribe', function () {
        return view('newsletter.subscribe');
    })->name('newsletter.subscribe');
});

// Dashboard Routes (Protected avec vérification des rôles)
Route::middleware(['auth', 'verifier.role'])->group(function () {
    
    // === ACCÈS POUR TOUS LES UTILISATEURS AUTHENTIFIÉS ===
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // === GESTION DES ARTICLES - Tous peuvent créer et éditer ===
    Route::get('/dashboard/articles', [App\Http\Controllers\DashboardController::class, 'articles'])->name('dashboard.articles');
    Route::get('/dashboard/mes-articles', [App\Http\Controllers\DashboardController::class, 'mesArticles'])->name('dashboard.mes-articles');
    Route::get('/dashboard/articles/create', [App\Http\Controllers\DashboardController::class, 'createArticle'])->name('dashboard.articles.create');
    Route::post('/dashboard/articles', [App\Http\Controllers\DashboardController::class, 'storeArticle'])->name('dashboard.articles.store');
    Route::get('/dashboard/articles/{id}/edit', [App\Http\Controllers\DashboardController::class, 'editArticle'])->name('dashboard.articles.edit');
    Route::put('/dashboard/articles/{id}', [App\Http\Controllers\DashboardController::class, 'updateArticle'])->name('dashboard.articles.update');
    
    // === SUPPRESSION ARTICLES - Permissions gérées dans le contrôleur ===
    Route::delete('/dashboard/articles/{id}', [App\Http\Controllers\DashboardController::class, 'deleteArticle'])
         ->name('dashboard.articles.delete');
    
    // === APPROBATION ARTICLES - Seulement directeur et admin ===
    Route::post('/dashboard/articles/{id}/approve', [App\Http\Controllers\DashboardController::class, 'approveArticle'])
         ->name('dashboard.articles.approve')
         ->middleware('verifier.role:admin|directeur_publication');
    
    // === REJET ARTICLES - Seulement directeur et admin ===
    Route::post('/dashboard/articles/{id}/reject', [App\Http\Controllers\DashboardController::class, 'rejectArticle'])
         ->name('dashboard.articles.reject')
         ->middleware('verifier.role:admin|directeur_publication');
    
    // === ACTIONS GROUPÉES SUR ARTICLES - Seulement directeur et admin pour publication ===
    Route::post('/dashboard/articles/bulk-action', [App\Http\Controllers\DashboardController::class, 'bulkAction'])
         ->name('dashboard.articles.bulk-action');
    
    // Routes pour les articles "À la une"
    Route::resource('/dashboard/a-la-une', App\Http\Controllers\Dashboard\ALaUneArticleController::class)->names('dashboard.a_la_une');
    
    // === GESTION CATÉGORIES - Lecture pour tous, modification pour admin/directeur ===
    Route::get('/dashboard/categories', [App\Http\Controllers\DashboardController::class, 'categories'])->name('dashboard.categories.index');
    
    // === GESTION DU PROFIL - Accessible à tous les utilisateurs authentifiés ===
    Route::get('/dashboard/profile', [App\Http\Controllers\DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [App\Http\Controllers\DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
});

// === ROUTES RÉSERVÉES ADMIN ET DIRECTEUR DE PUBLICATION ===
Route::middleware(['auth', 'verifier.role:admin|directeur_publication'])->group(function () {
    // Gestion complète des catégories
    Route::get('/dashboard/categories/create', [App\Http\Controllers\DashboardController::class, 'createCategory'])->name('dashboard.categories.create');
    Route::post('/dashboard/categories', [App\Http\Controllers\DashboardController::class, 'storeCategory'])->name('dashboard.categories.store');
    Route::get('/dashboard/categories/{id}/edit', [App\Http\Controllers\DashboardController::class, 'editCategory'])->name('dashboard.categories.edit');
    Route::put('/dashboard/categories/{id}', [App\Http\Controllers\DashboardController::class, 'updateCategory'])->name('dashboard.categories.update');
    Route::delete('/dashboard/categories/{id}', [App\Http\Controllers\DashboardController::class, 'deleteCategory'])->name('dashboard.categories.delete');
    
    // Gestion complète des magazines
    Route::prefix('dashboard/magazines')->name('dashboard.magazines.')->group(function () {
        Route::get('/', [App\Http\Controllers\MagazineController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\MagazineController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\MagazineController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [App\Http\Controllers\MagazineController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\MagazineController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\MagazineController::class, 'destroy'])->name('destroy');
    });

    // Gestion complète des publicités
    Route::prefix('dashboard/advertisements')->name('dashboard.advertisements.')->group(function () {
        Route::get('/', [App\Http\Controllers\AdvertisementController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\AdvertisementController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\AdvertisementController::class, 'store'])->name('store');
        Route::get('/{advertisement}', [App\Http\Controllers\AdvertisementController::class, 'show'])->name('show');
        Route::get('/{advertisement}/edit', [App\Http\Controllers\AdvertisementController::class, 'edit'])->name('edit');
        Route::put('/{advertisement}', [App\Http\Controllers\AdvertisementController::class, 'update'])->name('update');
        Route::delete('/{advertisement}', [App\Http\Controllers\AdvertisementController::class, 'destroy'])->name('destroy');
        Route::post('/{advertisement}/toggle-status', [App\Http\Controllers\AdvertisementController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/subcategories', [App\Http\Controllers\AdvertisementController::class, 'getSubcategories'])->name('subcategories');
    });

    // Gestion des utilisateurs
    Route::get('/dashboard/users', [App\Http\Controllers\DashboardController::class, 'users'])->name('dashboard.users');

    // Gestion des Flash Info
    Route::prefix('dashboard/flash-infos')->name('dashboard.flash-infos.')->group(function () {
        Route::get('/', [App\Http\Controllers\FlashInfoController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\FlashInfoController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\FlashInfoController::class, 'store'])->name('store');
        Route::get('/{flashInfo}/edit', [App\Http\Controllers\FlashInfoController::class, 'edit'])->name('edit');
        Route::put('/{flashInfo}', [App\Http\Controllers\FlashInfoController::class, 'update'])->name('update');
        Route::delete('/{flashInfo}', [App\Http\Controllers\FlashInfoController::class, 'destroy'])->name('destroy');
        Route::post('/{flashInfo}/toggle-actif', [App\Http\Controllers\FlashInfoController::class, 'toggleActif'])->name('toggle-actif');
    });

    // === GESTION DES NEWSLETTERS - Admin et Directeur uniquement ===
    Route::middleware('verifier.role:admin,directeur_publication')->group(function () {
        Route::get('/dashboard/newsletter', [App\Http\Controllers\NewsletterController::class, 'index'])->name('dashboard.newsletter.index');
        Route::get('/dashboard/newsletter/{id}', [App\Http\Controllers\NewsletterController::class, 'show'])->name('dashboard.newsletter.show');
        Route::post('/dashboard/newsletter', [App\Http\Controllers\NewsletterController::class, 'store'])->name('dashboard.newsletter.store');
        Route::put('/dashboard/newsletter/{id}', [App\Http\Controllers\NewsletterController::class, 'update'])->name('dashboard.newsletter.update');
        Route::post('/dashboard/newsletter/{id}', [App\Http\Controllers\NewsletterController::class, 'update'])->name('dashboard.newsletter.update.post');
        Route::delete('/dashboard/newsletter/{id}', [App\Http\Controllers\NewsletterController::class, 'destroy'])->name('dashboard.newsletter.destroy');
        Route::get('/dashboard/newsletter/export/csv', [App\Http\Controllers\NewsletterController::class, 'export'])->name('dashboard.newsletter.export');
    });
    
    // Gestion des contacts
    Route::prefix('dashboard/contacts')->name('dashboard.contacts.')->group(function () {
        Route::get('/', [App\Http\Controllers\ContactController::class, 'index'])->name('index');
        Route::get('/{contact}', [App\Http\Controllers\ContactController::class, 'show'])->name('show');
        Route::put('/{contact}', [App\Http\Controllers\ContactController::class, 'update'])->name('update');
        Route::delete('/{contact}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [App\Http\Controllers\ContactController::class, 'bulkAction'])->name('bulk-action');
        Route::get('/export/csv', [App\Http\Controllers\ContactController::class, 'export'])->name('export');
    });

// === ROUTES WEBTV - ACCESSIBLE À TOUS LES UTILISATEURS AUTHENTIFIÉS ===
Route::middleware(['auth', 'verifier.role'])->group(function () {
    Route::prefix('dashboard/webtv')->name('dashboard.webtv.')->group(function () {
        Route::get('/', [App\Http\Controllers\WebtvController::class, 'index'])->name('index');
        Route::get('/media/create', function() {
            return view('webtv.create-live');
        })->name('media.create');
        Route::get('/programs/create', function() {
            return view('webtv.create-program');
        })->name('programs.create');
        Route::post('/store', [App\Http\Controllers\WebtvController::class, 'store'])->name('store');
        Route::post('/preview-embed', [App\Http\Controllers\WebtvController::class, 'previewEmbed'])->name('preview-embed');
        Route::get('/{webtv}/edit', [App\Http\Controllers\WebtvController::class, 'edit'])->name('edit');
        Route::put('/{webtv}', [App\Http\Controllers\WebtvController::class, 'update'])->name('update');
        Route::delete('/{webtv}', [App\Http\Controllers\WebtvController::class, 'destroy'])->name('destroy');
        Route::post('/{webtv}/toggle-actif', [App\Http\Controllers\WebtvController::class, 'toggleActif'])->name('toggle-actif');
        Route::post('/{webtv}/changer-statut', [App\Http\Controllers\WebtvController::class, 'changerStatut'])->name('changer-statut');
    });
});

});

// === ROUTES RÉSERVÉES SUPER-ADMINISTRATEUR UNIQUEMENT ===
Route::middleware(['auth', 'verifier.role:admin'])->group(function () {
    // Paramètres système
    Route::get('/dashboard/settings', [App\Http\Controllers\DashboardController::class, 'settings'])->name('dashboard.settings');
    
    // Gestion des utilisateurs dans les paramètres
    Route::get('/dashboard/settings/users', [App\Http\Controllers\DashboardController::class, 'getUsers'])->name('dashboard.settings.users');
    Route::post('/dashboard/settings/users', [App\Http\Controllers\DashboardController::class, 'createUser'])->name('dashboard.settings.users.create');
    Route::get('/dashboard/settings/users/{id}', [App\Http\Controllers\DashboardController::class, 'getUser'])->name('dashboard.settings.users.show');
    Route::put('/dashboard/settings/users/{id}', [App\Http\Controllers\DashboardController::class, 'updateUser'])->name('dashboard.settings.users.update');
    Route::post('/dashboard/settings/users/{id}', [App\Http\Controllers\DashboardController::class, 'updateUser'])->name('dashboard.settings.users.update.post');
    Route::delete('/dashboard/settings/users/{id}', [App\Http\Controllers\DashboardController::class, 'deleteUser'])->name('dashboard.settings.users.delete');
    
    // === GESTION DES NEWSLETTERS - Admin et Directeur uniquement ===
    Route::middleware('verifier.role:admin,directeur_publication')->group(function () {
        Route::get('/dashboard/newsletter', [App\Http\Controllers\NewsletterController::class, 'index'])->name('dashboard.newsletter.index');
        Route::get('/dashboard/newsletter/{id}', [App\Http\Controllers\NewsletterController::class, 'show'])->name('dashboard.newsletter.show');
        Route::post('/dashboard/newsletter', [App\Http\Controllers\NewsletterController::class, 'store'])->name('dashboard.newsletter.store');
        Route::put('/dashboard/newsletter/{id}', [App\Http\Controllers\NewsletterController::class, 'update'])->name('dashboard.newsletter.update');
        Route::post('/dashboard/newsletter/{id}', [App\Http\Controllers\NewsletterController::class, 'update'])->name('dashboard.newsletter.update.post');
        Route::delete('/dashboard/newsletter/{id}', [App\Http\Controllers\NewsletterController::class, 'destroy'])->name('dashboard.newsletter.destroy');
        Route::get('/dashboard/newsletter/export/csv', [App\Http\Controllers\NewsletterController::class, 'export'])->name('dashboard.newsletter.export');
    });
    
    // Routes de test et développement
    Route::get('/dashboard/test', function() { return view('dashboard.test'); })->name('dashboard.test');
});

// Newsletter route
// Newsletter routes (public)
Route::post('/newsletter/subscribe', [App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
Route::get('/newsletter/verify/{token}', [App\Http\Controllers\NewsletterController::class, 'verify'])->name('newsletter.verify');

// Weather API route
Route::get('/api/weather', function () {
    $apiKey = 'f66a0e148241fe356827681a7ea53ad3';
    $city = 'Abidjan';
    $countryCode = 'CI';
    
    try {
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city},{$countryCode}&units=metric&lang=fr&appid={$apiKey}";
        
        $response = file_get_contents($url);
        if ($response === false) {
            throw new Exception('Failed to fetch weather data');
        }
        
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response');
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'temp' => round($data['main']['temp']),
                'description' => $data['weather'][0]['description'] ?? 'Inconnu',
                'city' => $data['name'] ?? 'Abidjan'
            ]
        ]);
        
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'fallback' => [
                'temp' => 29,
                'description' => 'API temporairement indisponible',
                'city' => 'Abidjan'
            ]
        ], 200);
    }
})->name('api.weather');

// BRVM API route
Route::get('/api/brvm', function () {
    try {
        // Indice BRVM10 - valeurs typiques entre 145-175
        $baseValue = 161.50;
        $variation = (rand(-200, 200) / 100); // Variation de -2% à +2%
        $currentValue = round($baseValue + $variation, 2);
        
        $changePercent = round(($variation / $baseValue) * 100, 2);
        $changePoints = round($variation, 2);
        
        // Formatage de la variation avec couleur
        $changeDisplay = ($changePercent >= 0 ? '+' : '') . $changePercent . '%';
        $changeClass = $changePercent >= 0 ? 'positive' : 'negative';
        
        // Simulation horaire de la bourse (ouverte 9h-15h UTC, soit 9h-15h Abidjan)
        $currentHour = (int)date('H');
        $isMarketOpen = $currentHour >= 9 && $currentHour < 15;
        
        return response()->json([
            'success' => true,
            'data' => [
                'index_name' => 'BRVM10',
                'value' => $currentValue,
                'change_percent' => $changePercent,
                'change_points' => $changePoints,
                'change_display' => $changeDisplay,
                'change_class' => $changeClass,
                'market_open' => $isMarketOpen,
                'last_update' => now()->format('H:i')
            ]
        ]);
        
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'fallback' => [
                'index_name' => 'BRVM10',
                'value' => 161.50,
                'change_percent' => 0.00,
                'change_display' => '0.00%',
                'change_class' => 'neutral',
                'market_open' => false,
                'last_update' => 'N/A'
            ]
        ], 200);
    }
})->name('api.brvm');

// Advertisement click tracking route (public)
Route::get('/ad/click/{id}', [App\Http\Controllers\AdvertisementController::class, 'click'])->name('advertisement.click');

// Advertisement impression tracking route (public)
Route::post('/ad/impression/{id}', [App\Http\Controllers\AdvertisementController::class, 'impression'])->name('advertisement.impression');

// WebTV routes
Route::prefix('webtv')->name('webtv.')->group(function () {
    Route::get('/', function () {
        $query = \App\Models\Webtv::query()
            ->where('est_actif', true)
            ->whereIn('statut', ['en_direct', 'programme', 'termine'])
            // Prioritize live first, then programme, then others
            ->orderByRaw("CASE statut WHEN 'en_direct' THEN 0 WHEN 'programme' THEN 1 ELSE 2 END")
            // Within same statut, show scheduled most recent first, nulls last
            ->orderByRaw('CASE WHEN date_programmee IS NULL THEN 1 ELSE 0 END')
            ->orderByDesc('date_programmee')
            ->orderByDesc('created_at');

        // Distinct categories (non vides)
        $allCategories = \App\Models\Webtv::where('est_actif', true)
            ->whereNotNull('categorie')
            ->where('categorie', '<>', '')
            ->pluck('categorie')
            ->unique()
            ->values();

        $current = request('category');
        if ($current) {
            $slug = \Illuminate\Support\Str::slug($current, '-');
            // Compare on a normalized version of categorie: lower + spaces/underscores -> '-'
            $query->whereRaw('LOWER(REPLACE(REPLACE(categorie, " ", "-"), "_", "-")) = ?', [strtolower($slug)]);
        }

        $webtvs = $query->paginate(12)->withQueryString();

        // Récupérer les programmes récents pour la section "Nos programmes"
        $recentPrograms = \App\Models\Webtv::query()
            ->where('est_actif', true)
            ->whereIn('statut', ['termine', 'programme', 'en_direct'])
            // S'assurer qu'il y a du contenu vidéo (code embed ou intégration)
            ->where(function($query) {
                $query->whereNotNull('code_embed_vimeo')
                      ->orWhereNotNull('code_integration_vimeo');
            })
            ->orderByDesc('created_at')
            ->limit(9) // Afficher 9 programmes récents
            ->get();

        // Récupérer aussi les données pour le live principal (comme sur l'accueil)
        $featuredWebtv = \App\Models\Webtv::query()
            ->where('est_actif', true)
            ->where('statut', 'en_direct')
            ->orderByDesc('date_programmee')
            ->orderByDesc('created_at')
            ->first();

        $prochainLive = null;
        if (!$featuredWebtv || $featuredWebtv->statut !== 'en_direct') {
            $prochainLive = \App\Models\Webtv::query()
                ->where('est_actif', true)
                ->where('statut', 'programme')
                ->whereNotNull('date_programmee')
                ->where('date_programmee', '>', now())
                ->orderBy('date_programmee')
                ->first();
        }

        return view('pages.webtv', [
            'webtvs' => $webtvs,
            'categories' => $allCategories,
            'currentCategory' => $current,
            'recentPrograms' => $recentPrograms,
            'featuredWebtv' => $featuredWebtv,
            'prochainLive' => $prochainLive,
        ]);
    })->name('index');

    Route::get('/{webtv}', function (\App\Models\Webtv $webtv) {
        // Vérifier que la WebTV est active
        if (!$webtv->est_actif) {
            abort(404);
        }

        // Récupérer d'autres programmes similaires (même catégorie)
        $programmesLies = \App\Models\Webtv::query()
            ->where('est_actif', true)
            ->where('id', '!=', $webtv->id)
            ->when($webtv->categorie, function($query) use ($webtv) {
                return $query->where('categorie', $webtv->categorie);
            })
            ->whereIn('statut', ['termine', 'programme'])
            ->limit(4)
            ->get();

        return view('pages.webtv-detail', compact('webtv', 'programmesLies')); 
    })->name('show');
});

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});
