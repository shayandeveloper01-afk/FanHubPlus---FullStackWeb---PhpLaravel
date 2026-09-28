<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Character extends Model
{
    protected $fillable = ['content_id', 'name', 'alias', 'description', 'image', 'role', 'order_index'];

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    public function imageUrl(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/avatar-placeholder.svg');
    }
}
