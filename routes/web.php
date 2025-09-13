<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Permettre la configuration via .env pour refléter les changements sans dépendre des libellés
    $dailyNewsSlugEnv = env('DAILY_NEWS_CATEGORY_SLUG');
    $dailyNewsIdEnv   = env('DAILY_NEWS_CATEGORY_ID');
    $figuresSlugEnv   = env('FIGURES_CATEGORY_SLUG');
    $figuresIdEnv     = env('FIGURES_CATEGORY_ID');

    // Récupérer la catégorie "Actualité du jour"
    $dailyQuery = \App\Models\Category::where('status', 'active')->where('is_active', 1);
    if ($dailyNewsIdEnv) {
        $dailyQuery->where('id', $dailyNewsIdEnv);
    } elseif ($dailyNewsSlugEnv) {
        $dailyQuery->where('slug', $dailyNewsSlugEnv);
    } else {
        $dailyQuery->where(function($q) {
            $q->where('slug', 'actualite-du-jour')
              ->orWhere('name', 'Actualité du jour');
        });
    }
    $dailyNewsCategory = $dailyQuery->first();
    
    $dailyNews = collect();
    if ($dailyNewsCategory) {
        // Récupérer les articles de la catégorie "Actualité du jour"
        $dailyNews = \App\Models\Article::with(['category', 'user'])
            ->where('category_id', $dailyNewsCategory->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
    }
    
    // Récupérer la catégorie "Figures de l'Economie"
    $figuresQuery = \App\Models\Category::where('status', 'active')->where('is_active', 1);
    if ($figuresIdEnv) {
        $figuresQuery->where('id', $figuresIdEnv);
    } elseif ($figuresSlugEnv) {
        $figuresQuery->where('slug', $figuresSlugEnv);
    } else {
        $figuresQuery->where(function($q) {
            // Privilégier le slug (moins sujet aux changements de libellé)
            $q->whereIn('slug', ['figures-de-leconomie', 'figures-de-l-economie'])
              ->orWhere('name', "Figures de l'Economie");
        });
    }
    $figuresCategory = $figuresQuery->first();
    
    $figuresArticles = collect();
    if ($figuresCategory) {
        // Récupérer les articles de la catégorie "Figures de l'Economie"
        $figuresArticles = \App\Models\Article::with(['category', 'user'])
            ->where('category_id', $figuresCategory->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
    }
    
    // Featured WebTV for homepage (À la une)
    $featuredWebtv = \App\Models\Webtv::query()
        ->where('est_actif', true)
        ->whereIn('statut', ['en_direct', 'programme', 'termine'])
        ->orderByRaw("CASE statut WHEN 'en_direct' THEN 0 WHEN 'programme' THEN 1 ELSE 2 END")
        ->orderByRaw('CASE WHEN date_programmee IS NULL THEN 1 ELSE 0 END')
        ->orderByDesc('date_programmee')
        ->orderByDesc('created_at')
        ->first();

    return view('home', compact('dailyNews', 'figuresArticles', 'featuredWebtv'));
})->name('home');

