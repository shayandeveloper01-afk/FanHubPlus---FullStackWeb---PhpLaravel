<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->is_admin || $user->role === 'admin';
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->is_admin || $user->role === 'admin';
    }
}
