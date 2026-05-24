<?php

namespace Tests\Feature;

use App\Filament\Support\PaymentStatus;
use App\Models\Billing;
use App\Models\Department;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Prescription;
use App\Models\User;
use App\Models\Visit;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HospitalManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_demo_doctors_and_nurses_are_seeded_with_qualifications(): void
    {
        $doctor = User::query()->where('email', 'grace.wanjiku@example.com')->first();
        $nurse = User::query()->where('email', 'jane.akinyi@example.com')->first();

        $this->assertNotNull($doctor);
        $this->assertNotNull($nurse);
        $this->assertTrue($doctor->hasRole('Doctor'));
        $this->assertTrue($nurse->hasRole('Nurse'));
        $this->assertSame('General Medicine', $doctor->specialization);
        $this->assertNotNull($doctor->department_id);
    }

    public function test_doctor_scope_returns_only_doctors(): void
    {
        $doctorCount = User::query()->role('Doctor')->count();
        $nurseCount = User::query()->role('Nurse')->count();

        $this->assertGreaterThanOrEqual(1, $doctorCount);
        $this->assertGreaterThanOrEqual(1, $nurseCount);
        $this->assertNotSame($doctorCount, User::query()->count());
    }

    public function test_patient_number_is_auto_generated(): void
    {
        $patient = Patient::create([
            'first_name' => 'Test',
            'last_name' => 'Patient',
            'gender' => 'Male',
        ]);

        $this->assertNotNull($patient->patient_number);
        $this->assertStringStartsWith('PT-', $patient->patient_number);
    }

    public function test_prescription_can_have_items(): void
    {
        $prescription = Prescription::query()->with('items')->first();

        $this->assertNotNull($prescription);
        $this->assertGreaterThan(0, $prescription->items->count());
    }

    public function test_department_has_staff(): void
    {
        $department = Department::query()->where('code', 'OPD')->first();

        $this->assertNotNull($department);
        $this->assertGreaterThan(0, $department->users()->count());
    }

    public function test_authenticated_admin_can_open_admin_panel(): void
    {
        $admin = User::query()->where('email', 'admin@example.com')->first();

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
    }

    public function test_payment_updates_billing_and_patient_status(): void
    {
        $patient = Patient::query()->where('patient_number', 'PT-1001')->first();
        $billing = Billing::query()->where('patient_id', $patient->id)->first();

        $this->assertNotNull($billing);
        $this->assertSame('partial', $billing->status);

        Payment::create([
            'billing_id' => $billing->id,
            'amount' => $billing->balance,
            'payment_method' => 'cash',
            'reference' => 'TEST-PAY-001',
            'paid_at' => now(),
        ]);

        $billing->refresh();
        $patient->unsetRelation('billings');

        $this->assertSame('paid', $billing->status);
        $this->assertEquals(0, (float) $billing->balance);
        $this->assertSame(PaymentStatus::PAID, $patient->payment_status);
    }

    public function test_patient_can_have_medical_history(): void
    {
        $patient = Patient::query()->where('patient_number', 'PT-1001')->first();
        $user = User::query()->where('email', 'admin@example.com')->first();

        $history = MedicalHistory::create([
            'patient_id' => $patient->id,
            'recorded_by_id' => $user->id,
            'recorded_at' => now(),
            'presenting_complaint' => 'Fever for 3 days',
            'history_of_presenting_illness' => 'Onset 3 days ago with evening spikes.',
            'past_medical_history' => 'No chronic illness reported.',
            'allergies' => 'None known',
        ]);

        $patient->load('medicalHistories', 'doctorNotes', 'nurseTriages', 'prescriptions.items');

        $this->assertTrue($patient->medicalHistories->contains($history));
        $this->assertGreaterThan(0, $patient->doctorNotes->count());
        $this->assertGreaterThan(0, $patient->nurseTriages->count());
    }

    public function test_visit_creation_auto_creates_billing(): void
    {
        $patient = Patient::query()->first();
        $doctor = User::query()->role('Doctor')->first();

        $visit = Visit::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'status' => 'waiting',
            'chief_complaint' => 'Routine check',
        ]);

        $this->assertNotNull($visit->billing);
        $this->assertSame($patient->id, $visit->billing->patient_id);
        $this->assertSame('unpaid', $visit->billing->status);
    }

    public function test_deleting_patient_soft_deletes_record(): void
    {
        $patient = Patient::query()->first();
        $patientId = $patient->id;

        $patient->delete();

        $this->assertSoftDeleted('patients', ['id' => $patientId]);
        $this->assertNull(Patient::query()->find($patientId));
        $this->assertNotNull(Patient::withTrashed()->find($patientId));

        Patient::withTrashed()->find($patientId)?->restore();

        $this->assertNotNull(Patient::query()->find($patientId));
    }
}
