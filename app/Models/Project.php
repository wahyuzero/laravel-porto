<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'long_description',
        'tech_stack',
        'url',
        'repo_url',
        'screenshot_path',
        'featured',
        'is_visible',
        'sort_order',
        'year',
        'status',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'featured' => 'boolean',
        'is_visible' => 'boolean',
    ];

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('year');
    }
}
