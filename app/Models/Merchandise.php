<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Merchandise extends Model
{
    use SoftDeletes;

    protected $table = 'merchandise';

    protected $fillable = [
        'user_id', 'category_id', 'content_id', 'title', 'slug',
        'description', 'price', 'currency', 'image', 'status',
        'views_count', 'external_purchase_link',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'views_count' => 'integer',
    ];

    // ── Slug ─────────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (Merchandise $merch) {
            $merch->slug = static::uniqueSlug($merch->title);
        });

        static::updating(function (Merchandise $merch) {
            if ($merch->isDirty('title')) {
                $merch->slug = static::uniqueSlug($merch->title, $merch->id);
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

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['category'] ?? null, fn($q, $v) => $q->where('category_id', $v))
            ->when($filters['tag']      ?? null, fn($q, $v) => $q->whereHas('tags', fn($tq) => $tq->where('merchandise_tags.id', $v)));
    }

    public function scopeSort(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'popular'   => $query->orderByDesc('views_count'),
            'price_asc' => $query->orderBy('price'),
            'price_desc'=> $query->orderByDesc('price'),
            default     => $query->orderByDesc('created_at'),
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

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(MerchandiseImage::class)->orderBy('sort_order');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(MerchandiseTag::class, 'merchandise_tag_pivot', 'merchandise_id', 'tag_id');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function imageUrl(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/thumbnail-placeholder.svg');
    }

    public function formattedPrice(): string
    {
        return $this->currency . ' ' . number_format($this->price, 2);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
