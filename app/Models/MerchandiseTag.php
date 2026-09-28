<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MerchandiseTag extends Model
{
    protected $table = 'merchandise_tags';

    protected $fillable = ['name', 'slug'];

    public function merchandise(): BelongsToMany
    {
        return $this->belongsToMany(Merchandise::class, 'merchandise_tag_pivot', 'tag_id', 'merchandise_id');
    }

    // Tag badge color per slug
    public function badgeClass(): string
    {
        return match ($this->slug) {
            'limited-edition' => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/40',
            'pre-order'       => 'bg-blue-500/20 text-blue-300 border-blue-500/40',
            'collectible'     => 'bg-purple-500/20 text-purple-300 border-purple-500/40',
            default           => 'bg-gray-700 text-gray-300 border-gray-600',
        };
    }
}
