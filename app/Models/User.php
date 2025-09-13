<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Article;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_utilisateur',
        'est_actif',
        'derniere_connexion',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'derniere_connexion' => 'datetime',
            'est_actif' => 'boolean',
        ];
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    public function estAdmin(): bool
    {
        return $this->role_utilisateur === 'admin';
    }

    public function estDirecteurPublication(): bool
    {
        return $this->role_utilisateur === 'directeur_publication';
    }

    public function estJournaliste(): bool
    {
        return $this->role_utilisateur === 'journaliste';
    }

    public function peutPublier(): bool
    {
        return $this->estAdmin() || $this->estDirecteurPublication();
    }

    public function peutGererUtilisateurs(): bool
    {
        return $this->estAdmin() || $this->estDirecteurPublication();
    }

    public function peutAccederParametres(): bool
    {
        return $this->estAdmin();
    }

    public function peutVoirAnalyticsCompletes(): bool
    {
        return $this->estAdmin() || $this->estDirecteurPublication();
    }

    public function peutModifierArticle(Article $article): bool
    {
        if ($this->estAdmin() || $this->estDirecteurPublication()) {
            return true;
        }
        
        if ($this->estJournaliste()) {
            return $article->user_id === $this->id;
        }
        
        return false;
    }

    public function peutModifierWebtv($webtv): bool
    {
        if ($this->estAdmin() || $this->estDirecteurPublication()) {
            return true;
        }
        
        if ($this->estJournaliste()) {
            return true;
        }
        
        return false;
    }

    public function getNomRoleAttribute(): string
    {
        return match($this->role_utilisateur) {
            'admin' => 'Administrateur',
            'directeur_publication' => 'Directeur de Publication',
            'journaliste' => 'Journaliste',
            default => 'Inconnu',
        };
    }

    public function mettreAJourDerniereConnexion(): void
    {
        $this->update(['derniere_connexion' => now()]);
    }
}
