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

// Dashboard Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/test', function() { return view('dashboard.test'); })->name('dashboard.test');
    Route::get('/dashboard/articles', [App\Http\Controllers\DashboardController::class, 'articles'])->name('dashboard.articles');
    Route::get('/dashboard/articles/create', [App\Http\Controllers\DashboardController::class, 'createArticle'])->name('dashboard.articles.create');
    Route::post('/dashboard/articles', [App\Http\Controllers\DashboardController::class, 'storeArticle'])->name('dashboard.articles.store');
    Route::get('/dashboard/articles/{id}/edit', [App\Http\Controllers\DashboardController::class, 'editArticle'])->name('dashboard.articles.edit');
    Route::put('/dashboard/articles/{id}', [App\Http\Controllers\DashboardController::class, 'updateArticle'])->name('dashboard.articles.update');
    Route::delete('/dashboard/articles/{id}', [App\Http\Controllers\DashboardController::class, 'deleteArticle'])->name('dashboard.articles.delete');
    
    // Category management routes
    Route::get('/dashboard/categories', [App\Http\Controllers\DashboardController::class, 'categories'])->name('dashboard.categories.index');
    Route::get('/dashboard/categories/create', [App\Http\Controllers\DashboardController::class, 'createCategory'])->name('dashboard.categories.create');
    Route::post('/dashboard/categories', [App\Http\Controllers\DashboardController::class, 'storeCategory'])->name('dashboard.categories.store');
    Route::get('/dashboard/categories/{id}/edit', [App\Http\Controllers\DashboardController::class, 'editCategory'])->name('dashboard.categories.edit');
    Route::put('/dashboard/categories/{id}', [App\Http\Controllers\DashboardController::class, 'updateCategory'])->name('dashboard.categories.update');
    Route::delete('/dashboard/categories/{id}', [App\Http\Controllers\DashboardController::class, 'deleteCategory'])->name('dashboard.categories.delete');
    
    // Dashboard Magazines CRUD
    Route::prefix('dashboard/magazines')->name('dashboard.magazines.')->group(function () {
        Route::get('/', [App\Http\Controllers\MagazineController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\MagazineController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\MagazineController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [App\Http\Controllers\MagazineController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\MagazineController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\MagazineController::class, 'destroy'])->name('destroy');
    });
    Route::get('/dashboard/users', [App\Http\Controllers\DashboardController::class, 'users'])->name('dashboard.users');
    Route::get('/dashboard/settings', [App\Http\Controllers\DashboardController::class, 'settings'])->name('dashboard.settings');
    Route::get('/dashboard/analytics', [App\Http\Controllers\DashboardController::class, 'analytics'])->name('dashboard.analytics');

    // Dashboard WebTV routes
    Route::prefix('dashboard/webtv')->name('dashboard.webtv.')->group(function () {
        // Index WebTV (admin dashboard)
        Route::get('/', [App\Http\Controllers\WebtvController::class, 'index'])->name('index');

        // Ajouter un Live
        Route::get('/media/create', function() {
            return view('dashboard.webtv.add-media', ['type' => 'live']);
        })->name('media.create');

        // Ajouter un Programme
        Route::get('/programs/create', function() {
            return view('dashboard.webtv.add-media', ['type' => 'programme']);
        })->name('programs.create');

        // Enregistrer
        Route::post('/store', [App\Http\Controllers\WebtvController::class, 'store'])->name('store');

        // Prévisualisation embed
        Route::post('/preview-embed', [App\Http\Controllers\WebtvController::class, 'previewEmbed'])->name('preview-embed');

        // Edit/Update/Destroy
        Route::get('/{webtv}/edit', [App\Http\Controllers\WebtvController::class, 'edit'])->name('edit');
        Route::put('/{webtv}', [App\Http\Controllers\WebtvController::class, 'update'])->name('update');
        Route::delete('/{webtv}', [App\Http\Controllers\WebtvController::class, 'destroy'])->name('destroy');

        // AJAX actions
        Route::post('/{webtv}/toggle-actif', [App\Http\Controllers\WebtvController::class, 'toggleActif'])->name('toggle-actif');
        Route::post('/{webtv}/changer-statut', [App\Http\Controllers\WebtvController::class, 'changerStatut'])->name('changer-statut');
    });
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
Route::post('/newsletter/subscribe', function () {
    return redirect()->back()->with('success', 'Merci pour votre inscription !');
})->name('newsletter.subscribe');
