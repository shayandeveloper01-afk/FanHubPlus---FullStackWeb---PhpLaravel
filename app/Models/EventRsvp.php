<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRsvp extends Model
{
    public $timestamps = false;

    protected $fillable = ['event_id', 'user_id', 'status'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Optional profile relationship — the event_rsvps table stores user_id;
     * this resolves the active profile for the user if one is set in session.
     * Kept as a convenience accessor rather than a DB foreign key since
     * RSVPs are user-scoped, not profile-scoped, in the current schema.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