// Pages routes
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/presentation', function () { return view('pages.presentation'); })->name('presentation');
    Route::get('/editorial', function () { return view('pages.editorial'); })->name('editorial');
    Route::get('/contact', function () { return view('pages.contact'); })->name('contact');
    Route::get('/advertise', function () { return view('pages.advertise'); })->name('advertise');
    Route::get('/sponsor', function () { return view('pages.sponsor'); })->name('sponsor');
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

        // Robust resolution for "Parole d'experts" page
        if (!$category && in_array($slug, ['parole-experts', 'parole-d-experts'])) {
            $nameVariants = ["Parole d'experts", "Parole d’experts", "Parole D'Experts", "Parole D’Experts"];
            $slugVariants = ['parole-experts', 'parole-d-experts'];
            // First, try with active constraints
            $category = \App\Models\Category::where(function($q) use ($nameVariants, $slugVariants) {
                    $q->whereIn('slug', $slugVariants)
                      ->orWhereIn('name', $nameVariants);
                })
                ->where(function($q){
                    // accept either explicit 'active' or missing columns gracefully
                    $q->where('status', 'active')
                      ->orWhereNull('status');
                })
                ->where(function($q){
                    $q->where('is_active', 1)
                      ->orWhereNull('is_active');
                })
                ->first();

            // If still not found, try without any status filters as a final fallback
            if (!$category) {
                $category = \App\Models\Category::where(function($q) use ($nameVariants, $slugVariants) {
                        $q->whereIn('slug', $slugVariants)
                          ->orWhereIn('name', $nameVariants);
                    })
                    ->first();
            }

        // Final fuzzy fallback for Parole d'experts-like slugs/names
        if (!$category && (stripos($slug, 'parole') !== false && stripos($slug, 'expert') !== false)) {
            // Try to find a category whose slug or name looks like "parole" + "expert"
            $baseQuery = \App\Models\Category::query()
                ->where(function($q){
                    $q->where('slug', 'like', '%parole%expert%')
                      ->orWhere('name', 'like', '%parole%expert%');
                });

            // Prefer active when possible
            $category = (clone $baseQuery)
                ->where(function($q){
                    $q->where('status', 'active')->orWhereNull('status');
                })
                ->where(function($q){
                    $q->where('is_active', 1)->orWhereNull('is_active');
                })
                ->first();

            if (!$category) {
                $category = $baseQuery->first();
            }
        }
        }
        
        if (!$category) {
            abort(404, 'Catégorie non trouvée');
        }
        
        $query = \App\Models\Article::with(['category', 'user'])
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc');

        // Sector filtering for Figures de l'économie and Entreprises & Impacts
        $isFigures = in_array($category->slug, ['figures-economie', 'figures-de-leconomie', 'figures-de-l-economie']);
        $isEntreprisesImpacts = ($category->slug === 'entreprises-impacts');
        $isContributionsAnalyses = ($category->slug === 'contributions-analyses');
        $isPortraitEntrepreneur = ($category->slug === 'portrait-entrepreneur');
        $isGrandsGenres = ($category->slug === 'grands-genres');
        $sector = request('sector');
        $sectorApplied = false; // track if a valid sector filter is applied
        $allowedSectors = ['agriculture', 'technologie', 'industrie', 'services', 'energie'];
        // Map each FR sector to accepted DB values (compatibility with legacy EN values)
        $sectorValueMap = [
            'agriculture' => ['agriculture'],
            'technologie' => ['technologie', 'tech', 'technology'],
            'industrie'   => ['industrie', 'mining', 'industrie-extractives', 'industry'],
            'services'    => ['services', 'telecom', 'télécom'],
            'energie'     => ['energie', 'énergie', 'energy']
        ];
        if (($isFigures || $isEntreprisesImpacts) && $sector) {
            $normalizedSector = strtolower($sector);
            if (in_array($normalizedSector, $allowedSectors)) {
                $accepted = $sectorValueMap[$normalizedSector] ?? [$normalizedSector];
                $query->whereIn('sector', $accepted);
                $sector = $normalizedSector; // ensure view receives normalized value
                $sectorApplied = true;
            }
        }

        // Theme filtering only for Grands Genres
        $allowedThemes = ['reportages', 'interviews', 'documentaires', 'temoignages'];
        $theme = request('theme');
        if ($isGrandsGenres && $theme && in_array(strtolower($theme), $allowedThemes)) {
            $query->where('theme', strtolower($theme));
        }

        // Featured article handling
        $featuredArticle = null;
        if ($isEntreprisesImpacts) {
            // For Entreprises & Impacts: choose featured only when a valid sector filter is applied
            if ($sectorApplied) {
                $featuredQuery = clone $query;
                $featuredArticle = $featuredQuery->where('is_featured', true)->first();
                if ($featuredArticle) {
                    $query->where('id', '!=', $featuredArticle->id);
                }
            } else {
                // "Tous les secteurs" -> no single featured; show all articles
                $featuredArticle = null;
            }
        } elseif ($isContributionsAnalyses) {
            // Allow explicit featured for Contributions & Analyses (category-wide)
            // Do NOT exclude it from the list: show featured AND keep full list
            $featuredQuery = clone $query;
            $featuredArticle = $featuredQuery->where('is_featured', true)->first();
        } elseif ($isPortraitEntrepreneur) {
            // Portrait d'Entrepreneur: allow explicit featured; keep it in the list
            $featuredQuery = clone $query;
            $featuredArticle = $featuredQuery->where('is_featured', true)->first();
        }

        $articles = $query->paginate(12)->appends(request()->query());
            
        $relatedCategories = \App\Models\Category::where('status', 'active')
            ->where('id', '!=', $category->id)
            ->withCount('articles')
            ->limit(8)
            ->get();

        // Available sectors for UI
        $availableSectors = collect();
        if ($isFigures || $isEntreprisesImpacts) {
            $availableSectors = \App\Models\Article::where('category_id', $category->id)
                ->whereNotNull('sector')
                ->distinct()
                ->pluck('sector')
                ->filter();
        }
        
        return view('articles.category', compact('category', 'articles', 'relatedCategories', 'slug', 'availableSectors', 'isFigures', 'isEntreprisesImpacts', 'isContributionsAnalyses', 'isPortraitEntrepreneur', 'sector', 'isGrandsGenres', 'allowedSectors', 'featuredArticle'))
            ->with(['theme' => $theme, 'allowedThemes' => $allowedThemes]); 
    })->name('category');
    
    Route::get('/{slug}', function ($slug) {
        $article = \App\Models\Article::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
            
        // Increment view count
        $article->increment('view_count');
        
        // Get related articles from same category
        $relatedArticles = \App\Models\Article::with(['category', 'user'])
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        
        return view('articles.show', compact('article', 'relatedArticles')); 
    })->name('show');
    
    Route::get('/search', function () { 
        return view('articles.search'); 
    })->name('search');
});

