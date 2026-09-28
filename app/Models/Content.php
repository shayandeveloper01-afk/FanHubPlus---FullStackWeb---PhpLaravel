<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Content extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'body', 'status',
        'genre', 'year', 'type', 'views_count', 'thumbnail', 'trailer_url', 'release_date',
    ];

    protected $casts = [
        'year'        => 'integer',
        'views_count' => 'integer',
        'release_date' => 'date',
    ];

    // ── Slug auto-generation ──────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (Content $content) {
            $content->slug = static::uniqueSlug($content->title);
        });

        static::updating(function (Content $content) {
            if ($content->isDirty('title')) {
                $content->slug = static::uniqueSlug($content->title, $content->id);
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

    // ── Query Scopes ──────────────────────────────────────────────────────────

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('body', 'like', "%{$term}%");
        });
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['category'] ?? null, fn($q, $v) => $q->where('category_id', $v))
            ->when($filters['genre']    ?? null, fn($q, $v) => $q->where('genre', $v))
            ->when($filters['year']     ?? null, fn($q, $v) => $q->where('year', $v))
            ->when($filters['type']     ?? null, fn($q, $v) => $q->where('type', $v))
            ->when($filters['tags'] ?? null, function ($q, $tags) {
                $slugs = array_filter(explode(',', (string) $tags));
                $q->whereHas('tags', fn ($tagQuery) => $tagQuery->whereIn('slug', $slugs));
            });
    }

    public function scopeSort(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'popular' => $query->orderByDesc('views_count'),
            'alpha'   => $query->orderBy('title'),
            default   => $query->orderByDesc('created_at'),
        };
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(ContentNote::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class)->orderBy('order_index');
    }

    public function timelineEvents(): HasMany
    {
        return $this->hasMany(TimelineEvent::class)->orderBy('order_index');
    }

    public function watchProgress(): HasMany
    {
        return $this->hasMany(WatchProgress::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function myListEntries(): HasMany
    {
        return $this->hasMany(MyList::class);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function thumbnailUrl(): string
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('images/thumbnail-placeholder.svg');
    }

    /** Average rating rounded to 1 decimal, or null if no ratings. */
    public function averageRating(): ?float
    {
        $avg = $this->ratings()->avg('rating');
        return $avg ? round($avg, 1) : null;
    }

    /** Total number of ratings. */
    public function ratingsCount(): int
    {
        return $this->ratings()->count();
    }
}
