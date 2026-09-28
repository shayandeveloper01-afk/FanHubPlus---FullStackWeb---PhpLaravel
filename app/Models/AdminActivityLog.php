<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminActivityLog extends Model
{
    const UPDATED_AT = null;

    protected $table    = 'admin_activity_logs';
    protected $fillable = ['admin_id', 'action', 'target_type', 'target_id', 'notes'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
