<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WatchProgress extends Model
{
    // Only updated_at exists on this table (no created_at)
    const CREATED_AT = null;

    protected $table = 'watch_progress';

    protected $fillable = ['profile_id', 'content_id', 'progress_pct'];

    protected $casts = ['progress_pct' => 'integer'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }
}
