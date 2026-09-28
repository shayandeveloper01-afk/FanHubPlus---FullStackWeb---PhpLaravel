<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsEvent extends Model
{
    // Only created_at — no updated_at on this append-only table
    const UPDATED_AT = null;

    protected $table = 'analytics_events';

    protected $fillable = [
        'event_type', 'profile_id', 'session_id', 'metadata', 'url',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
