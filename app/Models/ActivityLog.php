<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['action', 'description', 'model_type', 'model_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log(string $action, string $description, ?string $modelType = null, ?int $modelId = null): self
    {
        return self::create([
            'action' => $action,
            'description' => $description,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'user_id' => auth()->id(),
        ]);
    }
}
