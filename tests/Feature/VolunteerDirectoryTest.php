<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Membership;
use App\Models\Volunteer;
use App\Models\ExamApplication;
use App\Models\FundraisingCampaign;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VolunteerDirectoryTest extends TestCase
{
    use RefreshDatabase;

    protected Membership $memberA;
    protected Membership $memberB;
    protected Membership $memberC;
    protected Membership $memberD;
    protected Membership $memberNonVolunteer;

    protected Volunteer $volunteerPending;
    protected Volunteer $volunteerApproved;
    protected Volunteer $volunteerRejected;
    protected Volunteer $volunteerInactive;

    protected function setUp(): void
    {
        parent::setUp();

        // Member A (Will be Pending Volunteer)
        $this->memberA = Membership::create([
            'membership_id' => '111111111111',
            'phone' => '9876543211',
            'payment_status' => 'success',
            'full_name' => 'PENDING VOLUNTEER USER',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'assembly_segment' => 'Badvel',
            'mandal' => 'Porumamilla',
            'grama_panchayat' => 'Porumamilla GP',
            'is_completed' => 1
        ]);

        $this->volunteerPending = Volunteer::create([
            'membership_id' => $this->memberA->membership_id,
            'phone' => $this->memberA->phone,
            'qualification' => 'B.Tech',
            'voter_id_number' => 'VTR111',
            'email' => 'pending@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Pending User',
            'account_number' => '111111',
            'ifsc_code' => 'SBIN0001',
            'branch_name' => 'Porumamilla',
            'nominee_name' => 'Mother',
            'nominee_relation' => 'Mother',
            'nominee_phone' => '9876543210',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'pending',
            'cadre' => 'Youth Seva Core',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'assembly_segment' => 'Badvel',
            'mandal' => 'Porumamilla',
            'grama_panchayat' => 'Porumamilla GP',
        ]);

        // Member B (Will be Approved Volunteer in Kadapa)
        $this->memberB = Membership::create([
            'membership_id' => '222222222222',
            'phone' => '9876543212',
            'payment_status' => 'success',
            'full_name' => 'APPROVED VOLUNTEER KASI',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'assembly_segment' => 'Badvel',
            'mandal' => 'Porumamilla',
            'grama_panchayat' => 'Porumamilla GP',
            'is_completed' => 1
        ]);

        $this->volunteerApproved = Volunteer::create([
            'membership_id' => $this->memberB->membership_id,
            'phone' => $this->memberB->phone,
            'qualification' => 'Post Graduate',
            'voter_id_number' => 'VTR222',
            'email' => 'approved@test.com',
            'bank_name' => 'HDFC',
            'account_holder_name' => 'Approved User',
            'account_number' => '222222',
            'ifsc_code' => 'HDFC0001',
            'branch_name' => 'Kadapa',
            'nominee_name' => 'Father',
            'nominee_relation' => 'Father',
            'nominee_phone' => '9876543210',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'approved',
            'is_active' => true,
            'volunteer_id' => '100001',
            'volunteer_login_id' => '100001',
            'cadre' => 'District Coordinator',
            'designation' => 'District Coordinator',
            'locality' => 'Kadapa District',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'assembly_segment' => 'Badvel',
            'mandal' => 'Porumamilla',
            'grama_panchayat' => 'Porumamilla GP',
        ]);

        // Member C (Will be Rejected Volunteer)
        $this->memberC = Membership::create([
            'membership_id' => '333333333333',
            'phone' => '9876543213',
            'payment_status' => 'success',
            'full_name' => 'REJECTED VOLUNTEER USER',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'assembly_segment' => 'Badvel',
            'mandal' => 'Porumamilla',
            'grama_panchayat' => 'Porumamilla GP',
            'is_completed' => 1
        ]);

        $this->volunteerRejected = Volunteer::create([
            'membership_id' => $this->memberC->membership_id,
            'phone' => $this->memberC->phone,
            'qualification' => 'Graduate',
            'voter_id_number' => 'VTR333',
            'email' => 'rejected@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Rejected User',
            'account_number' => '333333',
            'ifsc_code' => 'SBIN0001',
            'branch_name' => 'Kadapa',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Nominee',
            'nominee_phone' => '9876543210',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'rejected',
            'is_active' => true,
            'cadre' => 'Volunteer',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'assembly_segment' => 'Badvel',
            'mandal' => 'Porumamilla',
            'grama_panchayat' => 'Porumamilla GP',
        ]);

        // Member D (Approved Volunteer in Kurnool - Different District)
        $this->memberD = Membership::create([
            'membership_id' => '444444444444',
            'phone' => '9876543214',
            'payment_status' => 'success',
            'full_name' => 'KURNOOL APPROVED VOLUNTEER',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kurnool',
            'assembly_segment' => 'Nandyal',
            'mandal' => 'Nandyal',
            'grama_panchayat' => 'Nandyal Town',
            'is_completed' => 1
        ]);

        Volunteer::create([
            'membership_id' => $this->memberD->membership_id,
            'phone' => $this->memberD->phone,
            'qualification' => 'Graduate',
            'voter_id_number' => 'VTR444',
            'email' => 'kurnool@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Kurnool User',
            'account_number' => '444444',
            'ifsc_code' => 'SBIN0001',
            'branch_name' => 'Kurnool',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Nominee',
            'nominee_phone' => '9876543210',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'approved',
            'is_active' => true,
            'volunteer_id' => '100002',
            'volunteer_login_id' => '100002',
            'cadre' => 'State Coordinator',
            'designation' => 'State Coordinator',
            'locality' => 'Kurnool District',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kurnool',
            'assembly_segment' => 'Nandyal',
            'mandal' => 'Nandyal',
            'grama_panchayat' => 'Nandyal Town',
        ]);

        // Regular Member who never applied for Volunteer
        $this->memberNonVolunteer = Membership::create([
            'membership_id' => '555555555555',
            'phone' => '9876543215',
            'payment_status' => 'success',
            'full_name' => 'REGULAR NON-VOLUNTEER MEMBER',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'is_completed' => 1
        ]);
    }

    /**
     * TEST 1: /our-team-members renders successfully and shows ONLY approved volunteers.
     */
    public function test_our_team_page_shows_only_approved_volunteers(): void
    {
        $res = $this->get(route('public.team'));
        $res->assertStatus(200);

        // Approved volunteers must be visible
        $res->assertSee('APPROVED VOLUNTEER KASI');
        $res->assertSee('KURNOOL APPROVED VOLUNTEER');
        $res->assertSee('100001');
        $res->assertSee('100002');
        $res->assertSee('District Coordinator');
        $res->assertSee('State Coordinator');

        // Pending and Rejected volunteers must NOT be visible
        $res->assertDontSee('PENDING VOLUNTEER USER');
        $res->assertDontSee('REJECTED VOLUNTEER USER');

        // Non-volunteer members must NOT be visible
        $res->assertDontSee('REGULAR NON-VOLUNTEER MEMBER');
    }

    /**
     * TEST 2: Inactive volunteers are hidden.
     */
    public function test_inactive_volunteer_is_hidden(): void
    {
        $this->volunteerApproved->update(['is_active' => false]);

        $res = $this->get(route('public.team'));
        $res->assertStatus(200);
        $res->assertDontSee('APPROVED VOLUNTEER KASI');
    }

    /**
     * TEST 3: Regional filtering by District works.
     */
    public function test_location_district_filtering(): void
    {
        $res = $this->get(route('public.team', ['district' => 'Kadapa']));
        $res->assertStatus(200);
        $res->assertSee('APPROVED VOLUNTEER KASI');
        $res->assertDontSee('KURNOOL APPROVED VOLUNTEER');

        $resKurnool = $this->get(route('public.team', ['district' => 'Kurnool']));
        $resKurnool->assertStatus(200);
        $resKurnool->assertSee('KURNOOL APPROVED VOLUNTEER');
        $resKurnool->assertDontSee('APPROVED VOLUNTEER KASI');
    }

    /**
     * TEST 4: Assembly segment and Mandal level filtering.
     */
    public function test_assembly_and_mandal_filtering(): void
    {
        $res = $this->get(route('public.team', [
            'district' => 'Kadapa',
            'assembly_segment' => 'Badvel',
            'mandal' => 'Porumamilla'
        ]));
        $res->assertStatus(200);
        $res->assertSee('APPROVED VOLUNTEER KASI');
        $res->assertDontSee('KURNOOL APPROVED VOLUNTEER');
    }

    /**
     * TEST 5: Cadre filtering works.
     */
    public function test_cadre_filtering(): void
    {
        $res = $this->get(route('public.team', ['cadre' => 'District Coordinator']));
        $res->assertStatus(200);
        $res->assertSee('APPROVED VOLUNTEER KASI');
        $res->assertDontSee('KURNOOL APPROVED VOLUNTEER');
    }

    /**
     * TEST 6: Search query works.
     */
    public function test_search_by_keyword(): void
    {
        $res = $this->get(route('public.team', ['search' => 'KASI']));
        $res->assertStatus(200);
        $res->assertSee('APPROVED VOLUNTEER KASI');
        $res->assertDontSee('KURNOOL APPROVED VOLUNTEER');

        $resId = $this->get(route('public.team', ['search' => '100002']));
        $resId->assertStatus(200);
        $resId->assertSee('KURNOOL APPROVED VOLUNTEER');
        $resId->assertDontSee('APPROVED VOLUNTEER KASI');
    }

    /**
     * TEST 7: Privacy check - Sensitive data (phone, email, bank details) must NOT be exposed.
     */
    public function test_sensitive_personal_data_not_exposed(): void
    {
        $res = $this->get(route('public.team'));
        $res->assertStatus(200);

        // Sensitive fields from volunteer row
        $res->assertDontSee('9876543212'); // Mobile
        $res->assertDontSee('approved@test.com'); // Email
        $res->assertDontSee('222222'); // Bank account
        $res->assertDontSee('HDFC0001'); // IFSC
        $res->assertDontSee('VTR222'); // Voter ID
    }

    /**
     * TEST 8: When Admin approves Pending volunteer, they automatically become visible.
     */
    public function test_admin_approval_gate_makes_volunteer_visible_automatically(): void
    {
        // Initially pending -> not visible
        $res1 = $this->get(route('public.team'));
        $res1->assertDontSee('PENDING VOLUNTEER USER');

        // Admin approves volunteer
        $this->volunteerPending->update([
            'status' => 'approved',
            'is_active' => true,
            'volunteer_id' => '100003',
            'volunteer_login_id' => '100003',
            'cadre' => 'Mandal Coordinator'
        ]);

        // Now visible
        $res2 = $this->get(route('public.team'));
        $res2->assertSee('PENDING VOLUNTEER USER');
        $res2->assertSee('100003');
        $res2->assertSee('Mandal Coordinator');
    }
}
