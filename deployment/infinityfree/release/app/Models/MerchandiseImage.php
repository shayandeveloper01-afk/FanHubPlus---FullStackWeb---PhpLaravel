<?php

namespace App\Models;

use App\Support\ImageArtwork;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchandiseImage extends Model
{
    protected $fillable = ['merchandise_id', 'image_path', 'sort_order'];

    public function merchandise(): BelongsTo
    {
        return $this->belongsTo(Merchandise::class);
    }

    public function url(): string
    {
        return ImageArtwork::source($this->image_path, $this->merchandise?->title ?? 'Product image', $this->merchandise?->category?->name ?? 'Merchandise', 'merchandise', $this->getKey());
    }
}
