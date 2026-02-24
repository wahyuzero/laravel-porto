<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestBookEntry extends Model
{
    protected $fillable = ['nickname', 'message', 'ascii_art', 'website', 'ip_address', 'is_approved', 'parent_id', 'edit_token', 'reactions'];

    protected $casts = [
        'is_approved' => 'boolean',
        'reactions' => 'array',
    ];

    public function reactionLogs()
    {
        return $this->hasMany(\App\Models\GuestbookReaction::class, 'guest_book_entry_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function parent()
    {
        return $this->belongsTo(GuestBookEntry::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(GuestBookEntry::class, 'parent_id')->approved()->latest();
    }
}
