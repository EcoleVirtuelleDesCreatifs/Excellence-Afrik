<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

        // Dashboard statistics
        $stats = [
            'articles' => 45,
            'views' => 12500,
            'subscribers' => 850,
            'revenue' => 25000
        ];

        return view('dashboard.index', compact('user', 'stats'));
    }

    /**
     * Show articles management page.
     */
    public function articles()
    {
        // Récupération des articles avec leurs relations
        $articles = Article::with(['category', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.articles', compact('articles'));
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
     * Show analytics page.
     */
    public function analytics()
    {
        return view('dashboard.analytics');
    }

    /**
     * Show create article page.
     */
    public function createArticle()
    {
        // Récupération des catégories depuis la base de données
        $categories = Category::where('status', 'active')
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('dashboard.articles.create', compact('categories'));
    }

    /**
     * Store a new article.
     */
    public function storeArticle(Request $request)
    {
        // Validation des données
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
            'status' => 'required|in:draft,published',
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

        // Message de succès et redirection
        $message = $validatedData['status'] === 'published'
            ? 'Article publié avec succès !'
            : 'Article enregistré comme brouillon.';

        return redirect()->route('dashboard.articles')
            ->with('success', $message);
    }

    /**
     * Show edit article page.
     */
    public function editArticle($id)
    {
        $article = Article::with('category')->findOrFail($id);
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        return view('dashboard.articles.edit', compact('article', 'categories'));
    }



    /**
     * Update an article.
     */
    public function updateArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);

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
            'status' => 'required|in:draft,published,archived',
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
     */
    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);

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
}
