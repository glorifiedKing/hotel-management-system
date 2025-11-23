<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KitchenOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class KitchenOrderPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KitchenOrder');
    }

    public function view(AuthUser $authUser, KitchenOrder $kitchenOrder): bool
    {
        return $authUser->can('View:KitchenOrder');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KitchenOrder');
    }

    public function update(AuthUser $authUser, KitchenOrder $kitchenOrder): bool
    {
        return $authUser->can('Update:KitchenOrder');
    }

    public function delete(AuthUser $authUser, KitchenOrder $kitchenOrder): bool
    {
        return $authUser->can('Delete:KitchenOrder');
    }

    public function restore(AuthUser $authUser, KitchenOrder $kitchenOrder): bool
    {
        return $authUser->can('Restore:KitchenOrder');
    }

    public function forceDelete(AuthUser $authUser, KitchenOrder $kitchenOrder): bool
    {
        return $authUser->can('ForceDelete:KitchenOrder');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KitchenOrder');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KitchenOrder');
    }

    public function replicate(AuthUser $authUser, KitchenOrder $kitchenOrder): bool
    {
        return $authUser->can('Replicate:KitchenOrder');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KitchenOrder');
    }

}