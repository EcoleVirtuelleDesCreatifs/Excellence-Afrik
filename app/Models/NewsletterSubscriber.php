<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'name',
        'source',
        'is_premium',
        'is_active',
        'subscribed_at',
        'unsubscribed_at',
        'email_verified_at',
        'verification_token',
        'unsubscribe_token',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscriber) {
            $subscriber->unsubscribe_token = Str::uuid();
            $subscriber->subscribed_at = now();
            
            if (!$subscriber->verification_token && !$subscriber->email_verified_at) {
                $subscriber->verification_token = Str::random(60);
            }
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeBySource($query, $source)
    {
        return $query->where('source', $source);
    }

    // Accessors & Mutators
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'unsubscribed';
        }
        
        if (!$this->email_verified_at) {
            return 'pending_verification';
        }
        
        return 'active';
    }

    // Methods
    public function unsubscribe()
    {
        $this->update([
            'is_active' => false,
            'unsubscribed_at' => now(),
        ]);
    }

    public function resubscribe()
    {
        $this->update([
            'is_active' => true,
            'unsubscribed_at' => null,
        ]);
    }

    public function verify()
    {
        $this->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);
    }

    public function isVerified()
    {
        return !is_null($this->email_verified_at);
    }

    public function getSourceLabelAttribute()
    {
        $sources = [
            'home' => 'Page d\'accueil',
            'magazines' => 'Page magazines',
            'footer' => 'Footer',
            'articles' => 'Page articles',
            'manual' => 'Ajout manuel',
            'website' => 'Site web',
        ];

        return $sources[$this->source] ?? ucfirst($this->source);
    }
}
