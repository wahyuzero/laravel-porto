<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestbookReaction extends Model
{
    protected $fillable = ['guest_book_entry_id', 'emoji', 'ip_address'];

    public function entry()
    {
        return $this->belongsTo(GuestBookEntry::class, 'guest_book_entry_id');
    }
}
