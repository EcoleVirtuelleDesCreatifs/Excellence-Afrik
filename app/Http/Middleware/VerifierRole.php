<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifierRole
{
    /**
     * Vérifier les permissions d'accès selon le rôle de l'utilisateur
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $rolesAutorises Rôles autorisés séparés par des pipes (ex: 'admin|directeur_publication')
     */
    public function handle(Request $request, Closure $next, string $rolesAutorises = ''): Response
    {
        // Vérifier que l'utilisateur est authentifié
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page');
        }

        $utilisateur = auth()->user();

        // Vérifier que l'utilisateur est actif
        if (!$utilisateur->est_actif) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Votre compte a été désactivé. Contactez l\'administrateur.');
        }

        // Mettre à jour la dernière connexion
        $utilisateur->mettreAJourDerniereConnexion();

        // Si aucun rôle spécifié, laisser passer (protection basique auth uniquement)
        if (empty($rolesAutorises)) {
            return $next($request);
        }

        // Convertir la chaîne de rôles en tableau
        $rolesArray = explode('|', $rolesAutorises);

        // Vérifier si l'utilisateur a un des rôles autorisés
        if (in_array($utilisateur->role_utilisateur, $rolesArray)) {
            return $next($request);
        }

        // Accès refusé - redirection selon le rôle de l'utilisateur
        $messageErreur = match($utilisateur->role_utilisateur) {
            'journaliste' => 'Accès restreint. Cette fonctionnalité nécessite des permissions administratives.',
            'directeur_publication' => 'Accès réservé aux super-administrateurs.',
            default => 'Permissions insuffisantes pour accéder à cette ressource.'
        };

        // Si c'est une requête AJAX, retourner JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $messageErreur
            ], 403);
        }

        // Sinon, rediriger vers le dashboard avec message d'erreur
        return redirect()->route('dashboard')->with('error', $messageErreur);
    }
}