// Magazines routes
Route::prefix('magazines')->name('magazines.')->group(function () {
    Route::get('/', [App\Http\Controllers\MagazineController::class, 'publicIndex'])->name('index');
    Route::get('/{id}', function ($id) { 
        return view('magazines.show', compact('id')); 
    })->name('show')->where('id', '[0-9]+');
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

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
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

    // Gestion des contacts
    Route::prefix('dashboard/contacts')->name('dashboard.contacts.')->group(function () {
        Route::get('/', [App\Http\Controllers\ContactController::class, 'index'])->name('index');
        Route::get('/{contact}', [App\Http\Controllers\ContactController::class, 'show'])->name('show');
        Route::put('/{contact}', [App\Http\Controllers\ContactController::class, 'update'])->name('update');
        Route::delete('/{contact}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [App\Http\Controllers\ContactController::class, 'bulkAction'])->name('bulk-action');
        Route::get('/export/csv', [App\Http\Controllers\ContactController::class, 'export'])->name('export');
    });
});

// === ROUTES WEBTV - ACCESSIBLE À TOUS LES UTILISATEURS AUTHENTIFIÉS ===
Route::middleware(['auth', 'verifier.role'])->group(function () {
    Route::prefix('dashboard/webtv')->name('dashboard.webtv.')->group(function () {
        Route::get('/', [App\Http\Controllers\WebtvController::class, 'index'])->name('index');
        Route::get('/media/create', function() {
            return view('dashboard.webtv.add-media', ['type' => 'live']);
        })->name('media.create');
        Route::get('/programs/create', function() {
            return view('dashboard.webtv.add-media', ['type' => 'programme']);
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

        return view('pages.webtv', [
            'webtvs' => $webtvs,
            'categories' => $allCategories,
            'currentCategory' => $current,
        ]);
    })->name('index');
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
