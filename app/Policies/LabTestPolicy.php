<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\LabTest;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabTestPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LabTest');
    }

    public function view(AuthUser $authUser, LabTest $labTest): bool
    {
        return $authUser->can('View:LabTest');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LabTest');
    }

    public function update(AuthUser $authUser, LabTest $labTest): bool
    {
        return $authUser->can('Update:LabTest');
    }

    public function delete(AuthUser $authUser, LabTest $labTest): bool
    {
        return $authUser->can('Delete:LabTest');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:LabTest');
    }

    public function restore(AuthUser $authUser, LabTest $labTest): bool
    {
        return $authUser->can('Restore:LabTest');
    }

    public function forceDelete(AuthUser $authUser, LabTest $labTest): bool
    {
        return $authUser->can('ForceDelete:LabTest');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LabTest');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LabTest');
    }

    public function replicate(AuthUser $authUser, LabTest $labTest): bool
    {
        return $authUser->can('Replicate:LabTest');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LabTest');
    }

}