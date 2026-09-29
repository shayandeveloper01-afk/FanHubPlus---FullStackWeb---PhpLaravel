<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\ImageArtwork;

class Character extends Model
{
    protected $fillable = ['content_id', 'name', 'alias', 'description', 'image', 'role', 'order_index'];

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    public function imageUrl(): string
    {
        $image = ImageArtwork::source($this->image, $this->name, $this->content?->category?->name ?? 'Character', 'character', $this->getKey());

        if ($this->content && (str_contains($image, '/catalog-artwork/character/') || str_starts_with($image, 'data:image/svg+xml,'))) {
            return $this->content->thumbnailUrl();
        }

        return $image;
    }
}
