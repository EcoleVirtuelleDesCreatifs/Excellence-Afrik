<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webtv extends Model
{
    use HasFactory;

    protected $table = 'webtvs';

    protected $guarded = [];

    protected $casts = [
        'est_actif' => 'boolean',
        'date_programmee' => 'datetime',
    ];

    // Accessors used in the Blade
    public function getStatutCouleurAttribute(): string
    {
        return match ($this->statut) {
            'en_direct' => 'live',
            'programme' => 'scheduled',
            'termine' => 'archived',
            default => 'draft',
        };
    }

    public function getStatutFormatteAttribute(): string
    {
        return match ($this->statut) {
            'en_direct' => 'En Direct',
            'programme' => $this->type_programme === 'programme' ? 'Publié' : 'Programmé',
            'termine' => 'Terminé',
            default => 'Brouillon',
        };
    }

    public function getDateProgrammeeFormateeAttribute(): ?string
    {
        if (!$this->date_programmee) return null;
        return Carbon::parse($this->date_programmee)->locale('fr')->translatedFormat('d M Y, H:i');
    }

    public function getDureeEstimeeFormateeAttribute(): ?string
    {
        if (!$this->duree_estimee) return null;
        $min = (int) $this->duree_estimee;
        $h = intdiv($min, 60);
        $m = $min % 60;
        return $h > 0 ? sprintf('%dh %02d', $h, $m) : sprintf('%d min', $m);
    }

    // Helpers for alerts
    public function estEnRetard(): bool
    {
        return $this->statut === 'programme' && $this->date_programmee && Carbon::parse($this->date_programmee)->isPast();
    }

    public function estProgrammePourAujourdhui(): bool
    {
        if (!$this->date_programmee) return false;
        $d = Carbon::parse($this->date_programmee);
        return $d->isToday();
    }
}
