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
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->estJournaliste()) {
            return $this->journalistDashboard($user);
        } else {
            return $this->adminDashboard($user);
        }
    }

    /**
     * Dashboard for journalists.
     */
    private function journalistDashboard($user)
    {
        $stats = [
            'mes_articles_total' => Article::where('user_id', $user->id)->count(),
            'mes_articles_published' => Article::where('user_id', $user->id)->where('status', 'published')->count(),
            'mes_articles_pending' => Article::where('user_id', $user->id)->where('status', 'pending')->count(),
            'mes_articles_drafts' => Article::where('user_id', $user->id)->where('status', 'draft')->count(),
        ];

        $totalViews = Article::where('user_id', $user->id)->sum('view_count') ?: 0;
        $stats['mes_vues_totales'] = $totalViews;
        $stats['ma_moyenne_vues'] = $stats['mes_articles_total'] > 0 ? round($totalViews / $stats['mes_articles_total']) : 0;

        // Répartition des statuts pour les graphiques
        $repartitionStatuts = [
            'published' => $stats['mes_articles_published'],
            'pending' => $stats['mes_articles_pending'],
            'draft' => $stats['mes_articles_drafts'],
        ];

        $mesArticlesRecents = Article::with(['category'])->where('user_id', $user->id)->orderBy('created_at', 'desc')->limit(5)->get();
        $mesMeilleursArticles = Article::with(['category'])->where('user_id', $user->id)->where('status', 'published')->orderBy('view_count', 'desc')->limit(6)->get();

        return view('dashboard.journalist', compact('user', 'stats', 'repartitionStatuts', 'mesArticlesRecents', 'mesMeilleursArticles'));
    }

    /**
     * Dashboard for admins and directors.
     */
    private function adminDashboard($user)
    {
        $stats = [
            'articles_published' => Article::where('status', 'published')->count(),
            'articles_total' => Article::count(),
            'articles_pending' => Article::where('status', 'pending')->count(),
            'articles_drafts' => Article::where('status', 'draft')->count(),
            'users_total' => User::count(),
            'users_journalists' => User::where('role_utilisateur', 'journaliste')->count(),
            'categories_active' => Category::where('status', 'active')->count(),
        ];

        $recentArticles = Article::with(['user', 'category'])->orderBy('created_at', 'desc')->limit(5)->get();
        $topArticles = Article::with(['user', 'category'])->where('status', 'published')->orderBy('view_count', 'desc')->limit(6)->get();
        $activities = [];

        return view('dashboard.index', compact('user', 'stats', 'recentArticles', 'topArticles', 'activities'));
    }

    /**
     * Show articles management page.
     */
    public function articles()
    {
        $utilisateur = Auth::user();
        $articlesQuery = Article::with(['category', 'user']);

        if ($utilisateur->estJournaliste()) {
            // Journalists should see all their own articles, regardless of status
            $articlesQuery->where('user_id', $utilisateur->id);
        }
        // Admins and Directors will now see all articles, including drafts.

        $articles = $articlesQuery->orderBy('created_at', 'desc')->paginate(15); // Paginate with 15 articles per page
        return view('dashboard.articles', compact('articles'));
    }

    /**
     * Show create article page.
     */
    public function createArticle()
    {
        $categories = Category::where('status', 'active')->where('is_active', 1)->orderBy('name')->get();
        $parentCategories = $categories->whereNull('parent_id');
        $subcategories = $categories->whereNotNull('parent_id')->groupBy('parent_id');
        // The view also seems to need a flat list of all categories, so we pass it as 'categories'.
        return view('dashboard.articles.create', compact('categories', 'parentCategories', 'subcategories'));
    }

    /**
     * Store a new article.
     */
    public function storeArticle(Request $request)
    {
        $utilisateur = Auth::user();
        $statusValidation = 'required|in:draft,published' . ($utilisateur->estJournaliste() ? ',pending' : '');

        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'category_id' => 'required|integer|exists:categories,id',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'status' => $statusValidation,
            'published_at' => 'nullable|date',
            'featured' => 'boolean'
        ]);

        $slug = $validatedData['slug'] ?: $this->generateSlug($validatedData['title']);

        $articleData = [
            'title' => $validatedData['title'],
            'slug' => $slug,
            'excerpt' => $validatedData['excerpt'],
            'content' => $validatedData['content'],
            'author_id' => Auth::id(),
            'user_id' => Auth::id(), // Assigner l'utilisateur connecté comme auteur
            'category_id' => $validatedData['category_id'],
            'seo_title' => $validatedData['meta_title'],
            'seo_description' => $validatedData['meta_description'],
            'status' => $validatedData['status'],
            'is_featured' => $validatedData['featured'] ?? false,
            'reading_time' => $this->calculateReadingTime($validatedData['content']),
        ];

        if ($request->hasFile('featured_image')) {
            $articleData['featured_image_path'] = $this->processImage($request->file('featured_image'));
        }

        if ($validatedData['status'] === 'published') {
            $articleData['published_at'] = $validatedData['published_at'] ? \Carbon\Carbon::parse($validatedData['published_at']) : now();
        }

        $article = Article::create($articleData);

        if ($articleData['is_featured']) {
            $this->ensureFeaturedUniqueness($article->category_id, $article->id);
        }

        return redirect()->route('dashboard.articles')->with('success', 'Article créé avec succès.');
    }

    /**
     * Show edit article page.
     */
    public function editArticle($id)
    {
        $utilisateur = Auth::user();
        $article = Article::with('category')->findOrFail($id);

        if ($utilisateur->estJournaliste() && $article->author_id !== $utilisateur->id) {
            abort(403, 'Vous ne pouvez modifier que vos propres articles.');
        }

        $categories = Category::where('status', 'active')->orderBy('name')->get();
        return view('dashboard.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update an existing article.
     */
    public function updateArticle(Request $request, $id)
    {
        $utilisateur = Auth::user();
        $article = Article::findOrFail($id);

        if ($utilisateur->estJournaliste() && $article->author_id !== $utilisateur->id) {
            abort(403, 'Vous ne pouvez modifier que vos propres articles.');
        }

        $statusValidation = 'required|in:draft,published,archived,pending';

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => $statusValidation,
            'featured' => 'sometimes|boolean'
        ]);

        $slug = $article->slug;
        if ($request->title !== $article->title) {
            $slug = $this->generateSlug($request->title, $id);
        }

        $updateData = [
            'title' => $validatedData['title'],
            'slug' => $slug,
            'excerpt' => $validatedData['excerpt'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category_id'],
            'status' => $validatedData['status'],
            'reading_time' => $this->calculateReadingTime($validatedData['content']),
            'is_featured' => $request->boolean('featured'),
        ];

        if ($request->hasFile('featured_image')) {
            $updateData['featured_image_path'] = $this->processImage($request->file('featured_image'), $article->featured_image_path);
        }

        if ($updateData['is_featured']) {
            $this->ensureFeaturedUniqueness($updateData['category_id'], $id);
        }

        $article->update($updateData);

        return redirect()->route('dashboard.articles')->with('success', 'Article mis à jour avec succès !');
    }

    /**
     * Delete an article.
     */
    public function deleteArticle($id)
    {
        $utilisateur = Auth::user();
        $article = Article::findOrFail($id);

        if ($utilisateur->estJournaliste() && ($article->author_id !== $utilisateur->id || $article->status === 'published')) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer cet article.');
        }

        if ($article->featured_image_path) {
            Storage::disk('public')->delete($article->featured_image_path);
        }

        $article->delete();

        return redirect()->route('dashboard.articles')->with('success', 'Article supprimé avec succès !');
    }

    /**
     * Show categories management page.
     */
    public function categories()
    {
        $categories = \App\Models\Category::with('parent')->orderBy('name')->get();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show create category page.
     */
    public function createCategory()
    {
        $categories = \App\Models\Category::whereNull('parent_id')->orderBy('name')->get();
        return view('dashboard.categories.create', compact('categories'));
    }

    /**
     * Store a new category.
     */
    public function storeCategory(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string|max:500',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        \App\Models\Category::create($validatedData);

        return redirect()->route('dashboard.categories.index')->with('success', 'Catégorie créée avec succès !');
    }

    /**
     * Show edit category page.
     */
    public function editCategory($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $categories = \App\Models\Category::whereNull('parent_id')->where('id', '!=', $id)->orderBy('name')->get();
        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update an existing category.
     */
    public function updateCategory(Request $request, $id)
    {
        $category = \App\Models\Category::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $id,
            'description' => 'nullable|string|max:500',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        $category->update($validatedData);

        return redirect()->route('dashboard.categories.index')->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Delete a category.
     */
    public function deleteCategory($id)
    {
        $category = \App\Models\Category::findOrFail($id);

        if ($category->articles()->count() > 0) {
            return redirect()->back()->with('error', 'Impossible de supprimer cette catégorie car des articles y sont rattachés.');
        }

        $category->delete();

        return redirect()->route('dashboard.categories.index')->with('success', 'Catégorie supprimée avec succès !');
    }

    private function processImage($file, $oldPath = null)
    {
        if ($oldPath) {
            // Also delete old thumbnail if it exists
            $thumbPath = str_replace('.', '_thumb.', $oldPath);
            Storage::disk('public')->delete($oldPath);
            Storage::disk('public')->delete($thumbPath);
        }

        $extension = $file->getClientOriginalExtension();
        $baseName = (string) Str::uuid();
        
        // Define paths for large and thumb images
        $largeFilename = $baseName . '.' . $extension;
        $thumbFilename = $baseName . '_thumb.' . $extension;
        $relativeLargePath = 'articles/' . $largeFilename;
        $relativeThumbPath = 'articles/' . $thumbFilename;
        $absoluteLargePath = storage_path('app/public/' . $relativeLargePath);
        $absoluteThumbPath = storage_path('app/public/' . $relativeThumbPath);

        // Create image instance
        $image = $this->imageManager->read($file->getRealPath());

        // Create and save large image (781x536)
        $image->cover(781, 536)->save($absoluteLargePath, 85);

        // Create and save thumbnail image (500x300)
        $image->cover(500, 300)->save($absoluteThumbPath, 85);

        // Return the path to the main (large) image
        return $relativeLargePath;
    }

    private function generateSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;
        $query = Article::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter++;
            $query = Article::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }
        return $slug;
    }

    private function calculateReadingTime($content)
    {
        return (int) max(1, ceil(str_word_count(strip_tags($content)) / 200));
    }

    private function ensureFeaturedUniqueness($categoryId, $articleId)
    {
        Article::where('category_id', $categoryId)->where('id', '!=', $articleId)->update(['is_featured' => 0]);
    }
}
