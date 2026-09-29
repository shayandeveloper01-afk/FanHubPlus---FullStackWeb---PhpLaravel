<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Models\Merchandise;
use App\Models\Event;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'avatar', 'is_admin', 'role', 'banned_at'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password_changed_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
            'banned_at'         => 'datetime',
            'role'              => 'string',
        ];
    }

    public function isBanned(): bool
    {
        return $this->banned_at !== null;
    }

    public function isOrganizer(): bool
    {
        return in_array($this->role, ['organizer', 'admin'], true);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
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

    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function merchandise(): HasMany
    {
        return $this->hasMany(Merchandise::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function eventRsvps(): HasMany
    {
        return $this->hasMany(EventRsvp::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    public function avatarUrl(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            $path = implode('/', array_map('rawurlencode', explode('/', ltrim($this->avatar, '/'))));

            // Keep the Storage URL rooted at the active app URL. APP_URL can
            // be stale in local setups (for example when served on :8000).
            return $this->publicAssetUrl('storage/'.$path);
        }

        return $this->defaultAvatarUrl();
    }

    public function defaultAvatarUrl(): string
    {
        return $this->publicAssetUrl('images/fanhub-avatar.svg');
    }

    private function publicAssetUrl(string $path): string
    {
        // Build from the active request path so a stale APP_URL cannot point
        // avatars at another local project or deployment directory.
        return rtrim(request()->getBaseUrl(), '/').'/'.ltrim($path, '/');
    }
}
