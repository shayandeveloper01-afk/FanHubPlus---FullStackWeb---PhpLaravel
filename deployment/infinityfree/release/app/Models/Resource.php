<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Support\ImageArtwork;

class Resource extends Model
{
    protected $fillable = [
        'content_id', 'user_id', 'title', 'slug', 'description', 'type', 'file_path',
        'file_size_kb', 'thumbnail_path', 'download_count', 'license', 'is_approved', 'moderation_reason',
    ];

    protected $casts = ['is_approved' => 'boolean', 'download_count' => 'integer'];

    protected static function booted(): void
    {
        static::creating(function (Resource $resource): void {
            $resource->slug ??= Str::slug($resource->title) . '-' . Str::lower(Str::random(6));
        });
    }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function content(): BelongsTo { return $this->belongsTo(Content::class); }

    public function thumbnailUrl(): string
    {
        $image = ImageArtwork::source($this->thumbnail_path, $this->title, $this->content?->category?->name ?? ucfirst($this->type), 'resource', $this->getKey());

        if ($this->content && (str_contains($image, '/catalog-artwork/resource/') || str_starts_with($image, 'data:image/svg+xml,'))) {
            return $this->content->thumbnailUrl();
        }

        return $image;
    }
}
