<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = ['url', 'page_title', 'referrer', 'ip_hash', 'user_agent', 'viewed_date'];

    protected $casts = [
        'viewed_date' => 'date',
    ];
}
