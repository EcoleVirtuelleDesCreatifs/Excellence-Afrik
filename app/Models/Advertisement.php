<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Advertisement extends Model
{
    protected $fillable = [
        'title',
        'image',
        'url',
        'page_type',
        'category_slug',
        'position_in_page',
        'status',
        'click_count',
        'impression_count',
        'start_date',
        'end_date',
        'priority'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Scope pour récupérer les publicités actives
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    // Scope pour récupérer les publicités par page et position
    public function scopeForPosition($query, $pageType, $categorySlug = null, $position = null)
    {
        $query = $query->where('page_type', $pageType);
        
        if ($categorySlug) {
            $query->where('category_slug', $categorySlug);
        }
        
        if ($position) {
            $query->where('position_in_page', $position);
        }
        
        return $query->orderBy('priority', 'desc')
                    ->orderBy('created_at', 'desc');
    }

    // Incrémenter le compteur de clics
    public function incrementClickCount()
    {
        $this->increment('click_count');
    }

    // Incrémenter le compteur d'impressions
    public function incrementImpressionCount()
    {
        $this->increment('impression_count');
    }

    // Vérifier si la publicité est active actuellement
    public function isCurrentlyActive()
    {
        return $this->status === 'active' 
               && $this->start_date <= now() 
               && $this->end_date >= now();
    }

    // Générer URL trackable
    public function getTrackableUrl()
    {
        return route('advertisement.click', ['id' => $this->id]);
    }
}
