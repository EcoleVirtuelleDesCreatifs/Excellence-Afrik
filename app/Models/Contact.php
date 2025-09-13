<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'nom',
        'email',
        'objet',
        'message',
        'statut',
        'date_lecture',
        'notes_admin',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'date_lecture' => 'datetime',
    ];

    // Scopes pour faciliter les requêtes
    public function scopeNouveaux($query)
    {
        return $query->where('statut', 'nouveau');
    }

    public function scopeLus($query)
    {
        return $query->where('statut', 'lu');
    }

    public function scopeTraites($query)
    {
        return $query->where('statut', 'traite');
    }

    public function scopeArchives($query)
    {
        return $query->where('statut', 'archive');
    }

    // Méthodes utilitaires
    public function marquerCommeLu()
    {
        $this->update([
            'statut' => 'lu',
            'date_lecture' => now()
        ]);
    }

    public function marquerCommeTraite()
    {
        $this->update(['statut' => 'traite']);
    }

    public function archiver()
    {
        $this->update(['statut' => 'archive']);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'nouveau' => 'success',
            'lu' => 'info',
            'traite' => 'warning',
            'archive' => 'secondary'
        ];

        return $badges[$this->statut] ?? 'secondary';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'nouveau' => 'Nouveau',
            'lu' => 'Lu',
            'traite' => 'Traité',
            'archive' => 'Archivé'
        ];

        return $labels[$this->statut] ?? 'Inconnu';
    }
}
