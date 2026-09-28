<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchandiseImage extends Model
{
    protected $fillable = ['merchandise_id', 'image_path', 'sort_order'];

    public function merchandise(): BelongsTo
    {
        return $this->belongsTo(Merchandise::class);
    }

    public function url(): string
    {
        return asset('storage/' . $this->image_path);
    }
}
