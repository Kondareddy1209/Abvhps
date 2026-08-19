<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ExamSetting;

class ExamTypeManagementTest extends TestCase
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
     * 1. Admin can create Theory exam.
     */
    public function test_admin_can_create_theory_exam(): void
    {
        $res = $this->actingAs($this->admin, 'web')->post(route('admin.exams.store'), [
            'exam_title' => 'Sanathana Dharma Theory Examination 2026',
            'exam_type' => 'theory',
            'exam_date_time' => '2026-11-10 10:00',
            'exam_center_location' => 'Kadapa Central',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $res->assertRedirect(route('admin.exams.index'));
        $this->assertDatabaseHas('exam_settings', [
            'exam_title' => 'Sanathana Dharma Theory Examination 2026',
            'exam_type' => 'theory',
        ]);
    }

    /**
     * 2. Admin can create MCQ exam.
     */
    public function test_admin_can_create_mcq_exam(): void
    {
        $res = $this->actingAs($this->admin, 'web')->post(route('admin.exams.store'), [
            'exam_title' => 'Sanathana Dharma MCQ Examination 2026',
            'exam_type' => 'mcq',
            'exam_date_time' => '2026-11-15 10:00',
            'exam_center_location' => 'Badvel Center',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $res->assertRedirect(route('admin.exams.index'));
        $this->assertDatabaseHas('exam_settings', [
            'exam_title' => 'Sanathana Dharma MCQ Examination 2026',
            'exam_type' => 'mcq',
        ]);
    }

    /**
     * 3. Admin can create Both (Theory + MCQ) exam.
     */
    public function test_admin_can_create_both_exam(): void
    {
        $res = $this->actingAs($this->admin, 'web')->post(route('admin.exams.store'), [
            'exam_title' => 'Sanathana Dharma Comprehensive Examination 2026',
            'exam_type' => 'both',
            'exam_date_time' => '2026-11-20 10:00',
            'exam_center_location' => 'Porumamilla HQ',
            'application_fee' => 41.00,
            'status' => 'upcoming',
        ]);

        $res->assertRedirect(route('admin.exams.index'));
        $this->assertDatabaseHas('exam_settings', [
            'exam_title' => 'Sanathana Dharma Comprehensive Examination 2026',
            'exam_type' => 'both',
        ]);
    }

    /**
     * 4. Invalid exam_type is rejected by validation.
     */
    public function test_invalid_exam_type_is_rejected(): void
    {
        $res = $this->actingAs($this->admin, 'web')->post(route('admin.exams.store'), [
            'exam_title' => 'Invalid Type Exam',
            'exam_type' => 'invalid_random_type',
            'exam_date_time' => '2026-11-20 10:00',
            'exam_center_location' => 'Porumamilla HQ',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $res->assertSessionHasErrors(['exam_type']);
    }

    /**
     * 5. Missing exam_type is rejected.
     */
    public function test_missing_exam_type_is_rejected(): void
    {
        $res = $this->actingAs($this->admin, 'web')->post(route('admin.exams.store'), [
            'exam_title' => 'Missing Type Exam',
            'exam_date_time' => '2026-11-20 10:00',
            'exam_center_location' => 'Porumamilla HQ',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $res->assertSessionHasErrors(['exam_type']);
    }

    /**
     * 6. Admin can update Exam Type in edit form.
     */
    public function test_admin_can_update_exam_type(): void
    {
        $exam = ExamSetting::create([
            'exam_title' => 'Updatable Exam',
            'exam_type' => 'theory',
            'syllabus_pdf_path' => 'exams/syllabus/sample.pdf',
            'prize_details_json' => json_encode(['1st' => 'Tablet']),
            'exam_date_time' => '2026-11-20 10:00:00',
            'exam_center_location' => 'Kadapa',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $res = $this->actingAs($this->admin, 'web')->post(route('admin.exams.update', $exam->id), [
            'exam_title' => 'Updatable Exam Renamed',
            'exam_type' => 'both',
            'exam_date_time' => '2026-11-25 10:00',
            'exam_center_location' => 'Kadapa',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $res->assertRedirect(route('admin.exams.index'));
        $exam->refresh();
        $this->assertEquals('both', $exam->exam_type);
    }

    /**
     * 7. Exam listing and public notice board show correct exam type.
     */
    public function test_exam_type_renders_on_admin_index_and_public_board(): void
    {
        $examBoth = ExamSetting::create([
            'exam_title' => 'Combined Dharma Exam',
            'exam_type' => 'both',
            'syllabus_pdf_path' => 'exams/syllabus/sample.pdf',
            'prize_details_json' => json_encode(['1st' => 'Gold Medal']),
            'exam_date_time' => '2026-12-01 10:00:00',
            'exam_center_location' => 'Central Hub',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        // Admin Listing
        $adminRes = $this->actingAs($this->admin, 'web')->get(route('admin.exams.index'));
        $adminRes->assertStatus(200);
        $adminRes->assertSee('Both');

        // Public Notice Board
        $publicRes = $this->get(route('public.exams_board'));
        $publicRes->assertStatus(200);
        $publicRes->assertSee('Both (Theory + MCQ)');
    }

    /**
     * 8. Existing exams without exam_type do not crash.
     */
    public function test_existing_exams_without_exam_type_do_not_crash(): void
    {
        $legacyExam = ExamSetting::create([
            'exam_title' => 'Legacy Exam Without Type',
            'exam_type' => null,
            'syllabus_pdf_path' => 'exams/syllabus/sample.pdf',
            'prize_details_json' => json_encode(['1st' => 'Silver Medal']),
            'exam_date_time' => '2026-12-01 10:00:00',
            'exam_center_location' => 'Legacy Center',
            'application_fee' => 41.00,
            'status' => 'active',
        ]);

        $this->assertEquals('Not Set', $legacyExam->exam_type_label);

        $res = $this->actingAs($this->admin, 'web')->get(route('admin.exams.index'));
        $res->assertStatus(200);
        $res->assertSee('Not set');
    }
}
