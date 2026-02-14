<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'bio',
        'avatar_path',
        'resume_path',
        'social_links',
        'status_text',
        'currently_reading',
        'currently_building',
        'currently_listening',
        'location',
        'email_public',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
