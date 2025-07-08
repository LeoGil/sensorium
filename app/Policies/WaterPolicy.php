<?php

namespace App\Policies;

use App\Models\Water;
use App\Models\User;

class WaterPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Water $water): bool
    {
        return $user->id === $water->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Water $water): bool
    {
        return $user->id === $water->user_id;
    }
} 