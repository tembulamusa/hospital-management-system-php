<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\NurseTriage;
use Illuminate\Auth\Access\HandlesAuthorization;

class NurseTriagePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:NurseTriage');
    }

    public function view(AuthUser $authUser, NurseTriage $nurseTriage): bool
    {
        return $authUser->can('View:NurseTriage');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:NurseTriage');
    }

    public function update(AuthUser $authUser, NurseTriage $nurseTriage): bool
    {
        return $authUser->can('Update:NurseTriage');
    }

    public function delete(AuthUser $authUser, NurseTriage $nurseTriage): bool
    {
        return $authUser->can('Delete:NurseTriage');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:NurseTriage');
    }

    public function restore(AuthUser $authUser, NurseTriage $nurseTriage): bool
    {
        return $authUser->can('Restore:NurseTriage');
    }

    public function forceDelete(AuthUser $authUser, NurseTriage $nurseTriage): bool
    {
        return $authUser->can('ForceDelete:NurseTriage');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:NurseTriage');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:NurseTriage');
    }

    public function replicate(AuthUser $authUser, NurseTriage $nurseTriage): bool
    {
        return $authUser->can('Replicate:NurseTriage');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:NurseTriage');
    }

}