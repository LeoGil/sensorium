<?php

namespace App\Policies;

use App\Models\BrewingMethod;
use App\Models\User;

class BrewingMethodPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BrewingMethod $brewingMethod): bool
    {
        return $user->id === $brewingMethod->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BrewingMethod $brewingMethod): bool
    {
        return $user->id === $brewingMethod->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BrewingMethod $brewingMethod): bool
    {
        return $user->id === $brewingMethod->user_id;
    }
}
