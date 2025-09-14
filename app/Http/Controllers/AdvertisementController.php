<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdvertisementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['click', 'impression']);
        $this->middleware('verifier.role:admin,directeur_publication')->except(['click', 'impression']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advertisements = Advertisement::orderBy('priority', 'desc')
                                     ->orderBy('created_at', 'desc')
                                     ->paginate(15);
        
        return view('dashboard.advertisements.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 'active')
                             ->where('is_active', 1)
                             ->orderBy('name')
                             ->get();
                             
        return view('dashboard.advertisements.create', compact('categories'));
    }

    /**
     * Get subcategories for a given parent category
     */
    public function getSubcategories(Request $request)
    {
        $parentSlug = $request->get('parent_slug');
        
        $parent = Category::where('slug', $parentSlug)
                         ->where('status', 'active')
                         ->where('is_active', 1)
                         ->first();
        
        if (!$parent) {
            return response()->json([]);
        }
        
        $subcategories = Category::where('parent_id', $parent->id)
                                ->where('status', 'active')
                                ->where('is_active', 1)
                                ->orderBy('name')
                                ->get(['id', 'name', 'slug']);
        
        return response()->json($subcategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'url' => 'required|url|max:500',
                'page_type' => 'required|string',
                'category_slug' => 'nullable|string',
                'position_in_page' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'priority' => 'nullable|integer|min:1|max:10'
            ]);

            // Upload et redimensionnement de l'image
            $imagePath = $this->handleImageUpload($request->file('image'), $request->position_in_page);

            Advertisement::create([
                'title' => $request->title,
                'image' => $imagePath,
                'url' => $request->url,
                'page_type' => $request->page_type,
                'category_slug' => $request->category_slug,
                'position_in_page' => $request->position_in_page,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'priority' => $request->priority ?? 1,
                'status' => 'active'
            ]);

            return redirect()->route('dashboard.advertisements.index')
                            ->with('success', 'Publicité créée avec succès!');
                            
        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Erreur lors de la création de la publicité: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement)
    {
        return view('dashboard.advertisements.show', compact('advertisement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertisement $advertisement)
    {
        $categories = Category::where('status', 'active')
                             ->where('is_active', 1)
                             ->orderBy('name')
                             ->get();
                             
        return view('dashboard.advertisements.edit', compact('advertisement', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'required|url|max:500',
            'page_type' => 'required|string',
            'category_slug' => 'nullable|string',
            'position_in_page' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'priority' => 'nullable|integer|min:1|max:10',
            'status' => 'required|in:active,inactive'
        ]);

        $updateData = [
            'title' => $request->title,
            'url' => $request->url,
            'page_type' => $request->page_type,
            'category_slug' => $request->category_slug,
            'position_in_page' => $request->position_in_page,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'priority' => $request->priority ?? 1,
            'status' => $request->status
        ];

        // Si une nouvelle image est uploadée
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($advertisement->image && Storage::disk('public')->exists($advertisement->image)) {
                Storage::disk('public')->delete($advertisement->image);
            }
            
            $updateData['image'] = $this->handleImageUpload($request->file('image'), $request->position_in_page);
        } 
        // Si la position change sans nouvelle image, redimensionner l'image existante
        elseif ($request->position_in_page !== $advertisement->position_in_page && $advertisement->image) {
            $this->resizeExistingImage($advertisement, $request->position_in_page);
        }

        $advertisement->update($updateData);

        return redirect()->route('dashboard.advertisements.index')
                        ->with('success', 'Publicité mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        // Supprimer l'image
        if ($advertisement->image && Storage::disk('public')->exists($advertisement->image)) {
            Storage::disk('public')->delete($advertisement->image);
        }

        $advertisement->delete();

        return redirect()->route('dashboard.advertisements.index')
                        ->with('success', 'Publicité supprimée avec succès!');
    }

    /**
     * Toggle status of advertisement
     */
    public function toggleStatus(Advertisement $advertisement)
    {
        $advertisement->update([
            'status' => $advertisement->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->back()
                        ->with('success', 'Statut de la publicité mis à jour!');
    }

    /**
     * Click tracking
     */
    public function click($id)
    {
        \Log::info('Advertisement click tracking', [
            'ad_id' => $id,
            'timestamp' => now(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
        
        $advertisement = Advertisement::findOrFail($id);
        
        \Log::info('Advertisement found', [
            'title' => $advertisement->title,
            'url' => $advertisement->url,
            'status' => $advertisement->status,
            'is_active' => $advertisement->isCurrentlyActive(),
            'start_date' => $advertisement->start_date,
            'end_date' => $advertisement->end_date
        ]);
        
        if ($advertisement->isCurrentlyActive()) {
            $advertisement->incrementClickCount();
            
            \Log::info('Advertisement click count incremented', [
                'new_count' => $advertisement->fresh()->click_count
            ]);
            
            // Vérifier si l'URL est valide
            if (filter_var($advertisement->url, FILTER_VALIDATE_URL)) {
                \Log::info('Redirecting to advertisement URL', ['url' => $advertisement->url]);
                return redirect($advertisement->url);
            } else {
                \Log::error('Invalid advertisement URL', ['url' => $advertisement->url]);
                return redirect('/')->with('error', 'URL de destination invalide.');
            }
        }
        
        \Log::warning('Advertisement not active', [
            'status' => $advertisement->status,
            'is_currently_active' => $advertisement->isCurrentlyActive()
        ]);
        
        return redirect('/')->with('error', 'Publicité expirée ou inactive.');
    }

    /**
     * Track advertisement impression (view)
     */
    public function impression($id)
    {
        $advertisement = Advertisement::find($id);

        if ($advertisement && $advertisement->isCurrentlyActive()) {
            $advertisement->incrementImpressionCount();

            return response()->json([
                'success' => true,
                'impression_count' => $advertisement->fresh()->impression_count
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    /**
     * Handle image upload and resizing
     */
    private function handleImageUpload($image, $position)
    {
        $filename = 'ad_' . time() . '.' . $image->getClientOriginalExtension();
        
        // Définir les dimensions selon la position
        $dimensions = $this->getImageDimensions($position);
        
        try {
            // Créer le manager d'image avec le driver GD
            $manager = new ImageManager(new Driver());
            
            // Créer et redimensionner l'image
            $img = $manager->read($image->getRealPath());
            $img = $img->resize($dimensions['width'], $dimensions['height']);
            
            // Sauvegarder
            $path = 'advertisements/' . $filename;
            Storage::disk('public')->put($path, (string) $img->encode());
            
            return $path;
        } catch (\Exception $e) {
            // En cas d'erreur avec Intervention Image, on sauvegarde l'image sans redimensionnement
            $path = 'advertisements/' . $filename;
            $image->storeAs('advertisements', $filename, 'public');
            return $path;
        }
    }

    /**
     * Get image dimensions based on position
     */
    private function getImageDimensions($position)
    {
        $dimensions = [
            'top_banner' => ['width' => 730, 'height' => 90],
            'sidebar' => ['width' => 300, 'height' => 250],
            'middle' => ['width' => 728, 'height' => 90],
            'bottom' => ['width' => 970, 'height' => 250]
        ];
        
        return $dimensions[$position] ?? $dimensions['sidebar'];
    }

    /**
     * Resize existing image for new position
     */
    private function resizeExistingImage($advertisement, $newPosition)
    {
        try {
            $imagePath = Storage::disk('public')->path($advertisement->image);
            
            if (!file_exists($imagePath)) {
                return; // Image n'existe pas, ne rien faire
            }
            
            // Définir les nouvelles dimensions
            $dimensions = $this->getImageDimensions($newPosition);
            
            // Créer le manager d'image avec le driver GD
            $manager = new ImageManager(new Driver());
            
            // Charger et redimensionner l'image existante
            $img = $manager->read($imagePath);
            $img = $img->resize($dimensions['width'], $dimensions['height']);
            
            // Sauvegarder par-dessus l'image existante
            Storage::disk('public')->put($advertisement->image, (string) $img->encode());
            
        } catch (\Exception $e) {
            // En cas d'erreur, on ne fait rien (garde l'image originale)
            // Optionnel: log l'erreur
        }
    }
}
