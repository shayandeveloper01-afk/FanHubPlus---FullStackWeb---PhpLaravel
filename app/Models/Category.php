<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'status', 'icon_svg', 'color', 'sort_order'];

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
