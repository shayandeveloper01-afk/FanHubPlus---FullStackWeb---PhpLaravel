<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;

class ContentPolicy
{
    public function update(User $user, Content $content): bool
    {
        return $user->id === $content->user_id || $user->is_admin || $user->role === 'admin';
    }

    public function delete(User $user, Content $content): bool
    {
        return $user->id === $content->user_id || $user->is_admin || $user->role === 'admin';
    }
}
