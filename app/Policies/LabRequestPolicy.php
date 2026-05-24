<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\LabRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabRequestPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LabRequest');
    }

    public function view(AuthUser $authUser, LabRequest $labRequest): bool
    {
        return $authUser->can('View:LabRequest');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LabRequest');
    }

    public function update(AuthUser $authUser, LabRequest $labRequest): bool
    {
        return $authUser->can('Update:LabRequest');
    }

    public function delete(AuthUser $authUser, LabRequest $labRequest): bool
    {
        return $authUser->can('Delete:LabRequest');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:LabRequest');
    }

    public function restore(AuthUser $authUser, LabRequest $labRequest): bool
    {
        return $authUser->can('Restore:LabRequest');
    }

    public function forceDelete(AuthUser $authUser, LabRequest $labRequest): bool
    {
        return $authUser->can('ForceDelete:LabRequest');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LabRequest');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LabRequest');
    }

    public function replicate(AuthUser $authUser, LabRequest $labRequest): bool
    {
        return $authUser->can('Replicate:LabRequest');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LabRequest');
    }

}