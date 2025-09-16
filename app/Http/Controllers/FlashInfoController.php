<?php

namespace App\Http\Controllers;

use App\Models\FlashInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FlashInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flashInfos = FlashInfo::orderBy('ordre')->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.flash-infos.index', compact('flashInfos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.flash-infos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:200',
            'statut' => 'required|in:actif,inactif',
            'ordre' => 'nullable|integer|min:0',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);

        try {
            FlashInfo::create([
                'titre' => $request->titre,
                'statut' => $request->statut,
                'ordre' => $request->ordre ?? 0,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
            ]);

            return redirect()->route('dashboard.flash-infos.index')
                           ->with('success', 'Flash Info créée avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur création Flash Info : ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Erreur lors de la création de la Flash Info')
                           ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FlashInfo $flashInfo)
    {
        return view('dashboard.flash-infos.show', compact('flashInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FlashInfo $flashInfo)
    {
        return view('dashboard.flash-infos.edit', compact('flashInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FlashInfo $flashInfo)
    {
        $request->validate([
            'titre' => 'required|string|max:200',
            'statut' => 'required|in:actif,inactif',
            'ordre' => 'nullable|integer|min:0',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);

        try {
            $flashInfo->update([
                'titre' => $request->titre,
                'statut' => $request->statut,
                'ordre' => $request->ordre ?? 0,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
            ]);

            return redirect()->route('dashboard.flash-infos.index')
                           ->with('success', 'Flash Info mise à jour avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour Flash Info : ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Erreur lors de la mise à jour de la Flash Info')
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FlashInfo $flashInfo)
    {
        try {
            $flashInfo->delete();
            return redirect()->route('dashboard.flash-infos.index')
                           ->with('success', 'Flash Info supprimée avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur suppression Flash Info : ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Erreur lors de la suppression de la Flash Info');
        }
    }

    /**
     * Toggle le statut d'une Flash Info
     */
    public function toggleStatut(FlashInfo $flashInfo)
    {
        try {
            $nouveauStatut = $flashInfo->statut === 'actif' ? 'inactif' : 'actif';
            $flashInfo->update(['statut' => $nouveauStatut]);

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès',
                'nouveau_statut' => $nouveauStatut
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur toggle statut Flash Info : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut'
            ], 500);
        }
    }
}
