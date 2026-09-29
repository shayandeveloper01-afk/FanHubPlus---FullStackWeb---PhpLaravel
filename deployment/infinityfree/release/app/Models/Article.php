<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Support\ImageArtwork;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'slug', 'excerpt', 'body',
        'cover_image', 'status', 'is_featured', 'published_at', 'category_id',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
        'read_time_minutes' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Article $article): void {
            $article->read_time_minutes = max(1, (int) ceil(str_word_count(strip_tags($article->body ?? '')) / 200));
        });
        static::creating(function (Article $article) {
            $article->slug = static::uniqueSlug($article->title);
            if ($article->status === 'published' && ! $article->published_at) {
                $article->published_at = now();
            }
        });

        static::updating(function (Article $article) {
            if ($article->isDirty('title')) {
                $article->slug = static::uniqueSlug($article->title, $article->id);
            }
            if ($article->isDirty('status') && $article->status === 'published' && ! $article->published_at) {
                $article->published_at = now();
            }
        });
    }

    private static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while (
            static::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function coverImageUrl(): string
    {
        return ImageArtwork::source($this->cover_image, $this->title, $this->category?->name ?? 'Editorial', 'article', $this->getKey());
    }
}
