<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class BlogPost extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content_md',
        'content_html',
        'excerpt',
        'featured_image',
        'is_published',
        'published_at',
        'scheduled_at',
        'reading_time',
        'views_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopePublished($query)
    {
        // Auto-publish scheduled posts that are past due
        self::where('is_published', false)
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', now())
            ->update(['is_published' => true, 'published_at' => now()]);

        return $query->where('is_published', true)->whereNotNull('published_at');
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('published_at');
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function getFileSizeAttribute(): string
    {
        $bytes = strlen($this->content_md);
        if ($bytes < 1024)
            return $bytes . 'B';
        return round($bytes / 1024, 1) . 'KB';
    }
}
