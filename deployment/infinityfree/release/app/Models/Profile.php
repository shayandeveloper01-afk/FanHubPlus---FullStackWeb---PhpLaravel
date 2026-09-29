<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    protected $fillable = ['user_id', 'name', 'avatar', 'avatar_url', 'fandom_tags', 'is_kid', 'is_kids', 'sort_order'];

    protected $casts = ['is_kid' => 'boolean', 'is_kids' => 'boolean', 'fandom_tags' => 'array'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function watchProgress(): HasMany
    {
        return $this->hasMany(WatchProgress::class);
    }

    public function myList(): HasMany
    {
        return $this->hasMany(MyList::class);
    }

    /** Ratings scoped to this profile (reuses existing ratings table via profile_id). */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /** Returns a URL or a default avatar based on stored value. */
    public function avatarUrl(): string
    {
        if ($this->avatar_url) {
            return $this->avatar_url;
        }
        if (!$this->avatar) {
            return asset('images/fanhub-avatar.svg');
        }
        // If it starts with 'avatars/' it's a stored file; otherwise treat as emoji/color key
        return str_starts_with($this->avatar, 'avatars/') && Storage::disk('public')->exists($this->avatar)
            ? Storage::disk('public')->url($this->avatar)
            : asset('images/fanhub-avatar.svg');
    }
}
