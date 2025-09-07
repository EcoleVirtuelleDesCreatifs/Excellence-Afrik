<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_utilisateur',
        'est_actif',
        'derniere_connexion',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'derniere_connexion' => 'datetime',
            'est_actif' => 'boolean',
        ];
    }

    // ========== MÉTHODES HELPER POUR LES RÔLES ==========

    /**
     * Vérifier si l'utilisateur est un administrateur
     */
    public function estAdmin(): bool
    {
        return $this->role_utilisateur === 'admin';
    }

    /**
     * Vérifier si l'utilisateur est directeur de publication
     */
    public function estDirecteurPublication(): bool
    {
        return $this->role_utilisateur === 'directeur_publication';
    }

    /**
     * Vérifier si l'utilisateur est journaliste
     */
    public function estJournaliste(): bool
    {
        return $this->role_utilisateur === 'journaliste';
    }

    /**
     * Vérifier si l'utilisateur peut publier des articles
     */
    public function peutPublier(): bool
    {
        return $this->estAdmin() || $this->estDirecteurPublication();
    }

    /**
     * Vérifier si l'utilisateur peut gérer les autres utilisateurs
     */
    public function peutGererUtilisateurs(): bool
    {
        return $this->estAdmin() || $this->estDirecteurPublication();
    }

    /**
     * Vérifier si l'utilisateur peut accéder aux paramètres système
     */
    public function peutAccederParametres(): bool
    {
        return $this->estAdmin();
    }

    /**
     * Vérifier si l'utilisateur peut voir les analytics complètes
     */
    public function peutVoirAnalyticsCompletes(): bool
    {
        return $this->estAdmin() || $this->estDirecteurPublication();
    }

    /**
     * Obtenir le nom du rôle en français
     */
    public function getNomRoleAttribute(): string
    {
        return match($this->role_utilisateur) {
            'admin' => 'Administrateur',
            'directeur_publication' => 'Directeur de Publication',
            'journaliste' => 'Journaliste',
            default => 'Inconnu',
        };
    }

    /**
     * Mettre à jour la dernière connexion
     */
    public function mettreAJourDerniereConnexion(): void
    {
        $this->update(['derniere_connexion' => now()]);
    }
}
