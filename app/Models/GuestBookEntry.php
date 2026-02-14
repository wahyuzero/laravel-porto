<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestBookEntry extends Model
{
    protected $fillable = ['nickname', 'message', 'ascii_art', 'website', 'ip_address', 'is_approved'];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}
