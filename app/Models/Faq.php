<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['question', 'answer', 'keywords', 'is_published', 'sort_order'];

    protected $casts = [
        'is_published' => 'boolean',
        'keywords'     => 'array',   // stored as JSON, accessed as PHP array
    ];

    public function keywordList(): array
    {
        return static::normalizeKeywords($this->keywords);
    }

    public static function normalizeKeywords(mixed $keywords): array
    {
        if (is_string($keywords)) {
            $decoded = json_decode($keywords, true);
            $keywords = is_array($decoded) ? $decoded : explode(',', $keywords);
        }

        if (!is_array($keywords)) {
            return [];
        }

        return array_values(array_unique(array_filter(
            array_map(static fn ($keyword) => trim((string) $keyword), $keywords),
            static fn ($keyword) => $keyword !== '',
        )));
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }
}
