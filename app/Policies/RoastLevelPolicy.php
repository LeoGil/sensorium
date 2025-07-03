<?php

namespace App\Policies;

use App\Models\RoastLevel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RoastLevelPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RoastLevel $roastLevel): bool
    {
        return $user->id === $roastLevel->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RoastLevel $roastLevel): bool
    {
        return $user->id === $roastLevel->user_id;
    }
}
