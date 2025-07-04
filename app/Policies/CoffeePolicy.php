<?php

namespace App\Policies;

use App\Models\Coffee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoffeePolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Coffee $coffee): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Coffee $coffee): bool
    {
        return $user->id === $coffee->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Coffee $coffee): bool
    {
        return $user->id === $coffee->user_id;
    }
}
