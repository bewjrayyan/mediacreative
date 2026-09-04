<?php

namespace App\Policies;

use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, $project): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function update(User $user, $project): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function delete(User $user, $project): bool
    {
        return $user->isAdmin();
    }
}
