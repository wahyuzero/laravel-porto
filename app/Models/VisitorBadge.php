<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorBadge extends Model
{
    protected $fillable = ['visitor_hash', 'badge_slug', 'earned_at'];

    protected $casts = [
        'earned_at' => 'datetime',
    ];
}
