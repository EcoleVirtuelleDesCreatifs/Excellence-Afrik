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
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->imageManager = new ImageManager(new Driver());
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->estJournaliste()) {
            return $this->journalistDashboard($user);
        } else {
            return $this->adminDashboard($user);
        }
    }

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

        $mesArticlesRecents = Article::with(['category'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $mesMeilleursArticles = Article::with(['category'])
            ->where('user_id', $user->id)
            ->where('status', 'published')
            ->orderBy('view_count', 'desc')
            ->limit(6)
            ->get();

        $repartitionStatuts = [
            'published' => $stats['mes_articles_published'],
            'pending' => $stats['mes_articles_pending'],
            'draft' => $stats['mes_articles_drafts'],
        ];

        return view('dashboard.journalist', compact('user', 'stats', 'mesArticlesRecents', 'mesMeilleursArticles', 'repartitionStatuts'));
    }

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
            'total_views' => Article::sum('view_count'),
            'unique_visitors' => User::count() * 12 + Article::count() * 5, // Simulated data
            'bounce_rate' => 42.7, // Placeholder
        ];

        $recentArticles = Article::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $topArticles = Article::with(['user', 'category'])
            ->where('status', 'published')
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')->limit(3)->get();

        $activities = collect();
        $recentArticles->each(function ($article) use ($activities) {
            $activities->push([
                'type' => 'article',
                'description' => 'Article publié: ' . Str::limit($article->title, 30),
                'time' => $article->created_at,
                'user' => $article->user,
                'icon' => 'fa-newspaper',
                'color' => 'info'
            ]);
        });
        $recentUsers->each(function ($user) use ($activities) {
            $activities->push([
                'type' => 'user',
                'description' => 'Nouvel utilisateur: ' . $user->name,
                'time' => $user->created_at,
                'user' => $user,
                'icon' => 'fa-user-plus',
                'color' => 'success'
            ]);
        });

        $activities = $activities->sortByDesc('time');

        return view('dashboard.index', compact('user', 'stats', 'recentArticles', 'topArticles', 'activities'));
    }

    public function articles()
    {
        /** @var \App\Models\User $utilisateur */
        $utilisateur = Auth::user();
        $articlesQuery = Article::with(['category', 'user']);

        if ($utilisateur->estJournaliste()) {
            $articlesQuery->where(function($query) use ($utilisateur) {
                $query->where('user_id', $utilisateur->id)
                      ->orWhere('status', '!=', 'draft');
            });
        } else {
            $articlesQuery->where('status', '!=', 'draft');
        }

        $articles = $articlesQuery->orderBy('created_at', 'desc')->get();
        return view('dashboard.articles', compact('articles'));
    }

    public function mesArticles()
    {
        $utilisateur = Auth::user();
        $articles = Article::with(['category', 'user'])
                          ->where('user_id', $utilisateur->id)
                          ->orderBy('created_at', 'desc')
                          ->get();
        return view('dashboard.mes-articles', compact('articles'));
    }

    public function magazines()
    {
        return view('dashboard.magazines');
    }

    public function users()
    {
        return view('dashboard.users');
    }

    public function settings()
    {
        return view('dashboard.settings');
    }

    public function createArticle()
    {
        $categories = Category::where('status', 'active')->where('is_active', 1)->orderBy('sort_order')->orderBy('name')->get();
        return view('dashboard.articles.create', compact('categories'));
    }

    public function storeArticle(Request $request)
    {
        /** @var \App\Models\User $utilisateur */
        $utilisateur = Auth::user();
        $statusValidation = 'required|in:draft,published';
        if ($utilisateur->estJournaliste()) {
            $statusValidation = 'required|in:draft,pending';
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'category_id' => 'required|integer|exists:categories,id',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'sector' => 'nullable|in:agriculture,technologie,industrie,services,energie',
            'theme' => 'nullable|in:reportages,interviews,documentaires,temoignages',
            'status' => $statusValidation,
            'published_at' => 'nullable|date',
            'featured' => 'boolean',
            'is_top_article' => 'boolean',
        ]);

        if (empty($validatedData['slug'])) {
            $slug = Str::slug($validatedData['title']);
            $originalSlug = $slug;
            $counter = 1;
            while (Article::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $validatedData['slug'] = $slug;
        }

        $articleData = [
            'title' => $validatedData['title'],
            'slug' => $validatedData['slug'],
            'category_id' => $validatedData['category_id'],
            'user_id' => $utilisateur->id,
            'excerpt' => $validatedData['excerpt'],
            'content' => $validatedData['content'],
            'meta_title' => $validatedData['meta_title'] ?? null,
            'meta_description' => $validatedData['meta_description'] ?? null,
            'sector' => $validatedData['sector'] ?? null,
            'theme' => $validatedData['theme'] ?? null,
            'status' => $validatedData['status'],
            'published_at' => $validatedData['published_at'] ?? null,
            'is_featured' => $request->boolean('featured'),
            'is_top_article' => $request->boolean('is_top_article'),
            'reading_time' => $this->calculateReadingTime($validatedData['content']),
        ];

        if ($request->hasFile('featured_image')) {
            $articleData['featured_image_path'] = $this->processImage($request->file('featured_image'));
        }

        $article = Article::create($articleData);

        if ($article->is_featured) {
            $this->ensureFeaturedUniqueness($article);
        }

        return redirect()->route('dashboard.articles')->with('success', 'Article créé avec succès !');
    }

    public function editArticle($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::where('status', 'active')->where('is_active', 1)->orderBy('sort_order')->orderBy('name')->get();
        $utilisateur = Auth::user();

        if ($utilisateur->estJournaliste() && $article->user_id !== $utilisateur->id) {
            return redirect()->route('dashboard.articles')->with('error', 'Vous ne pouvez modifier que vos propres articles.');
        }

        return view('dashboard.articles.edit', compact('article', 'categories'));
    }

    public function updateArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $utilisateur = Auth::user();

        $statusValidation = 'required|in:draft,published';
        if ($utilisateur->estJournaliste()) {
            $statusValidation = 'required|in:draft,pending';
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $id,
            'category_id' => 'required|integer|exists:categories,id',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'sector' => 'nullable|in:agriculture,technologie,industrie,services,energie',
            'theme' => 'nullable|in:reportages,interviews,documentaires,temoignages',
            'status' => $statusValidation,
            'published_at' => 'nullable|date',
            'featured' => 'boolean',
            'is_top_article' => 'boolean',
        ]);

        $updateData = $validatedData;
        $updateData['is_featured'] = $request->boolean('featured');
        $updateData['is_top_article'] = $request->boolean('is_top_article');
        $updateData['reading_time'] = $this->calculateReadingTime($validatedData['content']);

        if ($request->hasFile('featured_image')) {
            $updateData['featured_image_path'] = $this->processImage($request->file('featured_image'), $article->featured_image_path);
        }

        $article->update($updateData);

        if ($article->is_featured) {
            $this->ensureFeaturedUniqueness($article);
        }

        return redirect()->route('dashboard.articles')->with('success', 'Article mis à jour avec succès !');
    }

    public function deleteArticle($id)
    {
        $utilisateur = Auth::user();
        $article = Article::findOrFail($id);

        if ($utilisateur->estJournaliste() && $article->user_id !== $utilisateur->id) {
             return redirect()->back()->with('error', 'Vous ne pouvez supprimer que vos propres articles.');
        }

        // Additional check for journalists trying to delete a published article
        if ($utilisateur->estJournaliste() && $article->status === 'published') {
            return redirect()->back()->with('error', 'Impossible de supprimer un article déjà publié.');
        }

        if ($article->featured_image_path && Storage::disk('public')->exists($article->featured_image_path)) {
            Storage::disk('public')->delete($article->featured_image_path);
        }

        $article->delete();
        return redirect()->route('dashboard.articles')->with('success', 'Article supprimé avec succès !');
    }

    public function categories()
    {
        $categories = Category::with('parent', 'user')->orderBy('sort_order')->orderBy('name')->get();
        return view('dashboard.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('dashboard.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        $slug = Str::slug($validatedData['name']);
        $validatedData['slug'] = $slug ?: 'category-' . time();
        $validatedData['user_id'] = Auth::id();
        $validatedData['sort_order'] = 0;
        $validatedData['status'] = 'active';
        $validatedData['is_active'] = 1;

        Category::create($validatedData);
        return redirect()->route('dashboard.categories.index')->with('success', 'Catégorie créée avec succès !');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'parent_id' => 'nullable|integer',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'status' => 'required|in:active,inactive'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']) ?: 'category-' . time();
        $validatedData['user_id'] = Auth::id();
        $validatedData['is_active'] = ($validatedData['status'] === 'active') ? 1 : 0;

        $category = Category::findOrFail($id);
        $category->update($validatedData);
        return redirect()->route('dashboard.categories.index')->with('success', 'Catégorie mise à jour avec succès !');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        if (Article::where('category_id', $category->id)->exists()) {
            return redirect()->back()->with('error', 'Impossible de supprimer cette catégorie car des articles y sont rattachés.');
        }
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', 'Catégorie supprimée avec succès !');
    }

    public function approveArticle($id)
    {
        /** @var \App|Models\User $utilisateur */
        $utilisateur = Auth::user();
        if (!$utilisateur->peutPublier()) {
            abort(403, 'Action non autorisée');
        }

        $article = Article::findOrFail($id);
        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Seuls les articles en attente peuvent être approuvés.');
        }

        $article->update(['status' => 'published', 'published_at' => now()]);
        return redirect()->back()->with('success', "Article '{$article->title}' approuvé et publié.");
    }

    public function rejectArticle(Request $request, $id)
    {
        /** @var \App\Models\User $utilisateur */
        $utilisateur = Auth::user();
        if (!$utilisateur->peutPublier()) {
            abort(403, 'Action non autorisée');
        }

        $article = Article::findOrFail($id);
        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Seuls les articles en attente peuvent être rejetés.');
        }

        $article->update(['status' => 'draft']);
        return redirect()->back()->with('success', "Article '{$article->title}' rejeté et renvoyé en brouillon.");
    }

    public function bulkAction(Request $request)
    {
        /** @var \App\Models\User $utilisateur */
        $utilisateur = Auth::user();
        $action = $request->input('action');
        $articleIds = $request->input('articles', []);

        if (empty($articleIds)) {
            return redirect()->back()->with('error', 'Aucun article sélectionné.');
        }

        $count = 0;
        $canPerformAction = $utilisateur->peutPublier();

        switch ($action) {
            case 'approve':
            case 'publish':
                if (!$canPerformAction) return redirect()->back()->with('error', 'Action non autorisée.');
                $count = Article::whereIn('id', $articleIds)->whereIn('status', ['draft', 'pending'])->update(['status' => 'published', 'published_at' => now()]);
                $message = "{$count} article(s) publié(s) avec succès !";
                break;
            case 'draft':
                $count = Article::whereIn('id', $articleIds)->update(['status' => 'draft']);
                $message = "{$count} article(s) mis en brouillon.";
                break;
            case 'submit':
                $query = Article::whereIn('id', $articleIds);
                if ($utilisateur->estJournaliste()) {
                    $query->where('user_id', $utilisateur->id)->where('status', '!=', 'published');
                }
                $count = $query->update(['status' => 'pending']);
                $message = "{$count} article(s) soumis pour validation.";
                break;
            case 'delete':
                $articlesToDelete = Article::whereIn('id', $articleIds)->get();
                foreach ($articlesToDelete as $article) {
                    $canDelete = $canPerformAction || (method_exists($utilisateur, 'estJournaliste') && $utilisateur->estJournaliste() && $article->user_id === $utilisateur->id && $article->status !== 'published');
                    if ($canDelete) {
                        if ($article->featured_image_path && Storage::disk('public')->exists($article->featured_image_path)) {
                            Storage::disk('public')->delete($article->featured_image_path);
                        }
                        $article->delete();
                        $count++;
                    }
                }
                $message = "{$count} article(s) supprimé(s) avec succès.";
                break;
            default:
                return redirect()->back()->with('error', 'Action non reconnue.');
        }

        return redirect()->back()->with('success', $message);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('dashboard.profile')->with('success', 'Profil mis à jour avec succès !');
    }

    public function getUsers(Request $request)
    {
        $users = User::select('id', 'name', 'email', 'role_utilisateur', 'est_actif', 'derniere_connexion')->orderBy('name')->get();
        return response()->json(['users' => $users]);
    }

    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role_utilisateur' => $user->role_utilisateur, 'est_actif' => $user->est_actif]);
    }

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
            return response()->json(['success' => true, 'message' => 'Utilisateur créé avec succès', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }

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
            return response()->json(['success' => true, 'message' => 'Utilisateur modifié avec succès', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->id === Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Vous ne pouvez pas supprimer votre propre compte.'], 400);
            }
            if ($user->role_utilisateur === 'admin' && User::where('role_utilisateur', 'admin')->count() <= 1) {
                return response()->json(['success' => false, 'message' => 'Impossible de supprimer le dernier administrateur.'], 400);
            }
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Utilisateur supprimé avec succès.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }

    private function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $readingTime = ceil($wordCount / 200);
        return max(1, $readingTime);
    }

    private function processImage($file, $oldImagePath = null)
    {
        if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        $ext = $file->getClientOriginalExtension();
        $filename = Str::uuid() . '.' . $ext;
        $relativePath = 'articles/' . $filename;
        $absolutePath = storage_path('app/public/' . $relativePath);

        $image = $this->imageManager->read($file->getRealPath());
        $image->cover(577, 523);
        $image->save($absolutePath, 85);

        return $relativePath;
    }

    private function ensureFeaturedUniqueness(Article $article)
    {
        $query = Article::where('category_id', $article->category_id)->where('id', '!=', $article->id);
        
        $category = Category::find($article->category_id);
        if ($category && strtolower($category->slug) === 'entreprises-impacts') {
            $query->where('sector', $article->sector);
        }

        $query->update(['is_featured' => 0]);
    }
}
