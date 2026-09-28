<?php

namespace App\Policies;

use App\Models\Merchandise;
use App\Models\User;

class MerchandisePolicy
{
    public function update(User $user, Merchandise $merch): bool
    {
        return $user->id === $merch->user_id || $user->is_admin || $user->role === 'admin';
    }

    public function delete(User $user, Merchandise $merch): bool
    {
        return $user->id === $merch->user_id || $user->is_admin || $user->role === 'admin';
    }
}
