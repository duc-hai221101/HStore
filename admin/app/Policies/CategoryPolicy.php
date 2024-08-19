<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
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
    public function index(User $user)
    {
        return $user->checkPermission(config('permissions.access.category-list'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->checkPermission(config('permissions.access.category-add'));

    }

    /**
     * Determine whether the user can update the model.
     */
    public function edit(User $user )
    {
        return $user->checkPermission(config('permissions.access.category-edit'));

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        return $user->checkPermission(config('permissions.access.category-delete'));

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        //
    }
}
