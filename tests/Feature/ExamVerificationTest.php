<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Membership;
use App\Models\ExamSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ExamVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected $fatherMembership;
    protected $motherMembership;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        // Create Father member & volunteer
        $this->fatherMembership = Membership::create([
            'membership_id' => '602505286340',
            'phone' => '9876543210',
            'full_name' => 'SRI RAMA SHARMA',
            'payment_status' => 'success',
            'is_completed' => true,
        ]);

        Volunteer::create([
            'membership_id' => '602505286340',
            'phone' => '9876543210',
            'qualification' => 'Graduate',
            'voter_id_number' => 'ABC1234567',
            'email' => 'father@example.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'SRI RAMA SHARMA',
            'account_number' => '1234567890',
            'ifsc_code' => 'SBIN0001234',
            'branch_name' => 'Kadapa',
            'nominee_name' => 'Sita',
            'nominee_relation' => 'Wife',
            'nominee_phone' => '9876543211',
            'document_declaration_path' => 'doc.pdf',
            'document_voter_path' => 'voter.pdf',
            'document_bank_path' => 'bank.pdf',
            'status' => 'approved',
            'volunteer_id' => '662424',
        ]);

        // Create Mother member
        $this->motherMembership = Membership::create([
            'membership_id' => '915000111222',
            'phone' => '9876543212',
            'full_name' => 'SITA DEVI SHARMA',
            'payment_status' => 'success',
            'is_completed' => true,
        ]);

        // Create an exam cycle
        ExamSetting::create([
            'exam_title' => 'Sanathana Dharma Youth Examination',
            'syllabus_pdf_path' => 'exams/syllabus/sample.pdf',
            'prize_details_json' => json_encode(['1st: Tablet', '2nd: TV']),
            'exam_date_time' => now()->addDays(30),
            'exam_center_location' => 'Kadapa Central',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);
    }

    /**
     * Test Step 1 & 2: Check membership ID endpoint returns valid name or clear error
     */
    public function test_check_membership_id_returns_valid_for_registered_volunteer_and_member(): void
    {
        // 1. Father (Volunteer)
        $resFather = $this->postJson(route('exam.check_membership'), [
            'membership_id' => '602505286340'
        ]);
        $resFather->assertStatus(200);
        $resFather->assertJson([
            'status' => 'valid',
            'name' => 'SRI RAMA SHARMA'
        ]);

        // 2. Mother (Member)
        $resMother = $this->postJson(route('exam.check_membership'), [
            'membership_id' => '915000111222'
        ]);
        $resMother->assertStatus(200);
        $resMother->assertJson([
            'status' => 'valid',
            'name' => 'SITA DEVI SHARMA'
        ]);

        // 3. Invalid ID
        $resInvalid = $this->postJson(route('exam.check_membership'), [
            'membership_id' => '000000111999'
        ]);
        $resInvalid->assertStatus(200);
        $resInvalid->assertJson([
            'status' => 'invalid',
            'message' => 'ID not found — not a registered ABVHPS member or volunteer.'
        ]);
    }

    /**
     * Test Mandatory Gate: Payment simulation blocked if only one parent is verified or invalid
     */
    public function test_payment_simulation_blocked_unless_both_parents_are_verified(): void
    {
        // Blocked case 1: Only father valid, mother invalid
        $res1 = $this->postJson(route('exam.process_payment'), [
            'guardian_type' => 'parents',
            'father_membership_id' => '602505286340',
            'mother_membership_id' => '000000111999', // Invalid
        ]);
        $res1->assertStatus(422);
        $res1->assertJson(['success' => false]);

        // Blocked case 2: Both invalid
        $res2 = $this->postJson(route('exam.process_payment'), [
            'guardian_type' => 'parents',
            'father_membership_id' => '000000111888',
            'mother_membership_id' => '000000111999',
        ]);
        $res2->assertStatus(422);

        // Success case: Both Father and Mother verified
        $resSuccess = $this->postJson(route('exam.process_payment'), [
            'guardian_type' => 'parents',
            'father_membership_id' => '602505286340',
            'mother_membership_id' => '915000111222',
        ]);
        $resSuccess->assertStatus(200);
        $resSuccess->assertJson(['success' => true]);
        $this->assertNotEmpty($resSuccess->json('transaction_id'));
    }

    /**
     * Test Mandatory Gate: Final application submission blocked server-side if invalid parent IDs
     */
    public function test_final_application_submission_enforces_mandatory_parent_verification(): void
    {
        // Set email verified in session
        $sessionData = [
            'exam_email_verified_status' => true,
            'exam_email_target' => 'student@example.com'
        ];

        // Attempt submission with invalid mother ID
        $resBlocked = $this->withSession($sessionData)->postJson(route('exam.submit'), [
            'exam_setting_id' => 1,
            'email' => 'student@example.com',
            'full_name' => 'Candidate Sharma',
            'dob' => '2010-05-15',
            'address' => 'Porumamilla, Kadapa',
            'mobile' => '9876543210',
            'guardian_type' => 'parents',
            'father_membership_id' => '602505286340',
            'mother_membership_id' => '000000000000', // Invalid ID
            'father_name' => 'SRI RAMA SHARMA',
            'mother_name' => 'Invalid Mother',
            'school_college_name' => 'ZPHS School',
            'photo' => UploadedFile::fake()->create('student.jpg', 100, 'image/jpeg'),
            'id_card_or_signature' => UploadedFile::fake()->create('idcard.jpg', 100, 'image/jpeg'),
            'payment_transaction_id' => 'TXN_TEST_123',
        ]);
        $resBlocked->assertStatus(422);
        $resBlocked->assertJson(['success' => false]);
        $this->assertDatabaseMissing('exam_applications', ['email' => 'student@example.com']);

        // Attempt submission with BOTH valid IDs
        $resAllowed = $this->withSession($sessionData)->postJson(route('exam.submit'), [
            'exam_setting_id' => 1,
            'email' => 'student@example.com',
            'full_name' => 'Candidate Sharma',
            'dob' => '2010-05-15',
            'address' => 'Porumamilla, Kadapa',
            'mobile' => '9876543210',
            'guardian_type' => 'parents',
            'father_membership_id' => '602505286340',
            'mother_membership_id' => '915000111222',
            'father_name' => 'SRI RAMA SHARMA',
            'mother_name' => 'SITA DEVI SHARMA',
            'school_college_name' => 'ZPHS School',
            'photo' => UploadedFile::fake()->image('student.jpg', 100, 100),
            'id_card_or_signature' => UploadedFile::fake()->image('idcard.jpg', 100, 100),
            'payment_transaction_id' => 'TXN_TEST_123',
        ]);
        $resAllowed->assertStatus(200);
        $resAllowed->assertJson(['success' => true]);

        $this->assertDatabaseHas('exam_applications', [
            'email' => 'student@example.com',
            'full_name' => 'Candidate Sharma',
            'father_membership_id' => '602505286340',
            'mother_membership_id' => '915000111222',
            'payment_status' => 'success',
        ]);
    }

    /**
     * Test Complete Flow: Submitting application generates unique 11-digit hall ticket and renders exam_success_notice
     */
    public function test_full_application_submission_generates_hall_ticket_and_renders_success_view(): void
    {
        $sessionData = [
            'exam_email_verified_status' => true,
            'exam_email_target' => 'konda@gmail.com'
        ];

        $submitRes = $this->withSession($sessionData)->postJson(route('exam.submit'), [
            'exam_setting_id' => 1,
            'email' => 'konda@gmail.com',
            'full_name' => 'KONDA REDDY',
            'dob' => '2006-03-25',
            'address' => 'Porumamilla, YSR Kadapa',
            'mobile' => '9876543210',
            'aadhaar_no' => '123456789012',
            'guardian_type' => 'parents',
            'father_membership_id' => '602505286340',
            'mother_membership_id' => '915000111222',
            'father_name' => 'SRI RAMA SHARMA',
            'mother_name' => 'SITA DEVI SHARMA',
            'school_college_name' => 'ZPHS High School Porumamilla',
            'class_section' => '10th Class - A',
            'photo' => UploadedFile::fake()->image('konda.jpg', 100, 100),
            'id_card_or_signature' => UploadedFile::fake()->image('school_id.jpg', 100, 100),
            'payment_transaction_id' => 'TXN_GATEWAY_SUCCESS_001',
        ]);

        $submitRes->assertStatus(200);
        $submitRes->assertJson(['success' => true]);

        $redirectUrl = $submitRes->json('redirect_url');
        $this->assertNotEmpty($redirectUrl);

        // Fetch application from DB
        $app = \DB::table('exam_applications')->where('email', 'konda@gmail.com')->first();
        $this->assertNotNull($app);
        $this->assertEquals('KONDA REDDY', $app->full_name);
        $this->assertEquals(11, strlen($app->hall_ticket_number));
        $this->assertEquals('success', $app->payment_status);

        // Follow redirect to success notice / hall ticket page
        $successPageRes = $this->get($redirectUrl);
        $successPageRes->assertStatus(200);
        $successPageRes->assertSee('Application Secured & Verified!', false);
        $successPageRes->assertSee($app->hall_ticket_number);
        $successPageRes->assertSee('KONDA REDDY');
        $successPageRes->assertSee('ZPHS High School Porumamilla');
    }
}

