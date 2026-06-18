<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrowthEvent extends Model
{
    use HasUlids;

    protected $fillable = ['user_id', 'anonymous_id', 'name', 'path', 'referrer', 'source', 'medium', 'campaign', 'metadata', 'ip_hash', 'user_agent'];

    protected function casts(): array
    {
        return ['metadata' => 'array'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
