<?php

namespace App\Policies;

use App\Models\Filter;
use App\Models\User;

class FilterPolicy
{
    public function update(User $user, Filter $filter): bool
    {
        return $user->id === $filter->user_id;
    }

    public function delete(User $user, Filter $filter): bool
    {
        return $user->id === $filter->user_id;
    }

    public function forceDelete(User $user, Filter $filter): bool
    {
        return $user->id === $filter->user_id;
    }
} 