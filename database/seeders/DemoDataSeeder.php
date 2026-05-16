<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Billing;
use App\Models\Department;
use App\Models\DoctorNote;
use App\Models\LabRequest;
use App\Models\LabTest;
use App\Models\Medicine;
use App\Models\NurseTriage;
use App\Models\Payment;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $departments = $this->seedDepartments();
        $staff = $this->seedStaff($departments);
        $patients = $this->seedPatients();
        $medicines = $this->seedMedicines();
        $labTests = $this->seedLabTests();

        $this->seedAppointments($patients, $staff['doctor'], $staff['receptionist']);
        $visits = $this->seedVisits($patients, $staff['doctor']);

        $this->seedClinicalWorkflow($visits, $staff['nurse'], $staff['doctor'], $medicines, $labTests);
        $this->seedBilling($visits, $patients);
    }

    private function seedDepartments(): array
    {
        $definitions = [
            ['name' => 'Outpatient', 'code' => 'OPD', 'description' => 'Patient registration and consultation desk'],
            ['name' => 'Nursing', 'code' => 'NUR', 'description' => 'Triage and vital signs'],
            ['name' => 'Laboratory', 'code' => 'LAB', 'description' => 'Specimen collection and testing'],
            ['name' => 'Pharmacy', 'code' => 'PHA', 'description' => 'Dispensing and stock management'],
            ['name' => 'Accounts', 'code' => 'ACC', 'description' => 'Billing and payment reconciliation'],
        ];

        return collect($definitions)->mapWithKeys(function (array $definition): array {
            $department = Department::updateOrCreate(
                ['code' => $definition['code']],
                $definition,
            );

            return [$definition['code'] => $department];
        })->all();
    }

    private function seedStaff(array $departments): array
    {
        $staff = [
            'doctor' => [
                'name' => 'Dr. Grace Wanjiku',
                'email' => 'grace.wanjiku@example.com',
                'employee_number' => 'EMP-DR-001',
                'specialization' => 'General Medicine',
                'role' => 'Doctor',
                'department_id' => $departments['OPD']->id,
                'gender' => 'Female',
            ],
            'nurse' => [
                'name' => 'Jane Akinyi',
                'email' => 'jane.akinyi@example.com',
                'employee_number' => 'EMP-NR-001',
                'specialization' => 'Triage Nurse',
                'role' => 'Nurse',
                'department_id' => $departments['NUR']->id,
                'gender' => 'Female',
            ],
            'receptionist' => [
                'name' => 'Rose Njeri',
                'email' => 'rose.njeri@example.com',
                'employee_number' => 'EMP-RC-001',
                'specialization' => null,
                'role' => 'Receptionist',
                'department_id' => $departments['OPD']->id,
                'gender' => 'Female',
            ],
            'pharmacist' => [
                'name' => 'Peter Otieno',
                'email' => 'peter.otieno@example.com',
                'employee_number' => 'EMP-PH-001',
                'specialization' => 'Pharmacy Operations',
                'role' => 'Pharmacist',
                'department_id' => $departments['PHA']->id,
                'gender' => 'Male',
            ],
            'lab' => [
                'name' => 'David Karanja',
                'email' => 'david.karanja@example.com',
                'employee_number' => 'EMP-LB-001',
                'specialization' => 'Laboratory Technician',
                'role' => 'Lab Technician',
                'department_id' => $departments['LAB']->id,
                'gender' => 'Male',
            ],
            'accountant' => [
                'name' => 'Susan Cherono',
                'email' => 'susan.cherono@example.com',
                'employee_number' => 'EMP-AC-001',
                'specialization' => 'Accounts',
                'role' => 'Accountant',
                'department_id' => $departments['ACC']->id,
                'gender' => 'Female',
            ],
            'cashier' => [
                'name' => 'Moses Tembula',
                'email' => 'moses.tembula@example.com',
                'employee_number' => 'EMP-CS-001',
                'specialization' => 'Cashier',
                'role' => 'Cashier',
                'department_id' => $departments['ACC']->id,
                'gender' => 'Male',
            ],
            'admin' => [
                'name' => 'System Admin',
                'email' => 'admin@example.com',
                'employee_number' => 'EMP-SA-001',
                'specialization' => 'Administration',
                'role' => 'Super Admin',
                'department_id' => $departments['OPD']->id,
                'gender' => 'Male',
            ],
        ];

        return collect($staff)->mapWithKeys(function (array $definition, string $key): array {
            $user = User::updateOrCreate(
                ['email' => $definition['email']],
                [
                    'name' => $definition['name'],
                    'password' => 'password',
                    'employee_number' => $definition['employee_number'],
                    'specialization' => $definition['specialization'],
                    'department_id' => $definition['department_id'],
                    'gender' => $definition['gender'],
                    'active' => true,
                ],
            );

            $user->syncRoles([$definition['role']]);

            return [$key => $user];
        })->all();
    }

    private function seedPatients(): array
    {
        $patients = [
            [
                'patient_number' => 'PT-1001',
                'first_name' => 'Moses',
                'last_name' => 'Tembula',
                'date_of_birth' => '1988-04-12',
                'gender' => 'Male',
                'phone' => '0712000001',
                'email' => 'moses.tembula.patient@example.com',
                'address' => 'Kisumu, Kenya',
                'blood_group' => 'O+',
                'insurance_provider' => 'NHIF',
                'insurance_number' => 'NHIF-1001',
            ],
            [
                'patient_number' => 'PT-1002',
                'first_name' => 'Amina',
                'last_name' => 'Nassir',
                'date_of_birth' => '1993-09-21',
                'gender' => 'Female',
                'phone' => '0712000002',
                'email' => 'amina.nassir@example.com',
                'address' => 'Mombasa, Kenya',
                'blood_group' => 'A+',
                'insurance_provider' => 'AAR',
                'insurance_number' => 'AAR-1002',
            ],
            [
                'patient_number' => 'PT-1003',
                'first_name' => 'Joel',
                'last_name' => 'Githaiga',
                'date_of_birth' => '1979-02-03',
                'gender' => 'Male',
                'phone' => '0712000003',
                'email' => 'joel.githaiga@example.com',
                'address' => 'Nairobi, Kenya',
                'blood_group' => 'B+',
                'insurance_provider' => null,
                'insurance_number' => null,
            ],
            [
                'patient_number' => 'PT-1004',
                'first_name' => 'Faith',
                'last_name' => 'Muthoni',
                'date_of_birth' => '2001-11-15',
                'gender' => 'Female',
                'phone' => '0712000004',
                'email' => 'faith.muthoni@example.com',
                'address' => 'Eldoret, Kenya',
                'blood_group' => 'AB+',
                'insurance_provider' => 'Jubilee',
                'insurance_number' => 'JUB-1004',
            ],
            [
                'patient_number' => 'PT-1005',
                'first_name' => 'Brian',
                'last_name' => 'Odhiambo',
                'date_of_birth' => '1990-07-08',
                'gender' => 'Male',
                'phone' => '0712000005',
                'email' => 'brian.odhiambo@example.com',
                'address' => 'Nakuru, Kenya',
                'blood_group' => 'O-',
                'insurance_provider' => 'NHIF',
                'insurance_number' => 'NHIF-1005',
            ],
        ];

        return collect($patients)->mapWithKeys(function (array $definition): array {
            $patient = Patient::updateOrCreate(
                ['patient_number' => $definition['patient_number']],
                $definition,
            );

            return [$definition['patient_number'] => $patient];
        })->all();
    }

    private function seedMedicines(): array
    {
        $medicines = [
            ['name' => 'Paracetamol 500mg', 'generic_name' => 'Paracetamol', 'stock_quantity' => 240, 'selling_price' => 20, 'expiry_date' => '2027-06-30'],
            ['name' => 'Amoxicillin 500mg', 'generic_name' => 'Amoxicillin', 'stock_quantity' => 180, 'selling_price' => 45, 'expiry_date' => '2027-03-31'],
            ['name' => 'Cetirizine 10mg', 'generic_name' => 'Cetirizine', 'stock_quantity' => 300, 'selling_price' => 15, 'expiry_date' => '2028-01-31'],
            ['name' => 'Metformin 500mg', 'generic_name' => 'Metformin', 'stock_quantity' => 150, 'selling_price' => 60, 'expiry_date' => '2027-10-31'],
            ['name' => 'Ibuprofen 400mg', 'generic_name' => 'Ibuprofen', 'stock_quantity' => 210, 'selling_price' => 25, 'expiry_date' => '2027-08-31'],
        ];

        return collect($medicines)->mapWithKeys(function (array $definition): array {
            $medicine = Medicine::updateOrCreate(
                ['name' => $definition['name']],
                $definition,
            );

            return [$definition['name'] => $medicine];
        })->all();
    }

    private function seedLabTests(): array
    {
        $labTests = [
            ['name' => 'Full Blood Count', 'price' => 700],
            ['name' => 'Urinalysis', 'price' => 350],
            ['name' => 'Malaria Test', 'price' => 500],
            ['name' => 'Random Blood Sugar', 'price' => 450],
        ];

        return collect($labTests)->mapWithKeys(function (array $definition): array {
            $labTest = LabTest::updateOrCreate(
                ['name' => $definition['name']],
                $definition,
            );

            return [$definition['name'] => $labTest];
        })->all();
    }

    private function seedAppointments(array $patients, User $doctor, User $receptionist): array
    {
        $definitions = [
            ['patient' => $patients['PT-1001'], 'date' => '2026-05-16 09:00:00', 'status' => 'confirmed', 'notes' => 'First visit for fever and chills.'],
            ['patient' => $patients['PT-1002'], 'date' => '2026-05-16 10:30:00', 'status' => 'pending', 'notes' => 'Review of recurring allergies.'],
            ['patient' => $patients['PT-1003'], 'date' => '2026-05-16 13:00:00', 'status' => 'confirmed', 'notes' => 'Diabetes follow-up.'],
        ];

        return collect($definitions)->map(function (array $definition) use ($doctor, $receptionist): Appointment {
            $appointmentTime = Carbon::parse($definition['date'])->toDateTimeString();

            return Appointment::updateOrCreate(
                [
                    'patient_id' => $definition['patient']->id,
                    'doctor_id' => $doctor->id,
                    'appointment_time' => $appointmentTime,
                ],
                [
                    'patient_id' => $definition['patient']->id,
                    'doctor_id' => $doctor->id,
                    'appointment_time' => $appointmentTime,
                    'status' => $definition['status'],
                    'notes' => $definition['notes'],
                ],
            );
        })->all();
    }

    /**
     * @return array<int, Visit>
     */
    private function seedVisits(array $patients, User $doctor): array
    {
        $definitions = [
            ['number' => 'VST-1001', 'patient' => $patients['PT-1001'], 'status' => 'consultation', 'chief_complaint' => 'Fever, chills, and headache.'],
            ['number' => 'VST-1002', 'patient' => $patients['PT-1002'], 'status' => 'lab', 'chief_complaint' => 'Persistent cough and fatigue.'],
            ['number' => 'VST-1003', 'patient' => $patients['PT-1003'], 'status' => 'pharmacy', 'chief_complaint' => 'Diabetes follow-up and medication refill.'],
            ['number' => 'VST-1004', 'patient' => $patients['PT-1004'], 'status' => 'completed', 'chief_complaint' => 'Routine review after treatment.'],
        ];

        return collect($definitions)->map(function (array $definition) use ($doctor): Visit {
            return Visit::updateOrCreate(
                ['visit_number' => $definition['number']],
                [
                    'patient_id' => $definition['patient']->id,
                    'doctor_id' => $doctor->id,
                    'visit_number' => $definition['number'],
                    'status' => $definition['status'],
                    'chief_complaint' => $definition['chief_complaint'],
                ],
            );
        })->all();
    }

    private function seedClinicalWorkflow(array $visits, User $nurse, User $doctor, array $medicines, array $labTests): void
    {
        $triageData = [
            ['visit' => $visits[0], 'temperature' => 38.40, 'systolic' => 130, 'diastolic' => 84, 'pulse' => 96, 'weight' => 70.5, 'height' => 1.72],
            ['visit' => $visits[1], 'temperature' => 37.80, 'systolic' => 124, 'diastolic' => 80, 'pulse' => 88, 'weight' => 63.2, 'height' => 1.65],
            ['visit' => $visits[2], 'temperature' => 36.90, 'systolic' => 140, 'diastolic' => 90, 'pulse' => 92, 'weight' => 81.0, 'height' => 1.70],
            ['visit' => $visits[3], 'temperature' => 36.70, 'systolic' => 118, 'diastolic' => 76, 'pulse' => 78, 'weight' => 58.4, 'height' => 1.60],
        ];

        foreach ($triageData as $definition) {
            NurseTriage::updateOrCreate(
                ['visit_id' => $definition['visit']->id],
                [
                    'visit_id' => $definition['visit']->id,
                    'temperature' => $definition['temperature'],
                    'blood_pressure_systolic' => $definition['systolic'],
                    'blood_pressure_diastolic' => $definition['diastolic'],
                    'pulse_rate' => $definition['pulse'],
                    'weight' => $definition['weight'],
                    'height' => $definition['height'],
                ],
            );
        }

        $notes = [
            ['visit' => $visits[0], 'assessment' => 'Acute febrile illness. Patient appears moderately unwell.', 'diagnosis' => 'Likely malaria-like febrile illness pending lab results.', 'plan' => 'Start antipyretics, request malaria test, review in 24 hours.'],
            ['visit' => $visits[1], 'assessment' => 'Respiratory symptoms with mild chest congestion.', 'diagnosis' => 'Upper respiratory tract infection.', 'plan' => 'Symptomatic care and laboratory review.'],
            ['visit' => $visits[2], 'assessment' => 'Known diabetic patient stable on follow-up.', 'diagnosis' => 'Type 2 diabetes mellitus, controlled.', 'plan' => 'Continue current medication and diet control.'],
            ['visit' => $visits[3], 'assessment' => 'Routine review, no acute complaints.', 'diagnosis' => 'Recovered. No active issue.', 'plan' => 'Discharge with advice.'],
        ];

        foreach ($notes as $definition) {
            DoctorNote::updateOrCreate(
                ['visit_id' => $definition['visit']->id],
                [
                    'visit_id' => $definition['visit']->id,
                    'assessment' => $definition['assessment'],
                    'diagnosis' => $definition['diagnosis'],
                    'plan' => $definition['plan'],
                ],
            );
        }

        $prescriptions = [];
        foreach ([$visits[0], $visits[2], $visits[3]] as $index => $visit) {
            $prescriptions[] = Prescription::updateOrCreate(
                ['visit_id' => $visit->id],
                [
                    'visit_id' => $visit->id,
                    'doctor_id' => $doctor->id,
                ],
            );
        }

        $prescriptionItems = [
            [
                'prescription' => $prescriptions[0],
                'items' => [
                    ['medicine' => $medicines['Paracetamol 500mg'], 'dosage' => '1 tablet', 'frequency' => '3 times daily', 'days' => 5],
                    ['medicine' => $medicines['Ibuprofen 400mg'], 'dosage' => '1 tablet', 'frequency' => '2 times daily', 'days' => 3],
                ],
            ],
            [
                'prescription' => $prescriptions[1],
                'items' => [
                    ['medicine' => $medicines['Metformin 500mg'], 'dosage' => '1 tablet', 'frequency' => '2 times daily', 'days' => 30],
                    ['medicine' => $medicines['Cetirizine 10mg'], 'dosage' => '1 tablet', 'frequency' => 'Once daily', 'days' => 7],
                ],
            ],
            [
                'prescription' => $prescriptions[2],
                'items' => [
                    ['medicine' => $medicines['Amoxicillin 500mg'], 'dosage' => '1 capsule', 'frequency' => '3 times daily', 'days' => 7],
                ],
            ],
        ];

        foreach ($prescriptionItems as $definition) {
            foreach ($definition['items'] as $item) {
                PrescriptionItem::updateOrCreate(
                    [
                        'prescription_id' => $definition['prescription']->id,
                        'drug_id' => $item['medicine']->id,
                    ],
                    [
                        'prescription_id' => $definition['prescription']->id,
                        'drug_id' => $item['medicine']->id,
                        'dosage' => $item['dosage'],
                        'frequency' => $item['frequency'],
                        'days' => $item['days'],
                    ],
                );
            }
        }

        $labRequests = [
            ['visit' => $visits[0], 'lab_test' => $labTests['Malaria Test'], 'status' => 'completed', 'result' => 'Positive for malaria parasites.'],
            ['visit' => $visits[1], 'lab_test' => $labTests['Full Blood Count'], 'status' => 'in_progress', 'result' => null],
            ['visit' => $visits[3], 'lab_test' => $labTests['Random Blood Sugar'], 'status' => 'completed', 'result' => 'Blood sugar within normal range.'],
        ];

        foreach ($labRequests as $definition) {
            LabRequest::updateOrCreate(
                [
                    'visit_id' => $definition['visit']->id,
                    'lab_test_id' => $definition['lab_test']->id,
                ],
                [
                    'visit_id' => $definition['visit']->id,
                    'lab_test_id' => $definition['lab_test']->id,
                    'status' => $definition['status'],
                    'result' => $definition['result'],
                ],
            );
        }
    }

    private function seedBilling(array $visits, array $patients): void
    {
        $definitions = [
            ['visit' => $visits[0], 'patient' => $patients['PT-1001'], 'total' => 2500, 'paid' => 1000, 'status' => 'partial'],
            ['visit' => $visits[1], 'patient' => $patients['PT-1002'], 'total' => 1800, 'paid' => 0, 'status' => 'unpaid'],
            ['visit' => $visits[2], 'patient' => $patients['PT-1003'], 'total' => 4200, 'paid' => 4200, 'status' => 'paid'],
            ['visit' => $visits[3], 'patient' => $patients['PT-1004'], 'total' => 1200, 'paid' => 1200, 'status' => 'paid'],
        ];

        foreach ($definitions as $definition) {
            $balance = $definition['total'] - $definition['paid'];
            $billing = Billing::updateOrCreate(
                ['visit_id' => $definition['visit']->id],
                [
                    'patient_id' => $definition['patient']->id,
                    'visit_id' => $definition['visit']->id,
                    'total_amount' => $definition['total'],
                    'paid_amount' => $definition['paid'],
                    'balance' => $balance,
                    'status' => $definition['status'],
                ],
            );

            if ($definition['paid'] > 0) {
                Payment::updateOrCreate(
                    ['billing_id' => $billing->id],
                    [
                        'billing_id' => $billing->id,
                        'amount' => $definition['paid'],
                        'payment_method' => $definition['paid'] === $definition['total'] ? 'cash' : 'mobile_money',
                        'reference' => 'PAY-' . $definition['visit']->visit_number,
                    ],
                );
            }
        }
    }
}
