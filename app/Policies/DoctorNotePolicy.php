<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DoctorNote;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctorNotePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DoctorNote');
    }

    public function view(AuthUser $authUser, DoctorNote $doctorNote): bool
    {
        return $authUser->can('View:DoctorNote');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DoctorNote');
    }

    public function update(AuthUser $authUser, DoctorNote $doctorNote): bool
    {
        return $authUser->can('Update:DoctorNote');
    }

    public function delete(AuthUser $authUser, DoctorNote $doctorNote): bool
    {
        return $authUser->can('Delete:DoctorNote');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:DoctorNote');
    }

    public function restore(AuthUser $authUser, DoctorNote $doctorNote): bool
    {
        return $authUser->can('Restore:DoctorNote');
    }

    public function forceDelete(AuthUser $authUser, DoctorNote $doctorNote): bool
    {
        return $authUser->can('ForceDelete:DoctorNote');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DoctorNote');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DoctorNote');
    }

    public function replicate(AuthUser $authUser, DoctorNote $doctorNote): bool
    {
        return $authUser->can('Replicate:DoctorNote');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DoctorNote');
    }

}