<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ALaUneArticle extends Model
{
    use HasFactory;

    protected $table = 'a_la_une_articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'excerpt',
        'content',
        'featured_image_url',
        'featured_image_alt',
        'featured_image_path',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'status',
        'published_at',
        'scheduled_at',
        'is_featured',
        'is_trending',
        'author_id',
        'user_id',
        'category_id',
        'reading_time',
        'priority',
        'language',
        'source_url',
        'sector',
        'theme',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'view_count' => 'integer',
        'share_count' => 'integer',
        'like_count' => 'integer',
        'comment_count' => 'integer',
        'reading_time' => 'integer',
        'priority' => 'integer',
    ];

    /**
     * Get the category that owns the article.
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that owns the article.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include published articles.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('is_active', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include featured articles.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include active articles.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
