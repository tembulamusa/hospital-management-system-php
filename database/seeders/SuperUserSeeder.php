<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SuperUserSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $superAdminRole = Role::findOrCreate('Super Admin');
        $superAdminRole->syncPermissions(Permission::all());

        $department = Department::query()->where('code', 'OPD')->first();

        $user = User::updateOrCreate(
            ['email' => 'tembulamoses87@gmail.com'],
            [
                'name' => 'Moses Tembula',
                'password' => 'Tembula2017',
                'phone' => null,
                'employee_number' => 'EMP-SA-002',
                'department_id' => $department?->id,
                'gender' => 'Male',
                'specialization' => 'General Medicine / Clinical Administration',
                'qualifications' => 'Hospital System Administrator',
                'active' => true,
            ],
        );

        $user->syncRoles(['Super Admin', 'Doctor', 'Nurse']);
        $user->syncPermissions(Permission::all());
    }
}
