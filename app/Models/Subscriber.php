<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    protected $fillable = ['email', 'token', 'is_verified', 'verified_at'];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($subscriber) {
            $subscriber->token = $subscriber->token ?: Str::random(32);
        });
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}
