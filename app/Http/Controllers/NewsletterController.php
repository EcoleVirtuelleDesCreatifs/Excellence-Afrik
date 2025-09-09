<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['subscribe', 'unsubscribe', 'verify']);
    }

    /**
     * Inscription newsletter (public)
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:191',
            'name' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:50',
            'premium' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', '⚠️ Veuillez vérifier votre adresse email. Elle doit être valide pour recevoir nos newsletters.');
        }

        $email = $request->email;
        $source = $request->source ?? 'website';
        
        // Vérifier si l'email existe déjà
        $existing = NewsletterSubscriber::where('email', $email)->first();
        
        if ($existing) {
            if ($existing->is_active) {
                return redirect()->back()->with('info', '📧 Vous êtes déjà abonné(e) à notre newsletter ! Vérifiez votre boîte email pour nos dernières actualités.');
            } else {
                // Réactiver l'abonnement
                $existing->resubscribe();
                return redirect()->back()->with('success', '🎉 Bienvenue à nouveau ! Votre abonnement à la newsletter Excellence Afrik a été réactivé avec succès.');
            }
        }

        // Créer nouvel abonné
        try {
            $subscriber = NewsletterSubscriber::create([
                'email' => $email,
                'name' => $request->name,
                'source' => $source,
                'is_premium' => $request->boolean('premium', false),
                'email_verified_at' => now(), // Auto-vérification pour simplifier
            ]);

            // Message personnalisé selon le type d'abonnement
            $message = $subscriber->is_premium 
                ? '🎉 Félicitations ! Vous êtes maintenant abonné(e) à notre newsletter Premium. Profitez de contenus exclusifs et d\'analyses approfondies sur l\'économie africaine !'
                : '✅ Merci pour votre inscription ! Vous recevrez désormais nos meilleures actualités économiques africaines directement dans votre boîte email.';
            
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Newsletter subscription error: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ Une erreur est survenue lors de l\'inscription. Notre équipe technique a été notifiée. Veuillez réessayer dans quelques instants.');
        }
    }

    /**
     * Désabonnement (public)
     */
    public function unsubscribe(Request $request, $token)
    {
        $subscriber = NewsletterSubscriber::where('unsubscribe_token', $token)->first();
        
        if (!$subscriber) {
            return redirect('/')->with('error', 'Lien de désabonnement invalide.');
        }

        if ($subscriber->is_active) {
            $subscriber->unsubscribe();
            $message = 'Vous avez été désabonné(e) avec succès de notre newsletter.';
        } else {
            $message = 'Vous êtes déjà désabonné(e) de notre newsletter.';
        }

        return view('newsletter.unsubscribed', compact('subscriber', 'message'));
    }

    /**
     * Vérification email (public)
     */
    public function verify(Request $request, $token)
    {
        $subscriber = NewsletterSubscriber::where('verification_token', $token)->first();
        
        if (!$subscriber) {
            return redirect('/')->with('error', 'Lien de vérification invalide.');
        }

        if (!$subscriber->isVerified()) {
            $subscriber->verify();
            $message = 'Votre email a été vérifié avec succès !';
        } else {
            $message = 'Votre email est déjà vérifié.';
        }

        return view('newsletter.verified', compact('subscriber', 'message'));
    }

    // === ADMIN DASHBOARD METHODS ===

    /**
     * Dashboard - Liste des abonnés
     */
    public function index(Request $request)
    {
        $this->checkPermission();

        $query = NewsletterSubscriber::query();

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active()->verified();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'pending') {
                $query->whereNull('email_verified_at');
            }
        }

        $subscribers = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statistiques
        $stats = [
            'total' => NewsletterSubscriber::count(),
            'active' => NewsletterSubscriber::active()->count(),
            'verified' => NewsletterSubscriber::verified()->count(),
            'premium' => NewsletterSubscriber::premium()->active()->count(),
        ];

        // Sources
        $sources = NewsletterSubscriber::select('source')
            ->selectRaw('count(*) as count')
            ->groupBy('source')
            ->pluck('count', 'source')
            ->toArray();

        return view('dashboard.newsletter.index', compact('subscribers', 'stats', 'sources'));
    }

    /**
     * Voir détails d'un abonné
     */
    public function show($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $this->checkPermission();

        return response()->json([
            'id' => $subscriber->id,
            'email' => $subscriber->email,
            'name' => $subscriber->name,
            'source' => $subscriber->source,
            'source_label' => $subscriber->source_label,
            'is_premium' => $subscriber->is_premium,
            'is_active' => $subscriber->is_active,
            'status' => $subscriber->status,
            'subscribed_at' => $subscriber->subscribed_at?->format('d/m/Y H:i'),
            'unsubscribed_at' => $subscriber->unsubscribed_at?->format('d/m/Y H:i'),
            'email_verified_at' => $subscriber->email_verified_at?->format('d/m/Y H:i'),
            'created_at' => $subscriber->created_at->format('d/m/Y H:i'),
        ]);
    }

    /**
     * Créer un abonné manuellement
     */
    public function store(Request $request)
    {
        $this->checkPermission();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:191|unique:newsletter_subscribers,email',
            'name' => 'nullable|string|max:255',
            'is_premium' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $subscriber = NewsletterSubscriber::create([
                'email' => $request->email,
                'name' => $request->name,
                'source' => 'manual',
                'is_premium' => $request->boolean('is_premium', false),
                'email_verified_at' => now(), // Auto-vérifié pour ajout manuel
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Abonné ajouté avec succès',
                'subscriber' => $subscriber
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Modifier un abonné
     */
    public function update(Request $request, $id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $this->checkPermission();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:191|unique:newsletter_subscribers,email,' . $id,
            'name' => 'nullable|string|max:255',
            'is_premium' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $subscriber->update([
                'email' => $request->email,
                'name' => $request->name,
                'is_premium' => $request->boolean('is_premium'),
                'is_active' => $request->boolean('is_active'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Abonné modifié avec succès',
                'subscriber' => $subscriber
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un abonné
     */
    public function destroy($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $this->checkPermission();

        try {
            $subscriber->delete();

            return response()->json([
                'success' => true,
                'message' => 'Abonné supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export des abonnés
     */
    public function export(Request $request)
    {
        $this->checkPermission();

        $query = NewsletterSubscriber::query();

        // Appliquer les mêmes filtres que l'index
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active()->verified();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $subscribers = $query->orderBy('created_at', 'desc')->get();

        $filename = 'newsletter_subscribers_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'Email',
                'Nom',
                'Source',
                'Premium',
                'Statut',
                'Date d\'inscription',
                'Dernière activité'
            ]);

            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->email,
                    $subscriber->name,
                    $subscriber->source_label,
                    $subscriber->is_premium ? 'Oui' : 'Non',
                    $subscriber->status,
                    $subscriber->subscribed_at?->format('d/m/Y H:i'),
                    $subscriber->updated_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Vérifier les autorisations avec une méthode personnalisée
     */
    private function checkPermission()
    {
        // Pour simplifier, on vérifie juste si l'utilisateur est admin ou directeur
        $user = Auth::user();
        if (!$user || (!$user->estAdmin() && !$user->estDirecteurPublication())) {
            abort(403, 'Accès non autorisé');
        }
    }
}
