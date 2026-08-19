<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ExamSetting;

class ExamPrizesManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Officer',
            'email' => 'admin@abvhps.org',
            'password' => bcrypt('AdminPassword123'),
        ]);
    }

    /**
     * 1. Admin can create an exam with multiple prizes, one per line (ignoring blank lines).
     */
    public function test_admin_can_create_exam_with_prizes(): void
    {
        $prizeInput = "1st Prize - ₹10,000\n\n2nd Prize - ₹5,000\n  \n3rd Prize - ₹2,500\nCertificate of Excellence";

        $res = $this->actingAs($this->admin, 'web')->post(route('admin.exams.store'), [
            'exam_title' => 'Dharma Knowledge Exam A',
            'exam_type' => 'theory',
            'exam_date_time' => '2026-11-20 10:00',
            'exam_center_location' => 'Kadapa Central',
            'application_fee' => 41.00,
            'prize_details' => $prizeInput,
            'status' => 'active',
        ]);

        $res->assertRedirect(route('admin.exams.index'));

        $exam = ExamSetting::where('exam_title', 'Dharma Knowledge Exam A')->first();
        $this->assertNotNull($exam);

        $expected = [
            '1st Prize - ₹10,000',
            '2nd Prize - ₹5,000',
            '3rd Prize - ₹2,500',
            'Certificate of Excellence'
        ];

        $this->assertEquals($expected, $exam->prizes_list);
    }

    /**
     * 2. Exam application page displays prizes for THAT particular exam only.
     */
    public function test_application_page_displays_prizes_for_correct_exam(): void
    {
        $examA = ExamSetting::create([
            'exam_title' => 'Exam Alpha',
            'exam_type' => 'mcq',
            'syllabus_pdf_path' => 'exams/syllabus/sample.pdf',
            'prize_details_json' => json_encode(['1st Prize - Gold Medal (Alpha)', '2nd Prize - Silver (Alpha)']),
            'exam_date_time' => '2026-11-20 10:00:00',
            'exam_center_location' => 'Kadapa',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $examB = ExamSetting::create([
            'exam_title' => 'Exam Beta',
            'exam_type' => 'both',
            'syllabus_pdf_path' => 'exams/syllabus/sample.pdf',
            'prize_details_json' => json_encode(['1st Prize - Laptop (Beta)', 'Special Award (Beta)']),
            'exam_date_time' => '2026-11-25 10:00:00',
            'exam_center_location' => 'Porumamilla',
            'application_fee' => 50.00,
            'status' => 'active',
        ]);

        // Viewing Exam A Application
        $resA = $this->get(route('exam.form', ['exam_id' => $examA->id]));
        $resA->assertStatus(200);
        $resA->assertSee('1st Prize - Gold Medal (Alpha)');
        $resA->assertSee('2nd Prize - Silver (Alpha)');
        $resA->assertDontSee('1st Prize - Laptop (Beta)');

        // Viewing Exam B Application
        $resB = $this->get(route('exam.form', ['exam_id' => $examB->id]));
        $resB->assertStatus(200);
        $resB->assertSee('1st Prize - Laptop (Beta)');
        $resB->assertSee('Special Award (Beta)');
        $resB->assertDontSee('1st Prize - Gold Medal (Alpha)');
    }

    /**
     * 3. Updating prizes in Admin immediately updates the application page.
     */
    public function test_updating_prizes_updates_application_page(): void
    {
        $exam = ExamSetting::create([
            'exam_title' => 'Exam Delta',
            'exam_type' => 'theory',
            'syllabus_pdf_path' => 'exams/syllabus/sample.pdf',
            'prize_details_json' => json_encode(['Original Prize ₹1,000']),
            'exam_date_time' => '2026-11-20 10:00:00',
            'exam_center_location' => 'Kadapa',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $res = $this->actingAs($this->admin, 'web')->post(route('admin.exams.update', $exam->id), [
            'exam_title' => 'Exam Delta',
            'exam_type' => 'theory',
            'exam_date_time' => '2026-11-20 10:00',
            'exam_center_location' => 'Kadapa',
            'application_fee' => 41.00,
            'prize_details' => "Updated Grand Prize ₹25,000\nSpecial Trophy",
            'status' => 'active',
        ]);

        $res->assertRedirect(route('admin.exams.index'));

        $appRes = $this->get(route('exam.form', ['exam_id' => $exam->id]));
        $appRes->assertStatus(200);
        $appRes->assertSee('Updated Grand Prize ₹25,000');
        $appRes->assertSee('Special Trophy');
        $appRes->assertDontSee('Original Prize ₹1,000');
    }

    /**
     * 4. Exam without prizes hides the Prizes & Awards section cleanly.
     */
    public function test_empty_prizes_does_not_show_broken_section(): void
    {
        $examEmpty = ExamSetting::create([
            'exam_title' => 'Exam Without Prizes',
            'exam_type' => 'mcq',
            'syllabus_pdf_path' => 'exams/syllabus/sample.pdf',
            'prize_details_json' => json_encode([]),
            'exam_date_time' => '2026-11-20 10:00:00',
            'exam_center_location' => 'Kadapa',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $res = $this->get(route('exam.form', ['exam_id' => $examEmpty->id]));
        $res->assertStatus(200);
        $res->assertDontSee('Prizes & Awards');
    }

    /**
     * 5. HTML tags in prize entries are safely escaped (XSS prevention).
     */
    public function test_prize_text_is_safely_escaped(): void
    {
        $examXss = ExamSetting::create([
            'exam_title' => 'Exam With Special Chars',
            'exam_type' => 'mcq',
            'syllabus_pdf_path' => 'exams/syllabus/sample.pdf',
            'prize_details_json' => json_encode(['<script>alert("hack")</script> & Cash ₹5000']),
            'exam_date_time' => '2026-11-20 10:00:00',
            'exam_center_location' => 'Kadapa',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $res = $this->get(route('exam.form', ['exam_id' => $examXss->id]));
        $res->assertStatus(200);
        $res->assertDontSee('<script>alert("hack")</script>', false);
        $res->assertSee('&lt;script&gt;alert(&quot;hack&quot;)&lt;/script&gt;', false);
    }
}
