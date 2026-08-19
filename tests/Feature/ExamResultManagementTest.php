<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\ExamSetting;
use App\Models\ExamApplication;
use App\Models\NotificationLog;

class ExamResultManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected ExamSetting $examA;
    protected ExamSetting $examB;
    protected ExamApplication $candidateA1;
    protected ExamApplication $candidateA2;
    protected ExamApplication $candidateB1;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['email' => 'admin@abvhps.org'],
            [
                'name' => 'State Commander',
                'password' => bcrypt('password123'),
                'is_admin' => true
            ]
        );

        // Exam A (MCQ)
        $this->examA = ExamSetting::create([
            'exam_title' => 'Sanathana Dharma MCQ Championship 2026',
            'exam_type' => 'mcq',
            'syllabus_pdf_path' => 'exams/syllabus/sample.pdf',
            'prize_details_json' => json_encode(['1st: Gold Trophy', '2nd: Silver Medal']),
            'exam_date_time' => now()->addDays(10),
            'exam_center_location' => 'Kadapa Hall A',
            'application_fee' => 50.00,
            'status' => 'active',
        ]);

        // Exam B (Theory)
        $this->examB = ExamSetting::create([
            'exam_title' => 'Vedic Philosophy Essay Exam (Theory)',
            'exam_type' => 'theory',
            'syllabus_pdf_path' => 'exams/syllabus/sample.pdf',
            'prize_details_json' => json_encode(['1st: Gold Trophy', '2nd: Silver Medal']),
            'exam_date_time' => now()->addDays(20),
            'exam_center_location' => 'Tirupati Hall B',
            'application_fee' => 75.00,
            'status' => 'active',
        ]);

        // Candidate A1 for Exam A
        $this->candidateA1 = ExamApplication::create([
            'exam_setting_id' => $this->examA->id,
            'email' => 'candidate_a1@example.com',
            'is_email_verified' => true,
            'full_name' => 'Candidate Alpha One',
            'dob' => '2005-01-01',
            'address' => 'Porumamilla',
            'mobile' => '9876543210',
            'guardian_type' => 'parents',
            'father_membership_id' => '662424000000',
            'father_name' => 'Father Alpha',
            'mother_membership_id' => '773434000000',
            'mother_name' => 'Mother Alpha',
            'school_college_name' => 'Porumamilla High School',
            'payment_status' => 'success',
            'amount_paid' => 50.00,
            'hall_ticket_number' => '20268888881',
            'result_publication_status' => 'draft',
        ]);

        // Candidate A2 for Exam A
        $this->candidateA2 = ExamApplication::create([
            'exam_setting_id' => $this->examA->id,
            'email' => 'candidate_a2@example.com',
            'is_email_verified' => true,
            'full_name' => 'Candidate Alpha Two',
            'dob' => '2005-02-02',
            'address' => 'Mydukur',
            'mobile' => '9876543211',
            'guardian_type' => 'parents',
            'father_membership_id' => '662424000000',
            'mother_membership_id' => '773434000000',
            'school_college_name' => 'Mydukur Junior College',
            'payment_status' => 'success',
            'amount_paid' => 50.00,
            'hall_ticket_number' => '20268888882',
            'result_publication_status' => 'draft',
        ]);

        // Candidate B1 for Exam B
        $this->candidateB1 = ExamApplication::create([
            'exam_setting_id' => $this->examB->id,
            'email' => 'candidate_b1@example.com',
            'is_email_verified' => true,
            'full_name' => 'Candidate Beta One',
            'dob' => '2005-01-01',
            'address' => 'Porumamilla',
            'mobile' => '9876543210',
            'guardian_type' => 'parents',
            'father_membership_id' => '662424000000',
            'mother_membership_id' => '773434000000',
            'school_college_name' => 'Porumamilla High School',
            'payment_status' => 'success',
            'amount_paid' => 75.00,
            'hall_ticket_number' => '20269999991',
            'result_publication_status' => 'draft',
        ]);
    }

    /**
     * TEST 1: Admin can access Results Desk for Exam A and sees ONLY Exam A candidates.
     */
    public function test_admin_results_desk_shows_only_selected_exam_candidates(): void
    {
        $res = $this->actingAs($this->admin)->get(route('admin.exams.results', $this->examA->id));
        $res->assertStatus(200);
        $res->assertSee($this->examA->exam_title);
        $res->assertSee('Candidate Alpha One');
        $res->assertSee('Candidate Alpha Two');
        $res->assertSee('20268888881');
        $res->assertSee('20268888882');
        // Candidate B1's hall ticket for Exam B should NOT appear in Exam A results desk
        $res->assertDontSee('20269999991');
    }

    /**
     * TEST 2: Admin enters result for Candidate A1, saves as Draft.
     */
    public function test_admin_can_save_candidate_result_as_draft(): void
    {
        $res = $this->actingAs($this->admin)->post(
            route('admin.exams.results.save', $this->candidateA1->id),
            [
                'marks_obtained' => 92,
                'total_marks' => 100,
                'grade' => 'A+',
                'result_status' => 'passed',
                'winner_rank' => 1,
                'prize_title_won' => 'Gold Medal & Laptop',
                'show_on_winners_wall' => 1,
                'result_remarks' => 'Outstanding performance in MCQ round.'
            ]
        );

        $res->assertRedirect(route('admin.exams.results', $this->examA->id));

        $this->candidateA1->refresh();
        $this->assertEquals(92, $this->candidateA1->marks_obtained);
        $this->assertEquals(100, $this->candidateA1->total_marks);
        $this->assertEquals('A+', $this->candidateA1->grade);
        $this->assertEquals('passed', $this->candidateA1->result_status);
        $this->assertEquals('draft', $this->candidateA1->result_publication_status);
        $this->assertEquals(1, $this->candidateA1->winner_rank);
    }

    /**
     * TEST 3: Validation - Marks obtained cannot exceed total marks.
     */
    public function test_marks_obtained_cannot_exceed_total_marks(): void
    {
        $res = $this->actingAs($this->admin)->from(route('admin.exams.results', $this->examA->id))->post(
            route('admin.exams.results.save', $this->candidateA1->id),
            [
                'marks_obtained' => 150,
                'total_marks' => 100,
                'result_status' => 'passed',
            ]
        );

        $res->assertSessionHasErrors(['marks_obtained']);
    }

    /**
     * TEST 4: Draft Security - Draft results are NEVER exposed publicly on /exam-results/search.
     */
    public function test_draft_results_are_hidden_from_public_lookup(): void
    {
        // Candidate A1 has draft marks saved
        $this->candidateA1->update([
            'marks_obtained' => 92,
            'total_marks' => 100,
            'result_status' => 'passed',
            'result_publication_status' => 'draft',
        ]);

        $res = $this->postJson(route('exam.results_search'), [
            'hall_ticket_number' => $this->candidateA1->hall_ticket_number,
        ]);

        $res->assertStatus(200);
        $data = $res->json();
        $this->assertFalse($data['success']);
        $this->assertTrue($data['draft']);
        $this->assertStringContainsString('not been announced yet', $data['message']);
        // Crucial: marks must NOT be in JSON
        $this->assertArrayNotHasKey('marks', $data);
        $this->assertArrayNotHasKey('grade', $data);
    }

    /**
     * TEST 5: Admin publishes Exam A results -> candidate can see result publicly.
     */
    public function test_admin_can_publish_exam_results_and_make_them_public(): void
    {
        $this->candidateA1->update([
            'marks_obtained' => 92,
            'total_marks' => 100,
            'grade' => 'A+',
            'result_status' => 'passed',
            'result_publication_status' => 'draft',
        ]);

        $res = $this->actingAs($this->admin)->post(route('admin.exams.publish_results', $this->examA->id));
        $res->assertRedirect(route('admin.exams.results', $this->examA->id));

        $this->candidateA1->refresh();
        $this->assertEquals('published', $this->candidateA1->result_publication_status);
        $this->assertNotNull($this->candidateA1->result_published_at);

        // Now public lookup succeeds
        $lookup = $this->postJson(route('exam.results_search'), [
            'hall_ticket_number' => $this->candidateA1->hall_ticket_number,
        ]);

        $lookup->assertStatus(200);
        $data = $lookup->json();
        $this->assertTrue($data['success']);
        $this->assertEquals('Candidate Alpha One', $data['full_name']);
        $this->assertEquals('20268888881', $data['hall_ticket']);
        $this->assertEquals(92, $data['marks']);
        $this->assertEquals(100, $data['total_marks']);
        $this->assertEquals(92.0, $data['percentage']);
        $this->assertEquals('A+', $data['grade']);
        $this->assertEquals('passed', $data['status']);
        $this->assertEquals($this->examA->exam_title, $data['exam_title']);
        $this->assertEquals('mcq', $data['exam_type']);
    }

    /**
     * TEST 6: Notifications are created with accurate statuses (logged for mail, not_configured for whatsapp, created for in_app).
     */
    public function test_result_publication_dispatches_accurate_channel_notifications(): void
    {
        $this->candidateA1->update([
            'marks_obtained' => 92,
            'total_marks' => 100,
            'result_status' => 'passed',
            'result_publication_status' => 'draft',
        ]);

        $this->actingAs($this->admin)->post(route('admin.exams.publish_results', $this->examA->id));

        // Check NotificationLog table
        $emailLog = NotificationLog::where('notifiable_type', ExamApplication::class)
            ->where('notifiable_id', $this->candidateA1->id)
            ->where('channel', 'email')
            ->first();

        $expectedStatus = config('mail.default') === 'log' ? 'logged' : 'sent';
        $this->assertEquals($expectedStatus, $emailLog->status);

        $waLog = NotificationLog::where('notifiable_type', ExamApplication::class)
            ->where('notifiable_id', $this->candidateA1->id)
            ->where('channel', 'whatsapp')
            ->first();

        $this->assertNotNull($waLog);
        $this->assertEquals('not_configured', $waLog->status); // Because no WhatsApp provider configured

        $inAppLog = NotificationLog::where('notifiable_type', ExamApplication::class)
            ->where('notifiable_id', $this->candidateA1->id)
            ->where('channel', 'in_app')
            ->first();

        $this->assertNotNull($inAppLog);
        $this->assertEquals('created', $inAppLog->status);
    }

    /**
     * TEST 7: Idempotency - Publishing the same exam twice does NOT produce duplicate notifications.
     */
    public function test_duplicate_publication_does_not_send_duplicate_notifications(): void
    {
        // First publish
        $this->actingAs($this->admin)->post(route('admin.exams.publish_results', $this->examA->id));
        $countAfterFirst = NotificationLog::where('notifiable_type', ExamApplication::class)
            ->where('notifiable_id', $this->candidateA1->id)
            ->count();

        $this->assertEquals(3, $countAfterFirst); // 1 email + 1 whatsapp + 1 in_app

        // Second publish
        $this->actingAs($this->admin)->post(route('admin.exams.publish_results', $this->examA->id));
        $countAfterSecond = NotificationLog::where('notifiable_type', ExamApplication::class)
            ->where('notifiable_id', $this->candidateA1->id)
            ->count();

        // Count must remain exactly 3 (no duplicate rows created)
        $this->assertEquals(3, $countAfterSecond);
    }

    /**
     * TEST 8: Multiple Exams Isolation - Same candidate in Exam A and Exam B has separate results by Hall Ticket.
     */
    public function test_multiple_exams_results_isolation(): void
    {
        // Publish Exam A results
        $this->candidateA1->update([
            'marks_obtained' => 88,
            'total_marks' => 100,
            'result_status' => 'passed',
            'result_publication_status' => 'published',
            'result_published_at' => now(),
        ]);

        // Exam B result is still in DRAFT
        $this->candidateB1->update([
            'marks_obtained' => 70,
            'total_marks' => 100,
            'result_status' => 'passed',
            'result_publication_status' => 'draft',
        ]);

        // Lookup with Hall Ticket A1 -> Returns Exam A result
        $resA = $this->postJson(route('exam.results_search'), [
            'hall_ticket_number' => $this->candidateA1->hall_ticket_number,
        ]);
        $resA->assertStatus(200);
        $dataA = $resA->json();
        $this->assertTrue($dataA['success']);
        $this->assertEquals(88, $dataA['marks']);
        $this->assertEquals($this->examA->exam_title, $dataA['exam_title']);

        // Lookup with Hall Ticket B1 -> Returns Draft message (Exam B not yet published)
        $resB = $this->postJson(route('exam.results_search'), [
            'hall_ticket_number' => $this->candidateB1->hall_ticket_number,
        ]);
        $resB->assertStatus(200);
        $dataB = $resB->json();
        $this->assertFalse($dataB['success']);
        $this->assertTrue($dataB['draft']);
    }

    /**
     * TEST 9: Admin can unpublish results (roll back to draft).
     */
    public function test_admin_can_unpublish_exam_results(): void
    {
        $this->candidateA1->update([
            'result_publication_status' => 'published',
            'result_published_at' => now(),
        ]);

        $res = $this->actingAs($this->admin)->post(route('admin.exams.unpublish_results', $this->examA->id));
        $res->assertRedirect(route('admin.exams.results', $this->examA->id));

        $this->candidateA1->refresh();
        $this->assertEquals('draft', $this->candidateA1->result_publication_status);
        $this->assertNull($this->candidateA1->result_published_at);
    }
}
