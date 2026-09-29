<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Support\ImageArtwork;

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
        $storedThumbnail = trim((string) $this->thumbnail);
        $normalizedThumbnail = ltrim(str_replace('\\', '/', $storedThumbnail), '/');

        // This seeded trailer had inherited a generic TV-series clapperboard.
        // Use its title-specific local poster unless an admin uploaded an image.
        if (str_contains(Str::lower($this->title), 'superestar') && ! str_starts_with($normalizedThumbnail, 'thumbnails/')) {
            return asset('images/categories/tv-series/superestar.svg');
        }

        // $year and $type give TMDB/Jikan a better chance of matching the
        // right release; a stored upload is still returned untouched.
        return ImageArtwork::source($this->thumbnail, $this->title, $this->category?->name ?? $this->type ?? 'Fan content', 'content', $this->getKey(), $this->year, (string) $this->type);
    }
/** Trailer ko embed ke qabil format mein badalta hai (YouTube, Vimeo ya direct video file). */
public function trailerEmbed(): ?array
{
    $url = trim((string) $this->trailer_url);
    if ($url === '') return null;

    // YouTube (watch, youtu.be, shorts, embed sab chalte hain)
    if (preg_match('~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)) {
        return ['type' => 'iframe', 'src' => "https://www.youtube-nocookie.com/embed/{$m[1]}?rel=0"];
    }

    // Vimeo
    if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
        return ['type' => 'iframe', 'src' => "https://player.vimeo.com/video/{$m[1]}"];
    }

    // Direct video file (.mp4, .webm, .ogg)
    if (preg_match('~\.(mp4|webm|ogg)(\?.*)?$~i', $url)) {
        return ['type' => 'video', 'src' => $url];
    }

    return null;
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
