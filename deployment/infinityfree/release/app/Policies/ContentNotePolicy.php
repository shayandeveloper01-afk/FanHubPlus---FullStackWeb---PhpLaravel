<?php

namespace App\Policies;

use App\Models\ContentNote;
use App\Models\User;

class ContentNotePolicy
{
    public function update(User $user, ContentNote $note): bool
    {
        return $user->id === $note->user_id;
    }

    public function delete(User $user, ContentNote $note): bool
    {
        return $user->id === $note->user_id;
    }
}
