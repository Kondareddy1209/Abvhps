<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Membership;
use App\Models\Volunteer;
use App\Models\AuditLog;

class VolunteerMemberDataTest extends TestCase
{
    use RefreshDatabase;

    protected Volunteer $approvedVolunteer;
    protected Volunteer $pendingVolunteer;
    protected Volunteer $rejectedVolunteer;
    protected Volunteer $inactiveVolunteer;
    protected Membership $memberA;
    protected Membership $memberB;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Approved & Active Volunteer (Kadapa / Porumamilla)
        $mVol = Membership::create([
            'membership_id' => '583742916405',
            'phone' => '9876543210',
            'payment_status' => 'success',
            'full_name' => 'ACTIVE VOLUNTEER',
            'district' => 'YSR Kadapa',
            'mandal' => 'Porumamilla',
            'grama_panchayat' => 'Porumamilla',
            'is_completed' => 1
        ]);

        $this->approvedVolunteer = Volunteer::create([
            'membership_id' => $mVol->membership_id,
            'phone' => $mVol->phone,
            'email' => 'active_vol@abvhps.org',
            'status' => 'approved',
            'is_active' => true,
            'volunteer_id' => '583214',
            'volunteer_login_id' => '583214',
            'password' => Hash::make('SecretPass123'),
            'must_change_password' => false,
            'cadre' => 'District Coordinator',
            'locality' => 'Porumamilla',
            'district' => 'YSR Kadapa',
            'mandal' => 'Porumamilla',
            'grama_panchayat' => 'Porumamilla',
            'qualification' => 'Post Graduate',
            'voter_id_number' => 'VTR583',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Active Vol',
            'account_number' => '583214583',
            'ifsc_code' => 'SBIN0001',
            'branch_name' => 'Porumamilla',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Father',
            'nominee_phone' => '9876543210',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
        ]);

        // 2. Pending Volunteer
        $mPending = Membership::create([
            'membership_id' => '111122223333',
            'phone' => '9876543211',
            'payment_status' => 'success',
            'full_name' => 'PENDING VOLUNTEER',
            'is_completed' => 1
        ]);

        $this->pendingVolunteer = Volunteer::create([
            'membership_id' => $mPending->membership_id,
            'phone' => $mPending->phone,
            'email' => 'pending_vol@abvhps.org',
            'status' => 'pending',
            'is_active' => false,
            'volunteer_id' => '100002',
            'volunteer_login_id' => '100002',
            'password' => Hash::make('Password123'),
            'qualification' => 'Graduate',
            'voter_id_number' => 'VTR111',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Pending Vol',
            'account_number' => '111222',
            'ifsc_code' => 'SBIN0001',
            'branch_name' => 'HQ',
            'nominee_name' => 'Nom',
            'nominee_relation' => 'Father',
            'nominee_phone' => '9876543210',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
        ]);

        // 3. Sample Member in Porumamilla (YSR Kadapa)
        $this->memberA = Membership::create([
            'membership_id' => '915837429164',
            'phone' => '9988776655',
            'email' => 'private_member_a@secret.com',
            'aadhaar_number' => '999988887777',
            'payment_status' => 'success',
            'full_name' => 'RAVI KUMAR',
            'gender' => 'male',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'YSR Kadapa',
            'assembly_segment' => 'Badvel',
            'mandal' => 'Porumamilla',
            'grama_panchayat' => 'Porumamilla Village',
            'is_completed' => 1
        ]);

