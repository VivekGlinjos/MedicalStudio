<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BlogPost extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'excerpt', 'content',
        'author', 'image', 'published', 'published_at',
    ];

    protected $casts = [
        'published'    => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Scope: only published posts
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Route model binding key
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
