<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MyList extends Model
{
    public $timestamps = false;

    protected $table = 'my_list';

    protected $fillable = ['profile_id', 'content_id'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }
}
