<?php

namespace App\Policies;

use App\Models\User;

class ServicePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, $service): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function update(User $user, $service): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function delete(User $user, $service): bool
    {
        return $user->isAdmin();
    }
}
