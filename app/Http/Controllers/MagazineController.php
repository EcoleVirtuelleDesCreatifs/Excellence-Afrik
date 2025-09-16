<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Schema;

class MagazineController extends Controller
{
    private ImageManager $imageManager;

    public function __construct()
    {
        $this->middleware('auth')->except(['publicIndex']);
        $this->imageManager = new ImageManager(new Driver());
    }

    public function index()
    {
        if (!Schema::hasTable('magazines')) {
            // Table not migrated yet; show page without crashing
            $magazines = collect();
            return view('dashboard.magazines', compact('magazines'))
                ->with('warning', "La table 'magazines' n'existe pas encore. Veuillez exécuter la migration.");
        }
        $magazines = Magazine::orderByDesc('published_at')->orderByDesc('created_at')->paginate(20);
        return view('dashboard.magazines', compact('magazines'));
    }

    public function create()
    {
        return view('dashboard.magazines-create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:255|unique:magazines,slug',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'status' => 'required|string|in:draft,published',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'pdf' => 'nullable|mimes:pdf|max:20480',
            'is_featured' => 'nullable|boolean',
        ]);

        $magazine = new Magazine();
        $magazine->title = $data['title'];
        $magazine->slug = $data['slug'] ?? Magazine::generateUniqueSlug($data['title']);
        $magazine->description = $data['description'] ?? null;
        $magazine->published_at = $data['published_at'] ?? now()->toDateString();
        $magazine->status = $data['status'];
        $magazine->is_featured = $request->boolean('is_featured');

        // Handle files
        if ($request->hasFile('cover')) {
            [$coverPath, $thumbPath] = $this->processCover($request->file('cover'));
            $magazine->cover_path = $coverPath;
            $magazine->cover_thumb_path = $thumbPath;
        }
        if ($request->hasFile('pdf')) {
            $magazine->pdf_path = $request->file('pdf')->store('magazines/pdfs', 'public');
        }

        // Enforce single featured (on create: unset all others if checked)
        if ($magazine->is_featured) {
            Magazine::where('is_featured', true)->update(['is_featured' => false]);
        }

        $magazine->save();

        return redirect()->route('dashboard.magazines.index')->with('success', 'Magazine créé avec succès.');
    }

    public function edit($id)
    {
        $magazine = Magazine::findOrFail($id);
        return view('dashboard.magazines-edit', compact('magazine'));
    }

    public function update(Request $request, $id)
    {
        $magazine = Magazine::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:255|unique:magazines,slug,' . $magazine->id,
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'status' => 'required|string|in:draft,published',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'pdf' => 'nullable|mimes:pdf|max:20480',
            'is_featured' => 'nullable|boolean',
        ]);

        $magazine->title = $data['title'];
        $magazine->slug = $data['slug'] ?? $magazine->slug;
        $magazine->description = $data['description'] ?? null;
        $magazine->published_at = $data['published_at'] ?? null;
        $magazine->status = $data['status'];
        $magazine->is_featured = $request->boolean('is_featured');
        $magazine->is_featured = $request->boolean('is_featured');

        if ($request->hasFile('cover')) {
            // Delete old files
            if ($magazine->cover_path) Storage::disk('public')->delete($magazine->cover_path);
            if ($magazine->cover_thumb_path) Storage::disk('public')->delete($magazine->cover_thumb_path);
            [$coverPath, $thumbPath] = $this->processCover($request->file('cover'));
            $magazine->cover_path = $coverPath;
            $magazine->cover_thumb_path = $thumbPath;
        }
        if ($request->hasFile('pdf')) {
            if ($magazine->pdf_path) Storage::disk('public')->delete($magazine->pdf_path);
            $magazine->pdf_path = $request->file('pdf')->store('magazines/pdfs', 'public');
        }

        $magazine->save();

        return redirect()->route('dashboard.magazines.index')->with('success', 'Magazine mis à jour.');
    }

    public function destroy($id)
    {
        $magazine = Magazine::findOrFail($id);
        if ($magazine->cover_path) Storage::disk('public')->delete($magazine->cover_path);
        if ($magazine->cover_thumb_path) Storage::disk('public')->delete($magazine->cover_thumb_path);
        if ($magazine->pdf_path) Storage::disk('public')->delete($magazine->pdf_path);
        $magazine->delete();
        return redirect()->route('dashboard.magazines.index')->with('success', 'Magazine supprimé.');
    }

    // Public listing
    public function publicIndex()
    {
        if (!Schema::hasTable('magazines')) {
            $magazines = collect();
            return view('magazines.index', compact('magazines'));
        }
        $featured = Magazine::where('status', 'published')
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->first();

        $magazines = Magazine::where('status', 'published')
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(12);
        return view('magazines.index', compact('magazines', 'featured'));
    }

    public function publicShow($slug)
    {
        // This method will now behave like the index page, as requested.
        if (!Schema::hasTable('magazines')) {
            $magazines = collect();
            return view('magazines.index', compact('magazines'));
        }
        $featured = \App\Models\Magazine::where('status', 'published')
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->first();

        $magazines = \App\Models\Magazine::where('status', 'published')
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('magazines.index', compact('magazines', 'featured'));
    }

    private function processCover($file): array
    {
        $dir = 'magazines/covers';
        $dirThumb = 'magazines/covers/thumbs';
        $filename = Str::random(16) . '.webp';
        $filenameThumb = Str::random(16) . '.webp';

        // Original (convert to webp, keep aspect)
        $image = $this->imageManager->read($file->getRealPath())
            ->toWebp(85);
        Storage::disk('public')->put($dir . '/' . $filename, (string) $image);

        // Thumb 279x377 exact, cover
        $thumb = $this->imageManager->read($file->getRealPath())
            ->cover(279, 377)
            ->toWebp(85);
        Storage::disk('public')->put($dirThumb . '/' . $filenameThumb, (string) $thumb);

        return [$dir . '/' . $filename, $dirThumb . '/' . $filenameThumb];
    }
}
