<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimelineEvent extends Model
{
    protected $fillable = ['content_id', 'title', 'description', 'event_date', 'order_index'];

    protected $casts = ['event_date' => 'date'];

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }
}