        // 4. Sample Member in DIFFERENT AREA (Kurnool / Nandyal)
        $this->memberB = Membership::create([
            'membership_id' => '741905216438',
            'phone' => '9988776644',
            'email' => 'private_member_b@secret.com',
            'aadhaar_number' => '888877776666',
            'payment_status' => 'success',
            'full_name' => 'LAKSHMI DEVI',
            'gender' => 'female',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kurnool',
            'assembly_segment' => 'Nandyal',
            'mandal' => 'Nandyal Rural',
            'grama_panchayat' => 'Mahanandi Village',
            'is_completed' => 1
        ]);
    }

    /**
     * 1. Guest cannot access Member Data.
     */
    public function test_guest_cannot_access_member_data(): void
    {
        $res = $this->get(route('volunteer.member_data'));
        $res->assertRedirect(route('volunteer.login'));

        $resSearch = $this->post(route('volunteer.member_data.search'), []);
        $resSearch->assertRedirect(route('volunteer.login'));
    }

    /**
     * 2. Normal user cannot access Member Data.
     */
    public function test_normal_user_cannot_access_member_data(): void
    {
        $user = User::create([
            'name' => 'Normal User',
            'email' => 'user@test.com',
            'password' => bcrypt('Password123')
        ]);

        $res = $this->actingAs($user, 'web')->get(route('volunteer.member_data'));
        $res->assertRedirect(route('volunteer.login'));
    }

    /**
     * 3. Pending volunteer cannot access Member Data.
     */
    public function test_pending_volunteer_cannot_access_member_data(): void
    {
        $res = $this->actingAs($this->pendingVolunteer, 'volunteer')->get(route('volunteer.member_data'));
        $res->assertRedirect(route('volunteer.login'));
    }

    /**
     * 4. Approved Active Volunteer can access Member Data page.
     */
    public function test_approved_volunteer_can_access_member_data(): void
    {
        $res = $this->actingAs($this->approvedVolunteer, 'volunteer')->get(route('volunteer.member_data'));
        $res->assertStatus(200);
        $res->assertSee('Area-wise Member Data');
        $res->assertSee('583214');
        $res->assertSee('YSR Kadapa');
        $res->assertSee('Kurnool');
    }

    /**
     * 5. Volunteer can search and view members in an area DIFFERENT from their own locality.
     */
    public function test_volunteer_can_select_and_search_any_area(): void
    {
        // Volunteer is from Porumamilla, searching for Kurnool area
        $res = $this->actingAs($this->approvedVolunteer, 'volunteer')->postJson(route('volunteer.member_data.search'), [
            'district' => 'Kurnool',
            'mandal' => 'Nandyal Rural',
        ]);

        $res->assertStatus(200);
        $res->assertJson([
            'success' => true,
            'total_count' => 1,
        ]);

        // Returns Lakshmi Devi in Kurnool
        $res->assertJsonFragment([
            'full_name' => 'LAKSHMI DEVI',
            'membership_id' => '741905216438',
            'gender' => 'female',
            'district' => 'Kurnool',
            'mandal' => 'Nandyal Rural',
        ]);

        // Strictly hides sensitive private data
        $res->assertJsonMissing(['phone' => '9988776644']);
        $res->assertJsonMissing(['email' => 'private_member_b@secret.com']);
        $res->assertJsonMissing(['aadhaar_number' => '888877776666']);
    }

    /**
     * 6. CSV Export streams voter-style columns and does not leak private information.
     */
    public function test_csv_export_returns_safe_data(): void
    {
        $res = $this->actingAs($this->approvedVolunteer, 'volunteer')->post(route('volunteer.member_data.export_csv'), [
            'district' => 'YSR Kadapa',
        ]);

        $res->assertStatus(200);
        $content = $res->streamedContent();

        // Check Safe Columns
        $this->assertStringContainsString('RAVI KUMAR', $content);
        $this->assertStringContainsString('915837429164', $content);
        $this->assertStringContainsString('YSR Kadapa', $content);

        // Check Excluded Data
        $this->assertStringNotContainsString('9988776655', $content);
        $this->assertStringNotContainsString('private_member_a@secret.com', $content);
        $this->assertStringNotContainsString('999988887777', $content);
    }

    /**
     * 7. PDF Export generates valid file and logs audit trail.
     */
    public function test_pdf_export_generates_and_creates_audit_log(): void
    {
        $res = $this->actingAs($this->approvedVolunteer, 'volunteer')->post(route('volunteer.member_data.export_pdf'), [
            'district' => 'YSR Kadapa',
            'mandal' => 'Porumamilla',
        ]);

        $res->assertStatus(200);
        $this->assertEquals('application/pdf', $res->headers->get('Content-Type'));

        // Check Audit Log
        $log = AuditLog::where('action', 'MEMBER_DATA_EXPORT')
            ->where('actor_identifier', '583214')
            ->first();

        $this->assertNotNull($log, "MEMBER_DATA_EXPORT audit log must be recorded");
        $this->assertEquals('PDF', $log->metadata['format']);
        $this->assertEquals('YSR Kadapa', $log->metadata['district']);
        $this->assertEquals('Porumamilla', $log->metadata['mandal']);

        // Ensure no member PII is inside audit log metadata
        $this->assertStringNotContainsString('RAVI KUMAR', json_encode($log->metadata));
        $this->assertStringNotContainsString('915837429164', json_encode($log->metadata));
    }
}
