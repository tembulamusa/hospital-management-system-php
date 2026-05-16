<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            'Super Admin',
            'Doctor',
            'Nurse',
            'Receptionist',
            'Pharmacist',
            'Lab Technician',
            'Accountant',
            'Cashier',
        ] as $role) {
            Role::findOrCreate($role);
        }
    }
}
