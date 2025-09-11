<?php

namespace App\Http\Controllers;

use App\Models\Webtv;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class WebtvController extends Controller
{
    public function index()
    {
        $utilisateur = Auth::user();
        
        // Récupération des webtvs - tous les utilisateurs voient toutes les webtvs
        // (La table webtvs n'a pas de colonne user_id)
        $webtvQuery = Webtv::query();
        
        $webtvs = $webtvQuery->latest('created_at')->paginate(12);
        return view('webtv.index', compact('webtvs'));
    }

    public function store(Request $request)
    {
        $type = $request->input('type_programme', 'programme');

        $rules = [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'duree_estimee' => ['nullable', 'integer', 'min:1', 'max:600'],
            'statut' => ['required', 'in:draft,programme,en_direct,termine'],
            'est_actif' => ['nullable', 'boolean'],
            'type_programme' => ['required', 'in:live,programme'],
        ];

        if ($type === 'programme') {
            $rules['categorie'] = ['required', 'in:debates,interviews,reportages,documentaires,general'];
            $rules['code_integration_vimeo'] = ['required', 'string'];
        } else {
            $rules['date_programmee'] = ['nullable', 'date'];
            $rules['code_embed_vimeo'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        $payload = [
            'type_programme' => $type,
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'duree_estimee' => $validated['duree_estimee'] ?? null,
            'statut' => $validated['statut'],
            'est_actif' => (bool) ($request->boolean('est_actif')),
            'date_programmee' => $validated['date_programmee'] ?? null,
            'categorie' => $validated['categorie'] ?? null,
        ];

        if ($type === 'programme') {
            $code = $validated['code_integration_vimeo'] ?? '';
            if (!(Str::contains($code, 'vimeo.com/video/') && Str::contains($code, 'iframe'))) {
                return back()->withErrors(['code_integration_vimeo' => "Code d'intégration Vimeo invalide (iframe attendu)"])->withInput();
            }
            $payload['code_integration_vimeo'] = $code;
            // Extract video_id
            if (preg_match('/vimeo\\.com\/video\/(\d+)/', $code, $m)) {
                $payload['video_id'] = $m[1];
            }
        } else {
            $code = $validated['code_embed_vimeo'] ?? '';
            if (!Str::contains($code, 'vimeo.com')) {
                return back()->withErrors(['code_embed_vimeo' => 'Code embed Vimeo invalide'])->withInput();
            }
            $payload['code_embed_vimeo'] = $code;
            // Extract event id if present
            if (preg_match('/vimeo\\.com\/event\/(\d+)/', $code, $m)) {
                $payload['vimeo_event_id'] = $m[1];
            }
        }

        Webtv::create($payload);

        $label = $type === 'live' ? 'Live' : 'Programme';
        return redirect()->route('dashboard.webtv.index')->with('status', "$label créé avec succès");
    }

    public function previewEmbed(Request $request)
    {
        $code = $request->input('code_embed');
        if (!$code) {
            return response()->json(['valide' => false, 'message' => 'Aucun code fourni']);
        }
        preg_match('/(vimeo\\.com\/event\/(\\d+)|vimeo\\.com\/video\/(\\d+))/', $code, $m);
        $id = $m[2] ?? ($m[3] ?? null);

        return response()->json([
            'valide' => true,
            'url_vimeo' => $id ? "https://vimeo.com/$id" : 'Détecté',
            'event_id' => $id,
            'code_embed' => $code,
            'html' => $code,
        ]);
    }

    public function edit(Webtv $webtv)
    {
        $utilisateur = Auth::user();
        
        // Vérification des permissions d'édition
        if (!$utilisateur->peutModifierWebtv($webtv)) {
            abort(403, 'Vous ne pouvez modifier que vos propres événements WebTV.');
        }
        
        return view('webtv.edit', compact('webtv'));
    }

    public function update(Request $request, Webtv $webtv)
    {
        $utilisateur = Auth::user();
        
        // Vérification des permissions d'édition
        if (!$utilisateur->peutModifierWebtv($webtv)) {
            abort(403, 'Vous ne pouvez modifier que vos propres événements WebTV.');
        }
        
        $type = $request->input('type_programme', $webtv->type_programme);

        $rules = [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'duree_estimee' => ['nullable', 'integer', 'min:1', 'max:600'],
            'statut' => ['required', 'in:draft,programme,en_direct,termine'],
            'est_actif' => ['nullable', 'boolean'],
            'type_programme' => ['required', 'in:live,programme'],
        ];

        if ($type === 'programme') {
            $rules['categorie'] = ['required', 'in:debates,interviews,reportages,documentaires,general'];
            $rules['code_integration_vimeo'] = ['nullable', 'string'];
        } else {
            $rules['date_programmee'] = ['nullable', 'date'];
            $rules['code_embed_vimeo'] = ['nullable', 'string'];
        }

        $validated = $request->validate($rules);

        $payload = [
            'type_programme' => $validated['type_programme'] ?? $type,
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'duree_estimee' => $validated['duree_estimee'] ?? null,
            'statut' => $validated['statut'],
            'est_actif' => (bool) ($request->boolean('est_actif')),
            'date_programmee' => $validated['date_programmee'] ?? null,
            'categorie' => $validated['categorie'] ?? null,
        ];

        if ($type === 'programme') {
            $code = $validated['code_integration_vimeo'] ?? $webtv->code_integration_vimeo;
            if ($code && !(Str::contains($code, 'vimeo.com/video/') && Str::contains($code, 'iframe'))) {
                return back()->withErrors(['code_integration_vimeo' => "Code d'intégration Vimeo invalide (iframe attendu)"])->withInput();
            }
            $payload['code_integration_vimeo'] = $code;
            if ($code && preg_match('/vimeo\\.com\/video\/(\d+)/', $code, $m)) {
                $payload['video_id'] = $m[1];
            }
            // Clear live fields if switching type
            if ($webtv->type_programme === 'live') {
                $payload['code_embed_vimeo'] = null;
                $payload['vimeo_event_id'] = null;
            }
        } else {
            $code = $validated['code_embed_vimeo'] ?? $webtv->code_embed_vimeo;
            if ($code && !Str::contains($code, 'vimeo.com')) {
                return back()->withErrors(['code_embed_vimeo' => 'Code embed Vimeo invalide'])->withInput();
            }
            $payload['code_embed_vimeo'] = $code;
            if ($code && preg_match('/vimeo\\.com\/event\/(\d+)/', $code, $m)) {
                $payload['vimeo_event_id'] = $m[1];
            } else {
                $payload['vimeo_event_id'] = null;
            }
            // Clear programme fields if switching type
            if ($webtv->type_programme === 'programme') {
                $payload['code_integration_vimeo'] = null;
                $payload['video_id'] = null;
                $payload['categorie'] = null;
            }
        }

        $webtv->update($payload);

        return redirect()->route('dashboard.webtv.index')->with('status', 'WebTV mis à jour');
    }

    public function destroy(Webtv $webtv)
    {
        $utilisateur = Auth::user();
        
        // Vérification des permissions de suppression
        if (!$utilisateur->peutModifierWebtv($webtv)) {
            abort(403, 'Vous ne pouvez supprimer que vos propres événements WebTV.');
        }
        
        $webtv->delete();
        return redirect()->route('dashboard.webtv.index')->with('status', 'WebTV supprimé');
    }

    public function toggleActif(Webtv $webtv)
    {
        $webtv->est_actif = !$webtv->est_actif;
        $webtv->save();
        return response()->json([
            'succes' => true,
            'est_actif' => $webtv->est_actif,
            'message' => $webtv->est_actif ? 'Activé' : 'Désactivé',
        ]);
    }

    public function changerStatut(Request $request, Webtv $webtv)
    {
        $validated = $request->validate([
            'statut' => ['required', 'in:draft,programme,en_direct,termine'],
        ]);
        $webtv->statut = $validated['statut'];
        $webtv->save();
        return response()->json(['ok' => true]);
    }
}
