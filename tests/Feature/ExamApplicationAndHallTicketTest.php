<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\ExamSetting;
use App\Models\ExamApplication;
use App\Models\Membership;

class ExamApplicationAndHallTicketTest extends TestCase
{
    use RefreshDatabase;

    protected ExamSetting $examA;
    protected ExamSetting $examB;
    protected Membership $father;
    protected Membership $mother;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        // Create sample syllabus files in fake storage
        Storage::disk('public')->put('exams/syllabus/syllabus_a.pdf', '%PDF-1.4 Syllabus A Content');
        Storage::disk('public')->put('exams/syllabus/syllabus_b.pdf', '%PDF-1.4 Syllabus B Content');

        // 1. Exam A (MCQ, ₹41)
        $this->examA = ExamSetting::create([
            'exam_title' => 'Sanathana Dharma MCQ Exam',
            'exam_type' => 'mcq',
            'syllabus_pdf_path' => 'exams/syllabus/syllabus_a.pdf',
            'prize_details_json' => json_encode(['1st Prize - Gold Medal (A)', '2nd Prize - Silver (A)']),
            'exam_date_time' => '2026-11-20 10:00:00',
            'exam_center_location' => 'Porumamilla Center',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        // 2. Exam B (Theory, ₹50)
        $this->examB = ExamSetting::create([
            'exam_title' => 'Sanathana Dharma Theory Exam',
            'exam_type' => 'theory',
            'syllabus_pdf_path' => 'exams/syllabus/syllabus_b.pdf',
            'prize_details_json' => json_encode(['1st Prize - Laptop (B)', '2nd Prize - Cash ₹5000 (B)']),
            'exam_date_time' => '2026-11-25 10:00:00',
            'exam_center_location' => 'Kadapa Central',
            'application_fee' => 50.00,
            'status' => 'active',
        ]);

        // 3. Verified Parents
        $this->father = Membership::create([
            'membership_id' => '111111222222',
            'full_name' => 'FATHER RAMA RAO',
            'payment_status' => 'success',
            'is_completed' => 1,
            'phone' => '9876543210',
        ]);

        $this->mother = Membership::create([
            'membership_id' => '333333444444',
            'full_name' => 'MOTHER SITA DEVI',
            'payment_status' => 'success',
            'is_completed' => 1,
            'phone' => '9876543211',
        ]);
    }

    /**
     * 1. User must select a valid exam before application submission.
     */
    public function test_missing_or_invalid_exam_setting_id_is_rejected(): void
    {
        $this->withSession(['exam_email_verified_status' => true]);

        $res = $this->postJson(route('exam.submit'), [
            'exam_setting_id' => 99999, // Non-existent
            'email' => 'student@test.com',
            'full_name' => 'Student One',
            'dob' => '2008-05-15',
            'address' => 'Porumamilla',
            'mobile' => '9988776655',
            'guardian_type' => 'parents',
            'father_membership_id' => $this->father->membership_id,
            'mother_membership_id' => $this->mother->membership_id,
            'school_college_name' => 'Govt High School',
            'photo' => UploadedFile::fake()->image('photo.jpg', 100, 100),
            'id_card_or_signature' => UploadedFile::fake()->create('id.pdf', 100),
            'payment_transaction_id' => 'TXN123456'
        ]);

        $res->assertStatus(422);
    }

    /**
     * 2. Successful application generates an exact 11-digit randomized Hall Ticket Number.
     */
    public function test_successful_application_generates_11_digit_numeric_hall_ticket(): void
    {
        $this->withSession(['exam_email_verified_status' => true]);

        $res = $this->postJson(route('exam.submit'), [
            'exam_setting_id' => $this->examA->id,
            'email' => 'student_mcq@test.com',
            'full_name' => 'Student Candidate',
            'dob' => '2008-05-15',
            'address' => 'Porumamilla, Kadapa',
            'mobile' => '9988776655',
            'guardian_type' => 'parents',
            'father_membership_id' => $this->father->membership_id,
            'father_name' => 'Rama Rao',
            'mother_membership_id' => $this->mother->membership_id,
            'mother_name' => 'Sita Devi',
            'school_college_name' => 'ZPHS Porumamilla',
            'class_section' => '10th A',
            'photo' => UploadedFile::fake()->image('photo.jpg', 100, 100),
            'id_card_or_signature' => UploadedFile::fake()->create('id.pdf', 100),
            'payment_transaction_id' => 'TXN99881122'
        ]);

        $res->assertStatus(200);
        $res->assertJson(['success' => true]);

        $application = ExamApplication::where('email', 'student_mcq@test.com')->first();
        $this->assertNotNull($application);
        $this->assertEquals($this->examA->id, $application->exam_setting_id);

        // Verify Hall Ticket Number
        $ticket = $application->hall_ticket_number;
        $this->assertNotNull($ticket);
        $this->assertEquals(11, strlen($ticket), "Hall Ticket Number must be exactly 11 digits");
        $this->assertMatchesRegularExpression('/^[0-9]{11}$/', $ticket, "Hall Ticket Number must be numeric");
        $this->assertNotEquals((string)$application->id, $ticket, "Hall Ticket Number must NOT equal the database primary key");
    }

    /**
     * 3. Digital Hall Ticket success notice displays the 11-digit Hall Ticket Number, ABVHPS Logo and no candidate Application ID leakage.
     */
    public function test_success_page_displays_hall_ticket_number_prominently(): void
    {
        $application = ExamApplication::create([
            'exam_setting_id' => $this->examA->id,
            'email' => 'candidate@abvhps.org',
            'full_name' => 'CHANDRA SEKHAR',
            'dob' => '2007-06-10',
            'mobile' => '9988112233',
            'hall_ticket_number' => '58374291640',
            'payment_status' => 'success',
            'amount_paid' => 41.00,
        ]);

        $res = $this->get(route('exam.success', ['id' => $application->id]));
        $res->assertStatus(200);

        $res->assertSee('58374291640');
        $res->assertSee('ABVHPS_LOGO.jpg');
        $res->assertDontSee('Application ID');
        $res->assertSee('Sanathana Dharma MCQ Exam');
        $res->assertSee('MCQ');
    }

    /**
     * 4. Exam selection on application page isolates exam information and prizes.
     */
    public function test_application_page_renders_selected_exam_prizes_and_type(): void
    {
        // View Exam A (MCQ)
        $resA = $this->get(route('exam.form', ['exam_id' => $this->examA->id]));
        $resA->assertStatus(200);
        $resA->assertSee('Sanathana Dharma MCQ Exam');
        $resA->assertSee('MCQ Exam');
        $resA->assertSee('1st Prize - Gold Medal (A)');
        $resA->assertDontSee('1st Prize - Laptop (B)');

        // View Exam B (Theory)
        $resB = $this->get(route('exam.form', ['exam_id' => $this->examB->id]));
        $resB->assertStatus(200);
        $resB->assertSee('Sanathana Dharma Theory Exam');
        $resB->assertSee('Theory Exam');
        $resB->assertSee('1st Prize - Laptop (B)');
        $resB->assertDontSee('1st Prize - Gold Medal (A)');
    }

    /**
     * 5. Syllabus download serves the exact syllabus associated with the applicant's exam.
     */
    public function test_syllabus_download_serves_correct_file_for_exam(): void
    {
        $appA = ExamApplication::create([
            'exam_setting_id' => $this->examA->id,
            'email' => 'studentA@test.com',
            'full_name' => 'Candidate A',
            'hall_ticket_number' => '58374291641',
            'payment_status' => 'success',
        ]);

        $res = $this->get(route('exam.download_syllabus', ['id' => $appA->id]));
        $res->assertStatus(200);
        $this->assertEquals('application/pdf', $res->headers->get('Content-Type'));
        $this->assertStringContainsString('attachment', $res->headers->get('Content-Disposition'));
    }

    /**
     * 6. Missing syllabus file returns clean error message without exposing server paths.
     */
    public function test_missing_syllabus_returns_safe_error(): void
    {
        $examNoFile = ExamSetting::create([
            'exam_title' => 'Exam Without File',
            'exam_type' => 'mcq',
            'syllabus_pdf_path' => 'exams/syllabus/non_existent_file.pdf',
            'prize_details_json' => json_encode([]),
            'exam_date_time' => '2026-11-20 10:00:00',
            'exam_center_location' => 'Kadapa',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $app = ExamApplication::create([
            'exam_setting_id' => $examNoFile->id,
            'email' => 'student_nofile@test.com',
            'full_name' => 'Candidate No File',
            'hall_ticket_number' => '58374291642',
            'payment_status' => 'success',
        ]);

        $res = $this->get(route('exam.download_syllabus', ['id' => $app->id]));
        $res->assertRedirect();
        $res->assertSessionHas('error', 'Syllabus is currently unavailable. Please contact the examination desk.');
    }

    /**
     * 7. Legacy applications without hall ticket numbers receive an 11-digit number on view.
     */
    public function test_legacy_application_receives_11_digit_hall_ticket_on_view(): void
    {
        $legacyApp = ExamApplication::create([
            'exam_setting_id' => $this->examA->id,
            'email' => 'legacy_student@test.com',
            'full_name' => 'LEGACY CANDIDATE',
            'hall_ticket_number' => null,
            'payment_status' => 'success',
        ]);

        $res = $this->get(route('exam.success', ['id' => $legacyApp->id]));
        $res->assertStatus(200);

        $legacyApp->refresh();
        $this->assertNotNull($legacyApp->hall_ticket_number);
        $this->assertEquals(11, strlen($legacyApp->hall_ticket_number));
        $this->assertMatchesRegularExpression('/^[0-9]{11}$/', $legacyApp->hall_ticket_number);
    }

    /**
     * 8. Hall Ticket displays Important Candidate Instructions and Important Examination Restrictions.
     */
    public function test_hall_ticket_displays_candidate_instructions_and_examination_restrictions(): void
    {
        $app = ExamApplication::create([
            'exam_setting_id' => $this->examA->id,
            'email' => 'candidate_restrict@abvhps.org',
            'full_name' => 'PRASANNA KUMAR',
            'dob' => '2007-08-20',
            'mobile' => '9988112244',
            'hall_ticket_number' => '58374291645',
            'payment_status' => 'success',
        ]);

        $res = $this->get(route('exam.success', ['id' => $app->id]));
        $res->assertStatus(200);

        // Header and Sections
        $res->assertSee('IMPORTANT CANDIDATE INSTRUCTIONS');
        $res->assertSee('IMPORTANT EXAMINATION RESTRICTIONS');

        // Core Restrictions
        $res->assertSee('Mobile phones');
        $res->assertSee('strictly prohibited');
        $res->assertSee('Smart watches');
        $res->assertSee('Earphones');
        $res->assertSee('Tablets');
        $res->assertSee('Calculators');
        $res->assertSee('30 minutes before the scheduled examination time');
    }

    /**
     * 9. Hall Ticket displays dynamic exam-specific guidelines when configured.
     */
    public function test_hall_ticket_displays_dynamic_exam_guidelines(): void
    {
        $examWithGuidelines = ExamSetting::create([
            'exam_title' => 'Vedic Mathematics Test',
            'exam_type' => 'mcq',
            'syllabus_pdf_path' => 'exams/syllabus/vedic.pdf',
            'guidelines' => 'Special Guideline: Black ballpoint pen only.',
            'prize_details_json' => json_encode(['1st Prize - Trophy']),
            'exam_date_time' => '2026-12-10 10:00:00',
            'exam_center_location' => 'Tirupati Center',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $app = ExamApplication::create([
            'exam_setting_id' => $examWithGuidelines->id,
            'email' => 'vedic_student@abvhps.org',
            'full_name' => 'VEDIC SCHOLAR',
            'dob' => '2008-01-01',
            'mobile' => '9988112255',
            'hall_ticket_number' => '58374291646',
            'payment_status' => 'success',
        ]);

        $res = $this->get(route('exam.success', ['id' => $app->id]));
        $res->assertStatus(200);

        $res->assertSee('Special Guideline: Black ballpoint pen only.');
        $res->assertSee('IMPORTANT EXAMINATION RESTRICTIONS');
    }
}
