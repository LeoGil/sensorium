<?php

namespace App\Policies;

use App\Models\Grinder;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GrinderPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Grinder $grinder): bool
    {
        return $user->id === $grinder->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Grinder $grinder): bool
    {
        return $user->id === $grinder->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Grinder $grinder): bool
    {
        return $user->id === $grinder->user_id;
    }
} 