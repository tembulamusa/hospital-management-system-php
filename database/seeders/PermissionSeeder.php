<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'patients.view',
            'patients.create',
            'patients.update',
            'patients.delete',
            'appointments.view',
            'appointments.create',
            'appointments.update',
            'appointments.delete',
            'visits.view',
            'visits.create',
            'visits.update',
            'visits.delete',
            'triage.view',
            'triage.create',
            'triage.update',
            'triage.delete',
            'doctor-notes.view',
            'doctor-notes.create',
            'doctor-notes.update',
            'doctor-notes.delete',
            'prescriptions.view',
            'prescriptions.create',
            'prescriptions.update',
            'prescriptions.delete',
            'pharmacy.dispense',
            'medicines.view',
            'medicines.create',
            'medicines.update',
            'medicines.delete',
            'lab.view',
            'lab.request',
            'lab.approve',
            'billing.view',
            'billing.create',
            'billing.update',
            'billing.delete',
            'payments.view',
            'payments.create',
            'payments.update',
            'payments.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        Role::findOrCreate('Super Admin')->syncPermissions(Permission::all());

        Role::findOrCreate('Doctor')->syncPermissions([
            'patients.view',
            'appointments.view',
            'appointments.update',
            'visits.view',
            'visits.create',
            'visits.update',
            'doctor-notes.view',
            'doctor-notes.create',
            'doctor-notes.update',
            'prescriptions.view',
            'prescriptions.create',
            'prescriptions.update',
            'lab.view',
            'lab.request',
        ]);

        Role::findOrCreate('Nurse')->syncPermissions([
            'patients.view',
            'visits.view',
            'triage.view',
            'triage.create',
            'triage.update',
        ]);

        Role::findOrCreate('Receptionist')->syncPermissions([
            'patients.view',
            'patients.create',
            'patients.update',
            'appointments.view',
            'appointments.create',
            'appointments.update',
            'visits.view',
            'visits.create',
        ]);

        Role::findOrCreate('Pharmacist')->syncPermissions([
            'prescriptions.view',
            'pharmacy.dispense',
            'medicines.view',
            'medicines.update',
        ]);

        Role::findOrCreate('Lab Technician')->syncPermissions([
            'lab.view',
            'lab.request',
            'lab.approve',
        ]);

        Role::findOrCreate('Accountant')->syncPermissions([
            'billing.view',
            'billing.create',
            'billing.update',
            'payments.view',
            'payments.create',
            'payments.update',
        ]);

        Role::findOrCreate('Cashier')->syncPermissions([
            'billing.view',
            'payments.view',
            'payments.create',
        ]);
    }
}
