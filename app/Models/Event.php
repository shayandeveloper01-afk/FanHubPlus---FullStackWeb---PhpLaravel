<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'content_id', 'title', 'slug',
        'description', 'venue_name', 'address', 'country', 'city',
        'latitude', 'longitude', 'start_datetime', 'end_datetime',
        'cover_image', 'ticket_link',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime'   => 'datetime',
        'latitude'       => 'float',
        'longitude'      => 'float',
    ];

    // ── Slug ─────────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (Event $event) {
            $event->slug = static::uniqueSlug($event->title);
        });

        static::updating(function (Event $event) {
            if ($event->isDirty('title')) {
                $event->slug = static::uniqueSlug($event->title, $event->id);
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

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('start_datetime', '>=', now());
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->where('start_datetime', '<', now());
    }

    public function scopeFilterCity(Builder $query, ?string $city): Builder
    {
        return $query->when($city, fn($q, $v) => $q->where('city', $v));
    }

    public function scopeFilterCountry(Builder $query, ?string $country): Builder
    {
        return $query->when($country, fn($q, $v) => $q->where('country', $v));
    }

    public function scopeFilterCategory(Builder $query, ?string $category): Builder
    {
        return $query->when($category, fn($q, $v) => $q->where('category_id', $v));
    }

    public function scopeFilterLocation(Builder $query, ?string $location): Builder
    {
        return $query->when(filled($location), function (Builder $query) use ($location): void {
            $term = '%'.str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], trim($location)).'%';
            $query->where(function (Builder $query) use ($term): void {
                $query->where('city', 'like', $term)
                    ->orWhere('address', 'like', $term)
                    ->orWhere('venue_name', 'like', $term);
            });
        });
    }

    /**
     * Haversine formula scope — filters events within $radiusKm of ($lat, $lng)
     * and limits the result set to the requested radius. The controller adds
     * a presentation distance after filtering so SQLite's UDF can be used only
     * in the WHERE clause (avoiding a duplicated expression in SELECT).
     *
     * Formula: d = 2R · arcsin(√(sin²(Δlat/2) + cos(lat1)·cos(lat2)·sin²(Δlng/2)))
     * R = 6371 km (mean Earth radius)
     */
    public function scopeNearby(Builder $query, float $lat, float $lng, float $radiusKm = 25): Builder
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            // These are already bounded floats; locale-independent formatting
            // avoids interpolating any raw request text and works around
            // SQLite's deterministic UDF handling of repeated placeholders.
            $latLiteral = number_format($lat, 8, '.', '');
            $lngLiteral = number_format($lng, 8, '.', '');
            $distanceExpression = "haversine_distance(latitude, longitude, {$latLiteral}, {$lngLiteral})";
            $distanceBindings = [];
        } else {
            $distanceExpression = '6371 * ACOS(LEAST(1, GREATEST(-1, COS(RADIANS(?)) * COS(RADIANS(latitude)) * COS(RADIANS(longitude) - RADIANS(?)) + SIN(RADIANS(?)) * SIN(RADIANS(latitude)))))';
            $distanceBindings = [$lat, $lng, $lat];
        }

        // Radius is bounded and normalized to an integer by request validation.
        $radius = max(0, min(100, (int) $radiusKm));

        return $query
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereRaw($distanceExpression . ' <= ' . $radius, $distanceBindings)
            ->orderBy('start_datetime');
    }

    /** Filter events whose start_datetime falls within a date range. */
    public function scopeInDateRange(Builder $query, ?string $start, ?string $end): Builder
    {
        return $query
            ->when($start, fn($q, $v) => $q->whereDate('start_datetime', '>=', $v))
            ->when($end,   fn($q, $v) => $q->whereDate('start_datetime', '<=', $v));
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

    public function rsvps(): HasMany
    {
        return $this->hasMany(EventRsvp::class);
    }

    public function goingCount(): int
    {
        return $this->rsvps->where('status', 'going')->count();
    }

    public function interestedCount(): int
    {
        return $this->rsvps->where('status', 'interested')->count();
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function status(): string
    {
        $now = now();

        if ($this->start_datetime > $now) {
            return 'upcoming';
        }

        if ($this->end_datetime && $this->end_datetime > $now) {
            return 'ongoing';
        }

        return 'past';
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status()) {
            'upcoming' => 'bg-green-500/20 text-green-300 border-green-500/40',
            'ongoing'  => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/40',
            default    => 'bg-gray-700 text-gray-400 border-gray-600',
        };
    }

    public function coverImageUrl(): string
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/thumbnail-placeholder.svg');
    }

    public function hasCoordinates(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    public function distanceFrom(float $latitude, float $longitude): float
    {
        $earthRadiusKm = 6371.0;
        $lat1 = deg2rad((float) $this->latitude);
        $lat2 = deg2rad($latitude);
        $deltaLat = $lat2 - $lat1;
        $deltaLng = deg2rad($longitude - (float) $this->longitude);
        $haversine = sin($deltaLat / 2) ** 2
            + cos($lat1) * cos($lat2) * sin($deltaLng / 2) ** 2;

        return $earthRadiusKm * 2 * asin(min(1.0, sqrt(max(0.0, $haversine))));
    }
}
