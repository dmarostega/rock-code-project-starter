<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class MediaAsset extends Model
{
    use HasUlids;

    protected $fillable = ['user_id', 'disk', 'path', 'original_name', 'mime_type', 'size', 'kind', 'width', 'height', 'alt_text', 'metadata'];

    protected $appends = ['url'];

    protected function casts(): array
    {
        return ['metadata' => 'array', 'size' => 'integer', 'width' => 'integer', 'height' => 'integer'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
