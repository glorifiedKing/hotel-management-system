<?php

namespace App\Policies;

use App\Models\User;
use App\Models\User as AuthUser;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Role');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(AuthUser $authUser, User $model): bool
    {
        return $authUser->can('View:User');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:User');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AuthUser $authUser, User $model): bool
    {
        return $authUser->can('Update:User');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AuthUser $authUser, User $model): bool
    {
        return $authUser->can('Delete:User');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(AuthUser $authUser, User $model): bool
    {
        return $authUser->can('Restore:User');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(AuthUser $authUser, User $model): bool
    {
        return $authUser->can('ForceDelete:User');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:User');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:User');
    }

    public function replicate(AuthUser $authUser, User $user): bool
    {
        return $authUser->can('Replicate:User');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:User');
    }
}
