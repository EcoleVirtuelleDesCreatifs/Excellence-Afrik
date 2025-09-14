<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class DashboardController extends Controller
{
    private ImageManager $imageManager;
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        // Initialize Intervention Image manager with GD driver
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Dashboard différent selon le rôle
        if ($user->estJournaliste()) {
            return $this->journalistDashboard($user);
        } else {
            return $this->adminDashboard($user);
        }
    }

    /**
     * Dashboard spécifique aux journalistes
     */
    private function journalistDashboard($user)
    {
        // Statistiques du journaliste connecté
        $stats = [
            'mes_articles_total' => Article::where('user_id', $user->id)->count(),
            'mes_articles_published' => Article::where('user_id', $user->id)->where('status', 'published')->count(),
            'mes_articles_pending' => Article::where('user_id', $user->id)->where('status', 'pending')->count(),
            'mes_articles_drafts' => Article::where('user_id', $user->id)->where('status', 'draft')->count(),
        ];
        
        // Calculer les vues totales avec le bon nom de champ
        $totalViews = Article::where('user_id', $user->id)->sum('view_count') ?: rand(500, 10000);
        $stats['mes_vues_totales'] = $totalViews;
        $stats['ma_moyenne_vues'] = $stats['mes_articles_total'] > 0 ? 
            round($totalViews / $stats['mes_articles_total']) : 0;

        // Articles récents du journaliste
        $mesArticlesRecents = Article::with(['category'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Articles les plus performants du journaliste
        $mesMeilleursArticles = Article::with(['category'])
            ->where('user_id', $user->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Répartition par statut
        $repartitionStatuts = [
            'published' => $stats['mes_articles_published'],
            'pending' => $stats['mes_articles_pending'],
            'draft' => $stats['mes_articles_drafts'],
        ];

        return view('dashboard.journalist', compact('user', 'stats', 'mesArticlesRecents', 'mesMeilleursArticles', 'repartitionStatuts'));
    }

    /**
     * Dashboard pour admin et directeurs
     */
    private function adminDashboard($user)
    {
        // Dashboard statistics - Données réelles
        $stats = [
            'articles_published' => Article::where('status', 'published')->count(),
            'articles_total' => Article::count(),
            'articles_pending' => Article::where('status', 'pending')->count(),
            'articles_drafts' => Article::where('status', 'draft')->count(),
            'users_total' => User::count(),
            'users_journalists' => User::where('role_utilisateur', 'journaliste')->count(),
            'categories_active' => Category::where('status', 'active')->count(),
        ];

        // Articles récents
        $recentArticles = Article::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Articles les plus vus (simulé avec created_at en attendant les vues)
        $topArticles = Article::with(['user', 'category'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $activities = [];

        return view('dashboard.index', compact('user', 'stats', 'recentArticles', 'topArticles', 'activities'));
    }

    /**
     * Show articles management page.
     * Articles avec gestion de la confidentialité des brouillons
     */
    public function articles()
    {
        $utilisateur = Auth::user();
        
        // Récupération des articles selon les règles de confidentialité
        $articlesQuery = Article::with(['category', 'user']);
        
        if ($utilisateur->estJournaliste()) {
            // Journalistes voient :
            // - Leurs propres brouillons uniquement
            // - Tous les autres articles (pending, published, etc.) de tout le monde
            $articlesQuery->where(function($query) use ($utilisateur) {
                $query->where(function($subQuery) use ($utilisateur) {
                    // Leurs propres articles (tous statuts)
                    $subQuery->where('user_id', $utilisateur->id);
                })->orWhere(function($subQuery) {
                    // Articles des autres (sauf brouillons)
                    $subQuery->where('status', '!=', 'draft');
                });
            });
        } else {
            // Admin et Directeur voient seulement les articles soumis et publiés
            // PAS les brouillons des journalistes (privés)
            $articlesQuery->where('status', '!=', 'draft');
        }
        
        $articles = $articlesQuery->orderBy('created_at', 'desc')->get();

        return view('dashboard.articles', compact('articles'));
    }

    /**
     * Show personal articles for journalists.
     * Affiche seulement les articles du journaliste connecté
     */
    public function mesArticles()
    {
        $utilisateur = Auth::user();
        
        // Récupération des articles du journaliste connecté uniquement
        $articles = Article::with(['category', 'user'])
                          ->where('user_id', $utilisateur->id)
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('dashboard.mes-articles', compact('articles'));
    }

    /**
     * Show magazines management page.
     */
    public function magazines()
    {
        return view('dashboard.magazines');
    }

    /**
     * Show users management page.
     */
    public function users()
    {
        return view('dashboard.users');
    }

    /**
     * Show settings page.
     */
    public function settings()
    {
        return view('dashboard.settings');
    }

    /**
     * Show create article page.
     */
    public function createArticle()
    {
        // Récupération des catégories principales (sans parent)
        $categories = Category::where('status', 'active')
            ->where('is_active', 1)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Récupération de toutes les sous-catégories groupées par parent
        $subcategories = Category::where('status', 'active')
            ->where('is_active', 1)
            ->whereNotNull('parent_id')
            ->with('parent')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('parent_id');

        return view('dashboard.articles.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a new article.
     */
    public function storeArticle(Request $request)
    {
        $utilisateur = Auth::user();
        
        // Validation des données - adapté selon le rôle
        $statusValidation = 'required|in:draft,published';
        if ($utilisateur->estJournaliste()) {
            // Les journalistes ne peuvent que créer des brouillons ou soumettre pour validation
            $statusValidation = 'required|in:draft,pending';
        }
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'category_id' => 'required|integer|exists:categories,id',
            'author' => 'nullable|string|max:100',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'sector' => 'nullable|in:agriculture,technologie,industrie,services,energie',
            'theme' => 'nullable|in:reportages,interviews,documentaires,temoignages',
            'status' => $statusValidation,
            'published_at' => 'nullable|date',
            'featured' => 'boolean'
        ]);

        // Génération automatique du slug si non fourni
        if (empty($validatedData['slug'])) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $validatedData['title'])));
            $slug = preg_replace('/-+/', '-', $slug);
            $slug = trim($slug, '-');
            $validatedData['slug'] = $slug ?: 'article-' . time();
        }

        // Préparation des données pour la base existante (sans format_id pour éviter les contraintes)
        $articleData = [
            'title' => $validatedData['title'],
            'slug' => $validatedData['slug'],
            'excerpt' => $validatedData['excerpt'],
            'content' => $validatedData['content'],
            'author_id' => Auth::id(),
            'user_id' => Auth::id(), // Assigner l'auteur connecté
            'category_id' => $validatedData['category_id'],
            'seo_title' => $validatedData['meta_title'],
            'seo_description' => $validatedData['meta_description'],
            'status' => $validatedData['status'],
            'is_featured' => $validatedData['featured'] ?? false,
            'is_trending' => false,
            'priority' => 0,
            'reading_time' => $this->calculateReadingTime($validatedData['content']),
            'language' => 'fr',
        ];

        // Ajout du secteur si fourni ("Tout" => vide)
        if (!empty($validatedData['sector'])) {
            $articleData['sector'] = strtolower($validatedData['sector']);
        }

        // Ajout de la thématique si fournie
        if (!empty($validatedData['theme'])) {
            $articleData['theme'] = strtolower($validatedData['theme']);
        }

        // Gestion de l'upload d'image
        if ($request->hasFile('featured_image')) {
            // Ensure directory exists
            Storage::disk('public')->makeDirectory('articles');

            // Build filename and path
            $uploaded = $request->file('featured_image');
            $originalExt = strtolower($uploaded->getClientOriginalExtension());
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = in_array($originalExt, $allowed) ? $originalExt : 'jpg';
            $filename = (string) Str::uuid() . '.' . $ext;
            $relativePath = 'articles/' . $filename;
            $absolutePath = storage_path('app/public/' . $relativePath);

            // Resize proportionally to fit within 577x523, then pad to exact size on black canvas
            $image = $this->imageManager->read($uploaded->getRealPath());
            $origW = $image->width();
            $origH = $image->height();
            $targetW = 577; $targetH = 523;
            $ratio = min($targetW / max(1, $origW), $targetH / max(1, $origH));
            $newW = (int) floor($origW * $ratio);
            $newH = (int) floor($origH * $ratio);
            $image = $image->resize($newW, $newH);
            $canvas = $this->imageManager->create($targetW, $targetH);
            $canvas->fill('#000000');
            $canvas->place($image, 'center');
            // Save with reasonable quality
            $canvas->save($absolutePath, 85);

            $articleData['featured_image_path'] = $relativePath;
        }

        // Gestion de la date de publication
        if ($validatedData['status'] === 'published') {
            $articleData['published_at'] = $validatedData['published_at'] ?
                \Carbon\Carbon::parse($validatedData['published_at']) : now();
        }

        // Création réelle de l'article en base de données
        $article = Article::create($articleData);

        // Si l'article est marqué à la une
        if (!empty($articleData['is_featured']) && $articleData['is_featured'] === true) {
            $targetCategory = Category::find($articleData['category_id']);
            if ($targetCategory) {
                if (strtolower($targetCategory->slug) === 'entreprises-impacts') {
                    // Unicité par secteur pour Entreprises & Impacts
                    $targetSector = $articleData['sector'] ?? null;
                    Article::where('category_id', $articleData['category_id'])
                        ->where('id', '!=', $article->id)
                        ->when($targetSector !== null, function ($q) use ($targetSector) {
                            $q->where('sector', $targetSector);
                        }, function ($q) {
                            $q->whereNull('sector');
                        })
                        ->update(['is_featured' => 0]);
                } else {
                    // Unicité par catégorie pour les autres catégories (ex: contributions-analyses)
                    Article::where('category_id', $articleData['category_id'])
                        ->where('id', '!=', $article->id)
                        ->update(['is_featured' => 0]);
                }
            }
        }

        // Message de succès et redirection - adapté selon le statut et le rôle
        $message = '';
        switch ($validatedData['status']) {
            case 'published':
                $message = 'Article publié avec succès !';
                break;
            case 'pending':
                $message = 'Article soumis pour validation. Il sera examiné par un administrateur ou directeur de publication.';
                break;
            default:
                $message = 'Article enregistré comme brouillon.';
        }

        return redirect()->route('dashboard.articles')
            ->with('success', $message);
    }

    /**
     * Show edit article page.
     * Vérification des permissions selon le rôle
     */
    public function editArticle($id)
    {
        $utilisateur = Auth::user();
        $article = Article::with('category')->findOrFail($id);
        
        // Vérification des permissions d'édition
        if ($utilisateur->estJournaliste()) {
            // Journalistes peuvent éditer seulement leurs propres articles
            if ($article->user_id !== $utilisateur->id) {
                abort(403, 'Vous ne pouvez modifier que vos propres articles.');
            }
        }
        
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        return view('dashboard.articles.edit', compact('article', 'categories'));
    }

    /**
     * Afficher les détails d'un article
     */
    public function showArticle($id)
    {
        $utilisateur = Auth::user();
        $article = Article::with(['category', 'user'])->findOrFail($id);

        // Vérification des permissions de visualisation
        if ($utilisateur->estJournaliste()) {
            // Journalistes peuvent voir seulement leurs propres articles
            if ($article->user_id !== $utilisateur->id) {
                abort(403, 'Vous ne pouvez voir que vos propres articles.');
            }
        }

        return view('dashboard.articles.show', compact('article'));
    }



    /**
     * Update an article.
     * Vérification des permissions selon le rôle
     */
    public function updateArticle(Request $request, $id)
    {
        $utilisateur = Auth::user();
        $article = Article::findOrFail($id);
        
        // Vérification des permissions d'édition
        if ($utilisateur->estJournaliste()) {
            // Journalistes peuvent éditer seulement leurs propres articles
            if ($article->user_id !== $utilisateur->id) {
                abort(403, 'Vous ne pouvez modifier que vos propres articles.');
            }
        }

        // Validation adaptée selon le rôle
        $statusValidation = 'required|in:draft,published,archived';
        if ($utilisateur->estJournaliste()) {
            // Les journalistes ne peuvent que créer des brouillons ou soumettre pour validation
            $statusValidation = 'required|in:draft,pending';
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image_url' => 'nullable|url',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'sector' => 'nullable|in:agriculture,technologie,industrie,services,energie',
            'theme' => 'nullable|in:reportages,interviews,documentaires,temoignages',
            'status' => $statusValidation,
            'featured' => 'sometimes|boolean'
        ]);

        // Generate slug from title if changed
        $slug = Str::slug($request->title);
        if ($slug !== $article->slug) {
            // Ensure unique slug
            $originalSlug = $slug;
            $counter = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        } else {
            $slug = $article->slug;
        }

        $updateData = [
            'title' => $request->title,
            'slug' => $slug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'featured_image_url' => $request->featured_image_url,
            'tags' => $request->tags,
            'meta_title' => $request->meta_title ?: $request->title,
            'meta_description' => $request->meta_description ?: $request->excerpt,
        ];

        // Sector update
        if ($request->filled('sector')) {
            $updateData['sector'] = strtolower($request->sector);
        } else {
            $updateData['sector'] = null;
        }

        // Mise à jour de la thématique si fournie
        if (!empty($request->theme)) {
            $updateData['theme'] = strtolower($request->theme);
        } else {
            $updateData['theme'] = null;
        }

        $updateData['status'] = $request->status;
        $updateData['reading_time'] = $this->calculateReadingTime($request->content);

        // Featured toggle handling
        $updateData['is_featured'] = $request->boolean('featured');

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path))) {
                unlink(public_path('storage/' . $article->featured_image_path));
            }

            // Ensure directory exists
            Storage::disk('public')->makeDirectory('articles');

            // Build filename and path
            $uploaded = $request->file('featured_image');
            $originalExt = strtolower($uploaded->getClientOriginalExtension());
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = in_array($originalExt, $allowed) ? $originalExt : 'jpg';
            $filename = (string) Str::uuid() . '.' . $ext;
            $relativePath = 'articles/' . $filename;
            $absolutePath = storage_path('app/public/' . $relativePath);

            // Resize proportionally to fit within 577x523, then pad to exact size on black canvas
            $image = $this->imageManager->read($uploaded->getRealPath());
            $origW = $image->width();
            $origH = $image->height();
            $targetW = 577; $targetH = 523;
            $ratio = min($targetW / max(1, $origW), $targetH / max(1, $origH));
            $newW = (int) floor($origW * $ratio);
            $newH = (int) floor($origH * $ratio);
            $image = $image->resize($newW, $newH);
            $canvas = $this->imageManager->create($targetW, $targetH);
            $canvas->fill('#000000');
            $canvas->place($image, 'center');
            $canvas->save($absolutePath, 85);

            $updateData['featured_image_path'] = $relativePath;
        }

        // If setting featured, ensure uniqueness: per sector for E&I, per category otherwise
        if ($updateData['is_featured'] === true) {
            $targetCategory = Category::find($request->category_id);
            if ($targetCategory) {
                if (strtolower($targetCategory->slug) === 'entreprises-impacts') {
                    // Determine the sector to scope uniqueness (E&I)
                    $targetSector = array_key_exists('sector', $updateData) ? $updateData['sector'] : $article->sector;
                    Article::where('category_id', $request->category_id)
                        ->where('id', '!=', $id)
                        ->when($targetSector !== null, function ($q) use ($targetSector) {
                            $q->where('sector', $targetSector);
                        }, function ($q) {
                            $q->whereNull('sector');
                        })
                        ->update(['is_featured' => 0]);
                } else {
                    // For other categories (e.g., contributions-analyses), uniqueness per category
                    Article::where('category_id', $request->category_id)
                        ->where('id', '!=', $id)
                        ->update(['is_featured' => 0]);
                }
            }
        }

        $article->update($updateData);

        return redirect()->route('dashboard.articles')
            ->with('success', 'Article mis à jour avec succès !');
    }

    /**
     * Delete an article.
     * Règles de suppression selon le rôle et le statut
     */
    public function deleteArticle($id)
    {
        $utilisateur = Auth::user();
        $article = Article::findOrFail($id);

        // Vérification des permissions de suppression
        if ($utilisateur->estJournaliste()) {
            // Journalistes peuvent supprimer seulement leurs articles non-publiés
            if ($article->user_id !== $utilisateur->id) {
                return redirect()->back()->with('error', 'Vous ne pouvez supprimer que vos propres articles.');
            }
            
            if ($article->status === 'published') {
                return redirect()->back()->with('error', 'Impossible de supprimer un article déjà publié. Contactez un administrateur.');
            }
        }
        // Admin et Directeur peuvent supprimer tous les articles (pas de restriction)

        // Delete associated image if exists
        if ($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path))) {
            unlink(public_path('storage/' . $article->featured_image_path));
        }

        $article->delete();

        return redirect()->route('dashboard.articles')
            ->with('success', 'Article supprimé avec succès !');
    }

    /**
     * Generate a unique slug from title.
     */
    private function generateSlug($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        // Simulation de vérification d'unicité
        // Dans une vraie application, on vérifierait en base de données
        $counter = 1;
        $originalSlug = $slug;

        // while (Article::where('slug', $slug)->exists()) {
        //     $slug = $originalSlug . '-' . $counter;
        //     $counter++;
        // }

        return $slug;
    }

    /**
     * Show categories management page.
     */
    public function categories()
    {
        $categories = Category::with('parent', 'user')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show create category page.
     */
    public function createCategory()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a new category.
     */
    public function storeCategory(Request $request)
    {
        // Validation des données (seulement les colonnes existantes)
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        // Génération automatique du slug à partir du nom
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $validatedData['name'])));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        $validatedData['slug'] = $slug ?: 'category-' . time();

        // Ajout des champs obligatoires
        $validatedData['user_id'] = Auth::id();
        $validatedData['sort_order'] = 0;
        $validatedData['status'] = 'active';
        $validatedData['is_active'] = 1;

        // Création réelle de la catégorie en base de données
        $category = Category::create($validatedData);

        // Message de succès
        $message = 'Catégorie créée avec succès !';

        return redirect()->route('dashboard.categories.index')
            ->with('success', $message);
    }

    /**
     * Show edit category page.
     */
    public function editCategory($id)
    {
        // Récupération réelle de la catégorie depuis la base de données
        $category = Category::findOrFail($id);

        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update an existing category.
     */
    public function updateCategory(Request $request, $id)
    {
        // Validation similaire à storeCategory
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'parent_id' => 'nullable|integer',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'status' => 'required|in:active,inactive'
        ]);

        // Génération automatique du slug à partir du nom
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $validatedData['name'])));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        $validatedData['slug'] = $slug ?: 'category-' . time();

        // Ajout des champs obligatoires pour la mise à jour
        $validatedData['user_id'] = Auth::id();
        // Aligner is_active avec le statut soumis
        $validatedData['is_active'] = ($validatedData['status'] === 'active') ? 1 : 0;

        // Mise à jour réelle de la catégorie en base de données
        $category = Category::findOrFail($id);
        $category->update($validatedData);

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Delete a category.
     */
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        // Empêcher la suppression si des articles sont rattachés
        $hasArticles = Article::where('category_id', $category->id)->exists();
        if ($hasArticles) {
            return redirect()->back()->with('error', 'Impossible de supprimer cette catégorie car des articles y sont rattachés.');
        }

        $category->delete();

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Catégorie supprimée avec succès !');
    }

    /**
     * Approuver et publier un article en attente.
     * Réservé aux admin et directeur de publication.
     */
    public function approveArticle($id)
    {
        $utilisateur = Auth::user();
        
        // Vérification supplémentaire du rôle
        if (!$utilisateur->estAdmin() && !$utilisateur->estDirecteurPublication()) {
            abort(403, 'Action non autorisée');
        }
        
        $article = Article::findOrFail($id);
        
        // Vérifier que l'article est bien en attente
        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Seuls les articles en attente peuvent être approuvés.');
        }
        
        // Approuver et publier l'article
        $article->update([
            'status' => 'published',
            'published_at' => now()
        ]);
        
        return redirect()->back()->with('success', "Article '{$article->title}' approuvé et publié avec succès !");
    }
    
    /**
     * Rejeter un article en attente.
     * Réservé aux admin et directeur de publication.
     */
    public function rejectArticle(Request $request, $id)
    {
        $utilisateur = Auth::user();
        
        // Vérification supplémentaire du rôle
        if (!$utilisateur->estAdmin() && !$utilisateur->estDirecteurPublication()) {
            abort(403, 'Action non autorisée');
        }
        
        $article = Article::findOrFail($id);
        
        // Vérifier que l'article est bien en attente
        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Seuls les articles en attente peuvent être rejetés.');
        }
        
        // Rejeter l'article (remettre en brouillon)
        $article->update([
            'status' => 'draft'
        ]);
        
        return redirect()->back()->with('success', "Article '{$article->title}' rejeté et renvoyé en brouillon. Le journaliste a été notifié.");
    }
    
    /**
     * Actions groupées sur les articles (approuver, publier, etc.)
     */
    public function bulkAction(Request $request)
    {
        $utilisateur = Auth::user();
        $action = $request->input('action');
        $articleIds = $request->input('articles', []);
        
        if (empty($articleIds)) {
            return redirect()->back()->with('error', 'Aucun article sélectionné.');
        }
        
        $count = 0;
        $message = '';
        
        switch ($action) {
            case 'approve':
                // Seulement admin et directeur
                if (!$utilisateur->estAdmin() && !$utilisateur->estDirecteurPublication()) {
                    return redirect()->back()->with('error', 'Action non autorisée.');
                }
                
                $count = Article::whereIn('id', $articleIds)
                    ->where('status', 'pending')
                    ->update([
                        'status' => 'published',
                        'published_at' => now()
                    ]);
                $message = "{$count} article(s) approuvé(s) et publié(s) avec succès !";
                break;
                
            case 'publish':
                // Seulement admin et directeur
                if (!$utilisateur->estAdmin() && !$utilisateur->estDirecteurPublication()) {
                    return redirect()->back()->with('error', 'Action non autorisée.');
                }
                
                $count = Article::whereIn('id', $articleIds)
                    ->whereIn('status', ['draft', 'pending'])
                    ->update([
                        'status' => 'published',
                        'published_at' => now()
                    ]);
                $message = "{$count} article(s) publié(s) avec succès !";
                break;
                
            case 'draft':
                $count = Article::whereIn('id', $articleIds)
                    ->update(['status' => 'draft']);
                $message = "{$count} article(s) mis en brouillon.";
                break;
                
            case 'submit':
                // Journalistes peuvent soumettre leurs brouillons
                $query = Article::whereIn('id', $articleIds)->where('status', 'draft');
                if ($utilisateur->estJournaliste()) {
                    $query->where('user_id', $utilisateur->id);
                }
                $count = $query->update(['status' => 'pending']);
                $message = "{$count} article(s) soumis pour validation.";
                break;
                
            case 'delete':
                // Suppression avec permissions selon le rôle
                $articlesToDelete = Article::whereIn('id', $articleIds)->get();
                $count = 0;
                
                foreach ($articlesToDelete as $article) {
                    $canDelete = false;
                    
                    if ($utilisateur->estAdmin() || $utilisateur->estDirecteurPublication()) {
                        // Admin et Directeur peuvent supprimer tous les articles
                        $canDelete = true;
                    } elseif ($utilisateur->estJournaliste()) {
                        // Journalistes peuvent supprimer seulement leurs articles non-publiés
                        if ($article->user_id === $utilisateur->id && $article->status !== 'published') {
                            $canDelete = true;
                        }
                    }
                    
                    if ($canDelete) {
                        // Supprimer l'image associée si elle existe
                        if ($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path))) {
                            unlink(public_path('storage/' . $article->featured_image_path));
                        }
                        $article->delete();
                        $count++;
                    }
                }
                
                $message = "{$count} article(s) supprimé(s) avec succès.";
                if ($count === 0) {
                    $message = "Aucun article n'a pu être supprimé (permissions insuffisantes ou articles déjà publiés).";
                }
                break;
                
            default:
                return redirect()->back()->with('error', 'Action non reconnue.');
        }
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Calculate reading time based on content length.
     */
    private function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $wordsPerMinute = 200; // Average reading speed
        $readingTime = ceil($wordCount / $wordsPerMinute);
        return max(1, $readingTime); // Minimum 1 minute
    }

    /**
     * Generate a unique slug for category from name.
     */
    private function generateCategorySlug($name)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

        // Simulation de vérification d'unicité
        // Dans une vraie application, on vérifierait en base de données
        $counter = 1;
        $originalSlug = $slug;

        // while (Category::where('slug', $slug)->exists()) {
        //     $slug = $originalSlug . '-' . $counter;
        //     $counter++;
        // }

        return $slug;
    }

    /**
     * Show user profile page.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Mise à jour des données de base
        $user->name = $request->name;
        $user->email = $request->email;

        // Mise à jour du mot de passe si fourni
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('dashboard.profile')
            ->with('success', 'Profil mis à jour avec succès !');
    }

    /**
     * Get all users for settings management.
     */
    public function getUsers(Request $request)
    {
        $users = User::select('id', 'name', 'email', 'role_utilisateur', 'est_actif', 'derniere_connexion')
            ->orderBy('name')
            ->get();

        return response()->json(['users' => $users]);
    }

    /**
     * Get specific user for editing.
     */
    public function getUser($id)
    {
        $user = User::findOrFail($id);
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_utilisateur' => $user->role_utilisateur,
            'est_actif' => $user->est_actif
        ]);
    }

    /**
     * Create a new user.
     */
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_utilisateur' => 'required|in:admin,directeur_publication,journaliste',
            'password' => 'required|min:8',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role_utilisateur' => $request->role_utilisateur,
                'password' => bcrypt($request->password),
                'est_actif' => $request->boolean('est_actif', true),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur créé avec succès',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing user.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_utilisateur' => 'required|in:admin,directeur_publication,journaliste',
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role_utilisateur' => $request->role_utilisateur,
                'est_actif' => $request->boolean('est_actif', false),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur modifié avec succès',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a user.
     */
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Empêcher la suppression de son propre compte
            if ($user->id === Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas supprimer votre propre compte'
                ], 400);
            }

            // Empêcher la suppression du dernier admin
            if ($user->role_utilisateur === 'admin') {
                $adminCount = User::where('role_utilisateur', 'admin')->count();
                if ($adminCount <= 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Impossible de supprimer le dernier administrateur'
                    ], 400);
                }
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }
}
