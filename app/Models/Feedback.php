<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'user_id', 'name', 'email', 'reference_code',
        'type', 'subject', 'message',
        'related_type', 'related_id',
        'status', 'admin_notes',
    ];

    protected static function boot(): void
    {
        parent::boot();
        // Auto-generate a unique 8-char uppercase reference code on creation
        static::creating(function (self $model) {
            $model->reference_code = strtoupper(Str::random(8));
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'new'       => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/40',
            'reviewed'  => 'bg-blue-500/20 text-blue-300 border-blue-500/40',
            'resolved'  => 'bg-green-500/20 text-green-300 border-green-500/40',
            'dismissed' => 'bg-gray-700 text-gray-400 border-gray-600',
            default     => 'bg-gray-700 text-gray-400 border-gray-600',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'new'       => 'Pending',
            'reviewed'  => 'In Review',
            'resolved'  => 'Resolved',
            'dismissed' => 'Dismissed',
            default     => ucfirst($this->status),
        };
    }

    public function typeBadgeClass(): string
    {
        return match ($this->type) {
            'bug'        => 'bg-red-500/20 text-red-300 border-red-500/40',
            'suggestion' => 'bg-purple-500/20 text-purple-300 border-purple-500/40',
            'report'     => 'bg-orange-500/20 text-orange-300 border-orange-500/40',
            default      => 'bg-gray-700 text-gray-400 border-gray-600',
        };
    }
}
