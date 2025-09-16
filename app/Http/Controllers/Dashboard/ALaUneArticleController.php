<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\ALaUneArticle;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ALaUneArticleController extends Controller
{
    private ImageManager $imageManager;

    public function __construct()
    {
        $this->middleware('auth');
        $this->imageManager = new ImageManager(new Driver());
    }

    public function index()
    {
        try {
            $articles = ALaUneArticle::with('category', 'user')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } catch (\Illuminate\Database\QueryException $e) {
            $articles = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
            session()->flash('error', "La table pour les articles 'À la une' n'existe pas encore. Veuillez exécuter les migrations de la base de données.");
        }

        return view('dashboard.a_la_une.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $users = User::where('est_actif', true)->orderBy('name')->get();
        return view('dashboard.a_la_une.create', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        $statusValidation = 'required|in:draft,published,pending';

        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:255|unique:a_la_une_articles,slug',
            'category_id' => 'required|integer|exists:categories,id',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'status' => $statusValidation,
            'published_at' => 'nullable|date',
            'featured' => 'boolean',
            'tags' => 'nullable|string',
            'sector' => 'nullable|string',
            'theme' => 'nullable|string',
        ]);

        if (empty($validatedData['slug'])) {
            $slug = $this->generateSlug($validatedData['title']);
            $validatedData['slug'] = $slug;
        }

        $articleData = [
            'title' => $validatedData['title'],
            'slug' => $validatedData['slug'],
            'excerpt' => $validatedData['excerpt'],
            'content' => $validatedData['content'],
            'user_id' => Auth::id(),
            'category_id' => $validatedData['category_id'],
            'status' => $validatedData['status'],
            'is_featured' => $request->boolean('featured'),
            'tags' => $validatedData['tags'],
            'sector' => $validatedData['sector'],
            'theme' => $validatedData['theme'],
            'meta_title' => $validatedData['meta_title'],
            'meta_description' => $validatedData['meta_description'],
        ];

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('a_la_une_images', 'public');
            $articleData['featured_image_path'] = $path;
        }

        if ($validatedData['status'] === 'published') {
            $articleData['published_at'] = $validatedData['published_at'] ? \Carbon\Carbon::parse($validatedData['published_at']) : now();
        }

        ALaUneArticle::create($articleData);

        return redirect()->route('dashboard.a_la_une.index')->with('success', 'Article "À la une" créé avec succès.');
    }

    public function show(ALaUneArticle $aLaUneArticle)
    {
        return view('dashboard.a_la_une.show', compact('aLaUneArticle'));
    }

    public function edit(ALaUneArticle $aLaUneArticle)
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $users = User::where('est_actif', true)->orderBy('name')->get();
        return view('dashboard.a_la_une.edit', compact('aLaUneArticle', 'categories', 'users'));
    }

    public function update(Request $request, ALaUneArticle $aLaUneArticle)
    {
        $statusValidation = 'required|in:draft,published,pending';

        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:255|unique:a_la_une_articles,slug,' . $aLaUneArticle->id,
            'category_id' => 'required|integer|exists:categories,id',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'status' => $statusValidation,
            'published_at' => 'nullable|date',
            'featured' => 'boolean',
            'tags' => 'nullable|string',
            'sector' => 'nullable|string',
            'theme' => 'nullable|string',
        ]);

        $slug = $aLaUneArticle->slug;
        if ($request->title !== $aLaUneArticle->title) {
            $slug = $this->generateSlug($request->title);
        }

        $updateData = [
            'title' => $validatedData['title'],
            'slug' => $slug,
            'excerpt' => $validatedData['excerpt'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category_id'],
            'status' => $validatedData['status'],
            'is_featured' => $request->boolean('featured'),
            'tags' => $validatedData['tags'],
            'sector' => $validatedData['sector'],
            'theme' => $validatedData['theme'],
            'meta_title' => $validatedData['meta_title'],
            'meta_description' => $validatedData['meta_description'],
        ];

        if ($request->hasFile('featured_image')) {
            if ($aLaUneArticle->featured_image_path) {
                Storage::disk('public')->delete($aLaUneArticle->featured_image_path);
            }
            $path = $request->file('featured_image')->store('a_la_une_images', 'public');
            $updateData['featured_image_path'] = $path;
        }

        if ($validatedData['status'] === 'published' && !$aLaUneArticle->published_at) {
            $updateData['published_at'] = now();
        }

        $aLaUneArticle->update($updateData);

        return redirect()->route('dashboard.a_la_une.index')->with('success', 'Article "À la une" mis à jour avec succès !');
    }

    public function destroy(ALaUneArticle $aLaUneArticle)
    {
        if ($aLaUneArticle->featured_image_path) {
            Storage::disk('public')->delete($aLaUneArticle->featured_image_path);
        }
        $aLaUneArticle->delete();

        return redirect()->route('dashboard.a_la_une.index')->with('success', 'Article "À la une" supprimé avec succès.');
    }

    private function generateSlug($title)
    {
        $slug = Str::slug($title);
        $count = ALaUneArticle::where('slug', 'LIKE', $slug . '%')->count();
        return $count > 0 ? "{$slug}-{$count}" : $slug;
    }
}
