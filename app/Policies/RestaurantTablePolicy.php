<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\RestaurantTable;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantTablePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:RestaurantTable');
    }

    public function view(AuthUser $authUser, RestaurantTable $restaurantTable): bool
    {
        return $authUser->can('View:RestaurantTable');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:RestaurantTable');
    }

    public function update(AuthUser $authUser, RestaurantTable $restaurantTable): bool
    {
        return $authUser->can('Update:RestaurantTable');
    }

    public function delete(AuthUser $authUser, RestaurantTable $restaurantTable): bool
    {
        return $authUser->can('Delete:RestaurantTable');
    }

    public function restore(AuthUser $authUser, RestaurantTable $restaurantTable): bool
    {
        return $authUser->can('Restore:RestaurantTable');
    }

    public function forceDelete(AuthUser $authUser, RestaurantTable $restaurantTable): bool
    {
        return $authUser->can('ForceDelete:RestaurantTable');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:RestaurantTable');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:RestaurantTable');
    }

    public function replicate(AuthUser $authUser, RestaurantTable $restaurantTable): bool
    {
        return $authUser->can('Replicate:RestaurantTable');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:RestaurantTable');
    }

}