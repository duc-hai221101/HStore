<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user)
    {
        return $user->checkPermission(config('permissions.access.role-list'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->checkPermission(config('permissions.access.role-add'));

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        return $user->checkPermission(config('permissions.access.role-edit'));

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->checkPermission(config('permissions.access.role-delete'));

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        //
    }
}
