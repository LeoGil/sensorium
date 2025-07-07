<?php

namespace App\Policies;

use App\Models\ContainerType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContainerTypePolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContainerType $containerType): bool
    {
        return $user->id === $containerType->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContainerType $containerType): bool
    {
        return $user->id === $containerType->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContainerType $containerType): bool
    {
        return $user->id === $containerType->user_id;
    }
}
