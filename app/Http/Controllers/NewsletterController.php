<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
    public function index()
    {
        $subscribers = NewsletterSubscriber::orderBy('created_at', 'desc')->paginate(20);
        return view('dashboard.newsletter.index', compact('subscribers'));
    }
}
