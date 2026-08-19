<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Membership;
use App\Models\Volunteer;
use App\Models\RudrasenaMember;
use App\Models\ExamSetting;
use App\Models\ExamApplication;
use App\Http\Controllers\VolunteerController;

class MasterIdentityAndQrTest extends TestCase
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
     * TEST 1: 10+ Volunteer IDs are strictly 6 digits, numeric, non-sequential, and unique.
     */
    public function test_ten_volunteer_ids_are_randomized_six_digit_numeric_and_unique(): void
    {
        $generatedIds = [];

        for ($i = 1; $i <= 12; $i++) {
            $member = Membership::create([
                'membership_id' => sprintf('583742%06d', $i),
                'phone' => '9876543' . sprintf('%03d', $i),
                'payment_status' => 'success',
                'full_name' => 'VOLUNTEER CADRE ' . $i,
                'country' => 'India',
                'state' => 'Andhra Pradesh',
                'district' => 'Kadapa',
                'is_completed' => 1
            ]);

            $volunteer = Volunteer::create([
                'membership_id' => $member->membership_id,
                'phone' => $member->phone,
                'qualification' => 'Graduate',
                'voter_id_number' => 'VTR' . sprintf('%06d', $i),
                'email' => 'vol' . $i . '@abvhps.org',
                'bank_name' => 'SBI',
                'account_holder_name' => 'Vol ' . $i,
                'account_number' => '12345678' . $i,
                'ifsc_code' => 'SBIN0001',
                'branch_name' => 'Porumamilla',
                'nominee_name' => 'Nominee',
                'nominee_relation' => 'Father',
                'nominee_phone' => '9876543210',
                'document_declaration_path' => 'doc1.pdf',
                'document_voter_path' => 'doc2.pdf',
                'document_bank_path' => 'doc3.pdf',
                'status' => 'pending',
            ]);

            // Admin approves volunteer
            $this->actingAs($this->admin)->post(route('admin.volunteers.cadreUpdate', $volunteer->id), [
                'status' => 'Verified',
                'cadre' => 'District Coordinator',
                'locality' => 'Kadapa'
            ]);

            $volunteer->refresh();

            $id = $volunteer->volunteer_id;
            $this->assertNotNull($id);
            $this->assertMatchesRegularExpression('/^[0-9]{6}$/', $id, "Volunteer ID {$id} must be exactly 6 digits");
            $this->assertEquals($volunteer->volunteer_id, $volunteer->volunteer_login_id, "volunteer_id and volunteer_login_id must be identical");
            $this->assertNotContains($id, $generatedIds, "Volunteer ID {$id} must be unique");

            $generatedIds[] = $id;
        }

        $this->assertCount(12, $generatedIds);

        // Verify that the generated IDs are not simply incrementing by 1 (non-predictable)
        $isPurelySequential = true;
        for ($k = 0; $k < count($generatedIds) - 1; $k++) {
            if ((int)$generatedIds[$k + 1] !== (int)$generatedIds[$k] + 1) {
                $isPurelySequential = false;
                break;
            }
        }
        $this->assertFalse($isPurelySequential, "Volunteer IDs must be non-sequential randomized numbers");
    }

    /**
     * TEST 2: Volunteer can log in using their 6-digit Volunteer ID.
     */
    public function test_volunteer_can_login_using_official_six_digit_volunteer_id(): void
    {
        $member = Membership::create([
            'membership_id' => '583742916405',
            'phone' => '9876543210',
            'payment_status' => 'success',
            'full_name' => 'KASI REDDY',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'is_completed' => 1
        ]);

        $volunteer = Volunteer::create([
            'membership_id' => $member->membership_id,
            'phone' => $member->phone,
            'qualification' => 'Graduate',
            'voter_id_number' => 'VTR999888',
            'email' => 'kasi@abvhps.org',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Kasi Reddy',
            'account_number' => '9988776655',
            'ifsc_code' => 'SBIN0001',
            'branch_name' => 'Porumamilla',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Father',
            'nominee_phone' => '9876543210',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'approved',
            'is_active' => true,
            'volunteer_id' => '583214',
            'volunteer_login_id' => '583214',
            'password' => Hash::make('ABVH@Temp123'),
            'must_change_password' => false,
            'cadre' => 'District Coordinator',
        ]);

        $response = $this->post(route('volunteer.login.submit'), [
            'volunteer_id' => '583214',
            'password' => 'ABVH@Temp123'
        ]);

        $response->assertRedirect(route('volunteer.dashboard'));
        $this->assertAuthenticatedAs($volunteer, 'volunteer');
    }

    /**
     * TEST 3: Public QR Verification for Volunteer (/verify/volunteer/{id}).
     */
    public function test_public_volunteer_verification_endpoint(): void
    {
        $member = Membership::create([
            'membership_id' => '583742916405',
            'phone' => '9876543210',
            'payment_status' => 'success',
            'full_name' => 'SRINIVASA RAO',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'mandal' => 'Porumamilla',
            'grama_panchayat' => 'Akkalareddy Palli',
            'is_completed' => 1
        ]);

        $volunteer = Volunteer::create([
            'membership_id' => $member->membership_id,
            'phone' => $member->phone,
            'qualification' => 'Post Graduate',
            'voter_id_number' => 'SECRET_VOTER_123',
            'email' => 'secret_volunteer@gmail.com',
            'bank_name' => 'HDFC',
            'account_holder_name' => 'Secret Holder',
            'account_number' => 'SECRET_BANK_9999',
            'ifsc_code' => 'HDFC0001234',
            'branch_name' => 'Kadapa',
            'nominee_name' => 'Secret Nominee',
            'nominee_relation' => 'Spouse',
            'nominee_phone' => '9876543210',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'approved',
            'is_active' => true,
            'volunteer_id' => '741905',
            'volunteer_login_id' => '741905',
            'password' => Hash::make('SecretPass999'),
            'cadre' => 'Mandal Coordinator',
            'locality' => 'Porumamilla Mandal'
        ]);

        $res = $this->get(route('verify.volunteer', '741905'));
        $res->assertStatus(200);

        // Safe Public Information
        $res->assertSee('Authorized Volunteer');
        $res->assertSee('741905');
        $res->assertSee('SRINIVASA RAO');
        $res->assertSee('ACTIVE & APPROVED');
        $res->assertSee('Mandal Coordinator');
        $res->assertSee('Porumamilla');

        // Privacy Check: Sensitive data MUST NOT be exposed
        $res->assertDontSee('SECRET_VOTER_123');
        $res->assertDontSee('secret_volunteer@gmail.com');
        $res->assertDontSee('SECRET_BANK_9999');
        $res->assertDontSee('HDFC0001234');
        $res->assertDontSee('SecretPass999');
    }

    /**
     * TEST 4: Public QR Verification for Membership (/verify/membership/{id}).
     */
    public function test_public_membership_verification_endpoint(): void
    {
        $member = Membership::create([
            'membership_id' => '583742916405',
            'phone' => '9876543210',
            'payment_status' => 'success',
            'full_name' => 'RAMA KRISHNA',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'mandal' => 'Porumamilla',
            'grama_panchayat' => 'Shanmukhapuram',
            'is_completed' => 1
        ]);

        $res = $this->get(route('verify.membership', '583742916405'));
        $res->assertStatus(200);
        $res->assertSee('ABVHPS Life Member');
        $res->assertSee('583742916405');
        $res->assertSee('RAMA KRISHNA');
        $res->assertSee('ACTIVE & VERIFIED');
        $res->assertSee('Shanmukhapuram');
    }

    /**
     * TEST 5: Rudra Sena Member ID RS0001 preserved and verifiable (/verify/rudrasena/{id}).
     */
    public function test_rudrasena_id_rs0001_preserved_and_verifiable(): void
    {
        $member = Membership::create([
            'membership_id' => '583742916406',
            'phone' => '9876543211',
            'payment_status' => 'success',
            'full_name' => 'RUDRA COMMANDO ONE',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'is_completed' => 1
        ]);

        $rudrasena = RudrasenaMember::create([
            'membership_id' => $member->membership_id,
            'full_name' => $member->full_name,
            'email' => 'rudra1@abvhps.org',
            'mobile' => $member->phone,
            'dob' => '1995-05-15',
            'age' => 30,
            'blood_group' => 'O+',
            'gotram' => 'Kashyapa',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Mother',
            'nominee_age' => 55,
            'nominee_contact' => '9876543210',
            'bank_holder_name' => 'Rudra One',
            'bank_account_number' => '11223344',
            'bank_ifsc_code' => 'SBIN0001',
            'bank_name_branch' => 'Porumamilla',
            'document_health_declaration' => 'doc1.pdf',
            'document_family_declaration' => 'doc2.pdf',
            'document_id_proof' => 'doc3.pdf',
            'document_bank_proof' => 'doc4.pdf',
            'rudrasena_id' => 'RS0001',
            'assigned_cadder' => 'Dharma Rakshak',
            'assigned_locality' => 'Kadapa Zone',
            'status' => 'verified',
            'disclaimer_accepted' => true,
        ]);

        $this->assertEquals('RS0001', $rudrasena->rudrasena_id);

        $res = $this->get(route('verify.rudrasena', 'RS0001'));
        $res->assertStatus(200);
        $res->assertSee('Rudra Sena Member');
        $res->assertSee('RS0001');
        $res->assertSee('RUDRA COMMANDO ONE');
        $res->assertSee('VERIFIED & ACTIVE');
        $res->assertSee('Dharma Rakshak');
    }

    /**
     * TEST 6: Exam Hall Ticket 11-digit numeric and verifiable (/verify/exam/{hallTicket}).
     */
    public function test_exam_hall_ticket_eleven_digit_and_verifiable(): void
    {
        $exam = ExamSetting::create([
            'exam_title' => 'Sanatana Dharma Annual Exam 2026',
            'exam_date_time' => '2026-10-15 10:00:00',
            'exam_center_location' => 'ABVHPS Central Center, Kadapa',
            'syllabus_pdf_path' => 'syllabus.pdf',
            'prize_details_json' => json_encode(['1st' => 'Gold Medal', '2nd' => 'Silver Medal']),
            'application_fee' => 41.00,
            'exam_fee' => 41.00,
            'status' => 'active',
            'exam_type' => 'theory'
        ]);

        $app = ExamApplication::create([
            'exam_setting_id' => $exam->id,
            'email' => 'student@test.com',
            'is_email_verified' => 1,
            'full_name' => 'STUDENT CANDIDATE',
            'dob' => '2008-04-10',
            'address' => 'Porumamilla, Kadapa',
            'mobile' => '9876543212',
            'aadhaar_no' => '123456789012',
            'father_membership_id' => '583742916405',
            'father_name' => 'Father',
            'mother_membership_id' => '583742916406',
            'mother_name' => 'Mother',
            'school_college_name' => 'ZPHS Porumamilla',
            'class_section' => '10th Class',
            'amount_paid' => 41.00,
            'payment_status' => 'success',
            'hall_ticket_number' => '58374291640',
        ]);

        $this->assertEquals(11, strlen($app->hall_ticket_number));

        $res = $this->get(route('verify.exam', '58374291640'));
        $res->assertStatus(200);
        $res->assertSee('Exam Applicant Hall Ticket');
        $res->assertSee('58374291640');
        $res->assertSee('STUDENT CANDIDATE');
        $res->assertSee('VALID HALL TICKET');
        $res->assertSee('Sanatana Dharma Annual Exam 2026');
    }

    /**
     * TEST 7: Organic Farmers Group OF-XXXXXX format and verification (/verify/organic-farmers/{groupId}).
     */
    public function test_organic_farmers_group_id_and_verification(): void
    {
        $groupId = 'OF-583214';

        DB::table('organic_farmers')->insert([
            'farmer_registration_id' => $groupId,
            'membership_id' => '583742916405',
            'farmer_name' => 'AMBAVARAM ORGANIC LEAD',
            'farmer_mobile' => '9876543210',
            'land_size_acres' => 12.50,
            'water_source' => 'Borewell & Canal',
            'indigenous_cows_count' => 8,
            'uses_jeevamrutham' => 1,
            'uses_ghana_jeevamrutham' => 1,
            'organic_oath_accepted' => 1,
            'status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $farmerRecord = DB::table('organic_farmers')->where('farmer_registration_id', $groupId)->first();
        DB::table('farmer_crops')->insert([
            'organic_farmer_id' => $farmerRecord->id,
            'crop_name' => 'Desi Red Rice',
            'variety_spec' => 'Navara',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $res = $this->get(route('verify.organic_farmers', $groupId));
        $res->assertStatus(200);
        $res->assertSee('Organic Farmers Group');
        $res->assertSee($groupId);
        $res->assertSee('AMBAVARAM ORGANIC LEAD');
        $res->assertSee('VERIFIED ORGANIC GROUP');
        $res->assertSee('12.5 Acres');
    }

    /**
     * TEST 8: Kala Brundam Group KB-XXXXXX format and verification (/verify/kala-brundham/{groupId}).
     */
    public function test_kala_brundham_group_id_and_verification(): void
    {
        $groupId = 'KB-583214';

        $teamId = DB::table('kala_brundams')->insertGetId([
            'team_registration_id' => $groupId,
            'team_name' => 'SRI RAMA BHAJANA SANGHAM',
            'team_type' => 'Bhajana & Sankeerthana',
            'location' => 'Ambavaram Village, Porumamilla',
            'disclaimer_accepted' => 1,
            'status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kala_brundam_members')->insert([
            'kala_brundam_id' => $teamId,
            'membership_id' => '583742916405',
            'full_name' => 'Lead Performer',
            'age' => 35,
            'mobile' => '9876543210',
            'is_verified' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $res = $this->get(route('verify.kala_brundham', $groupId));
        $res->assertStatus(200);
        $res->assertSee('Kala Brundam Cultural Wing');
        $res->assertSee($groupId);
        $res->assertSee('SRI RAMA BHAJANA SANGHAM');
        $res->assertSee('VERIFIED CULTURAL TEAM');
        $res->assertSee('Ambavaram Village');
    }

    /**
     * TEST 9: Grama Seva Dal Group GSD-XXXXXX format and verification (/verify/grama-seva-dal/{groupId}).
     */
    public function test_grama_seva_dal_group_id_and_verification(): void
    {
        $groupId = 'GSD-583214';

        $dalId = DB::table('grama_seva_dals')->insertGetId([
            'gong_registration_id' => $groupId,
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'mandal' => 'Porumamilla',
            'village_or_gp' => 'Ambavaram Village',
            'leader_membership_id' => '583742916405',
            'leader_name' => 'SEVA DAL COMMANDER',
            'leader_mobile' => '9876543210',
            'charter_accepted' => 1,
            'status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('grama_seva_dal_members')->insert([
            'grama_seva_dal_id' => $dalId,
            'membership_id' => '583742916405',
            'full_name' => 'Seva Youth One',
            'age' => 24,
            'mobile' => '9876543210',
            'is_active_force' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $res = $this->get(route('verify.grama_seva_dal', $groupId));
        $res->assertStatus(200);
        $res->assertSee('Grama Seva Dal Village Wing');
        $res->assertSee($groupId);
        $res->assertSee('SEVA DAL COMMANDER');
        $res->assertSee('VERIFIED SERVICE DAL');
        $res->assertSee('Ambavaram Village');
    }

    /**
     * TEST 10: Invalid/Fake ID returns clean verification failure without 500 error.
     */
    public function test_invalid_fake_id_returns_clean_verification_failure(): void
    {
        $res = $this->get(route('verify.volunteer', '999999'));
        $res->assertStatus(200);
        $res->assertSee('Verification Failed');
        $res->assertSee('No active, approved volunteer record was found');

        $resMem = $this->get(route('verify.membership', '000000000000'));
        $resMem->assertStatus(200);
        $resMem->assertSee('Verification Failed');
    }
}
