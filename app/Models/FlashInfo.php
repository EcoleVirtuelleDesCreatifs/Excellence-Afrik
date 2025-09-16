<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FlashInfo extends Model
{
    protected $fillable = [
        'titre',
        'statut',
        'ordre',
        'date_debut',
        'date_fin'
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    // Scope pour les flash infos actives
    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    // Scope pour les flash infos valides (dans la période)
    public function scopeValide($query)
    {
        $now = Carbon::now();
        return $query->where(function($q) use ($now) {
            $q->where(function($q2) use ($now) {
                // Date début nulle OU date début passée
                $q2->whereNull('date_debut')
                   ->orWhere('date_debut', '<=', $now);
            })->where(function($q3) use ($now) {
                // Date fin nulle OU date fin future
                $q3->whereNull('date_fin')
                   ->orWhere('date_fin', '>=', $now);
            });
        });
    }

    // Scope pour les flash infos à afficher (actives + valides)
    public function scopeAffichage($query)
    {
        return $query->actif()->valide()->orderBy('ordre')->orderBy('created_at', 'desc');
    }
}
