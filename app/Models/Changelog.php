<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Changelog extends Model
{
    protected $fillable = ['version', 'title', 'content', 'released_at'];

    protected $casts = [
        'released_at' => 'date',
    ];

    public function scopeLatest($query)
    {
        return $query->orderByDesc('released_at');
    }
}
