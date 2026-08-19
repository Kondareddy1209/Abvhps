<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Membership;
use App\Models\Volunteer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class VolunteerLoginTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Membership $memberPending;
    protected Membership $memberApproved;
    protected Membership $memberRejected;
    protected Volunteer $volunteerPending;
    protected Volunteer $volunteerApproved;
    protected Volunteer $volunteerRejected;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'ADMIN TEST',
            'email' => 'admin@test.com',
            'password' => bcrypt('123456789'),
        ]);

        // Member A (Pending Volunteer)
        $this->memberPending = Membership::create([
            'membership_id' => '111111111111',
            'phone' => '9876543211',
            'payment_status' => 'success',
            'full_name' => 'PENDING VOLUNTEER',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'is_completed' => 1
        ]);

        $this->volunteerPending = Volunteer::create([
            'membership_id' => $this->memberPending->membership_id,
            'phone' => $this->memberPending->phone,
            'qualification' => 'Graduate',
            'voter_id_number' => 'VTR1111',
            'email' => 'pending_vol@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Pending',
            'account_number' => '111111',
            'ifsc_code' => 'SBIN0001',
            'branch_name' => 'Kadapa',
            'nominee_name' => 'Mother',
            'nominee_relation' => 'Mother',
            'nominee_phone' => '9876543210',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'pending',
            'is_active' => false,
            'volunteer_login_id' => '100001',
            'password' => Hash::make('ABVH@Temp123'),
            'must_change_password' => true,
        ]);

        // Member B (Approved Volunteer)
        $this->memberApproved = Membership::create([
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
            'membership_id' => $this->memberApproved->membership_id,
            'phone' => $this->memberApproved->phone,
            'qualification' => 'Post Graduate',
            'voter_id_number' => 'VTR2222',
            'email' => 'approved_vol@test.com',
            'bank_name' => 'HDFC',
            'account_holder_name' => 'Kasi',
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
            'volunteer_id' => '100002',
            'volunteer_login_id' => '100002',
            'password' => Hash::make('ABVH@Temp456'),
            'must_change_password' => true,
            'cadre' => 'District Coordinator',
            'designation' => 'District Coordinator',
            'locality' => 'Kadapa District',
        ]);

        // Member C (Rejected Volunteer)
        $this->memberRejected = Membership::create([
            'membership_id' => '333333333333',
            'phone' => '9876543213',
            'payment_status' => 'success',
            'full_name' => 'REJECTED VOLUNTEER',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'is_completed' => 1
        ]);

        $this->volunteerRejected = Volunteer::create([
            'membership_id' => $this->memberRejected->membership_id,
            'phone' => $this->memberRejected->phone,
            'qualification' => 'Graduate',
            'voter_id_number' => 'VTR3333',
            'email' => 'rejected_vol@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Rejected',
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
            'is_active' => false,
            'volunteer_login_id' => '100003',
            'password' => Hash::make('ABVH@Temp789'),
            'must_change_password' => true,
        ]);
    }

    /**
     * TEST 1: Pending volunteer CANNOT log in.
     */
    public function test_pending_volunteer_cannot_login(): void
    {
        $res = $this->post(route('volunteer.login.submit'), [
            'volunteer_id' => '100001',
            'password' => 'ABVH@Temp123'
        ]);

        $res->assertSessionHasErrors('volunteer_id');
        $this->assertFalse(Auth::guard('volunteer')->check());
    }

    /**
     * TEST 2: Rejected volunteer CANNOT log in.
     */
    public function test_rejected_volunteer_cannot_login(): void
    {
        $res = $this->post(route('volunteer.login.submit'), [
            'volunteer_id' => '100003',
            'password' => 'ABVH@Temp789'
        ]);

        $res->assertSessionHasErrors('volunteer_id');
        $this->assertFalse(Auth::guard('volunteer')->check());
    }

    /**
     * TEST 3: Inactive volunteer CANNOT log in.
     */
    public function test_inactive_volunteer_cannot_login(): void
    {
        $this->volunteerApproved->update(['is_active' => false]);

        $res = $this->post(route('volunteer.login.submit'), [
            'volunteer_id' => '100002',
            'password' => 'ABVH@Temp456'
        ]);

        $res->assertSessionHasErrors('volunteer_id');
        $this->assertFalse(Auth::guard('volunteer')->check());
    }

    /**
     * TEST 4: Approved volunteer can log in with 6-digit Login ID and temporary password.
     */
    public function test_approved_volunteer_can_login_with_temporary_password(): void
    {
        $res = $this->post(route('volunteer.login.submit'), [
            'volunteer_id' => '100002',
            'password' => 'ABVH@Temp456'
        ]);

        $this->assertTrue(Auth::guard('volunteer')->check());
        $this->assertEquals($this->volunteerApproved->id, Auth::guard('volunteer')->id());
        $res->assertRedirect(route('volunteer.change_password'));
    }

    /**
     * TEST 5: First-login forces password change and blocks dashboard.
     */
    public function test_first_login_forces_password_change(): void
    {
        // Act as authenticated volunteer with must_change_password = true
        $this->actingAs($this->volunteerApproved, 'volunteer');

        // Trying to access dashboard redirects to change-password
        $res = $this->get(route('volunteer.dashboard'));
        $res->assertRedirect(route('volunteer.change_password'));
    }

    /**
     * TEST 6: Changing temporary password succeeds and enables dashboard access.
     */
    public function test_changing_password_enables_dashboard_access(): void
    {
        $this->actingAs($this->volunteerApproved, 'volunteer');

        $res = $this->post(route('volunteer.change_password.submit'), [
            'current_password' => 'ABVH@Temp456',
            'new_password' => 'PermanentSecPass#2026',
            'new_password_confirmation' => 'PermanentSecPass#2026',
        ]);

        $res->assertRedirect(route('volunteer.dashboard'));
        $res->assertSessionHas('success');

        $this->volunteerApproved->refresh();
        $this->assertFalse($this->volunteerApproved->must_change_password);
        $this->assertTrue(Hash::check('PermanentSecPass#2026', $this->volunteerApproved->password));

        // Now dashboard is directly accessible
        $dashRes = $this->get(route('volunteer.dashboard'));
        $dashRes->assertStatus(200);
        $dashRes->assertSee('APPROVED VOLUNTEER KASI');
        $dashRes->assertSee('100002');
    }

    /**
     * TEST 7: Old temporary password no longer works after password change.
     */
    public function test_old_temporary_password_no_longer_works_after_change(): void
    {
        $this->volunteerApproved->update([
            'password' => Hash::make('PermanentSecPass#2026'),
            'must_change_password' => false,
        ]);

        Auth::guard('volunteer')->logout();

        $res = $this->post(route('volunteer.login.submit'), [
            'volunteer_id' => '100002',
            'password' => 'ABVH@Temp456' // Old temp pass
        ]);

        $res->assertSessionHasErrors('password');
        $this->assertFalse(Auth::guard('volunteer')->check());

        // New password works
        $res2 = $this->post(route('volunteer.login.submit'), [
            'volunteer_id' => '100002',
            'password' => 'PermanentSecPass#2026'
        ]);
        $res2->assertRedirect(route('volunteer.dashboard'));
        $this->assertTrue(Auth::guard('volunteer')->check());
    }

    /**
     * TEST 8: Volunteer cannot access Admin Panel.
     */
    public function test_volunteer_cannot_access_admin_panel(): void
    {
        $this->actingAs($this->volunteerApproved, 'volunteer');

        // Admin routes use 'auth:web' (web guard), so volunteer cannot access and is redirected to /admin/login
        $res = $this->get(route('admin.volunteers.index'));
        $res->assertRedirect('/admin/login');
    }

    /**
     * TEST 9: Normal user cannot access Volunteer Dashboard.
     */
    public function test_normal_user_cannot_access_volunteer_dashboard(): void
    {
        $user = User::create([
            'name' => 'Normal User',
            'email' => 'normal@test.com',
            'password' => bcrypt('password123'),
        ]);
        $this->actingAs($user, 'web');

        $res = $this->get(route('volunteer.dashboard'));
        $res->assertRedirect(route('volunteer.login'));
    }

    /**
     * TEST 10: Admin approving a pending volunteer assigns unique 6-digit Login ID and sends welcome email.
     */
    public function test_admin_approving_volunteer_generates_6_digit_login_id(): void
    {
        $freshMember = Membership::create([
            'membership_id' => '777777777777',
            'phone' => '9876543277',
            'payment_status' => 'success',
            'full_name' => 'FRESH VOLUNTEER CANDIDATE',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'is_completed' => 1
        ]);

        $volunteer = Volunteer::create([
            'membership_id' => $freshMember->membership_id,
            'phone' => '9876543277',
            'qualification' => 'B.Tech',
            'voter_id_number' => 'VTR9999',
            'email' => 'fresh_vol@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Fresh User',
            'account_number' => '999999',
            'ifsc_code' => 'SBIN0001',
            'branch_name' => 'Badvel',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Nominee',
            'nominee_phone' => '9876543210',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'pending'
        ]);

        $res = $this->actingAs($this->admin)->post(route('admin.volunteers.cadreUpdate', $volunteer->id), [
            'status' => 'Verified',
            'cadre' => 'Mandal Coordinator',
            'locality' => 'Porumamilla'
        ]);

        $volunteer->refresh();

        $this->assertEquals('approved', $volunteer->status);
        $this->assertTrue($volunteer->is_active);
        $this->assertNotNull($volunteer->volunteer_login_id);
        $this->assertMatchesRegularExpression('/^[0-9]{6}$/', $volunteer->volunteer_login_id);
        $this->assertTrue($volunteer->must_change_password);
        $this->assertNotNull($volunteer->welcome_email_sent_at);
    }

    /**
     * TEST 11: Admin can resend credentials to an approved volunteer.
     */
    public function test_admin_can_resend_credentials(): void
    {
        $res = $this->actingAs($this->admin)->post(route('admin.volunteers.resendCredentials', $this->volunteerApproved->id));
        $res->assertSessionHas('success');

        $this->volunteerApproved->refresh();
        $this->assertTrue($this->volunteerApproved->must_change_password);
        $this->assertNotNull($this->volunteerApproved->welcome_email_sent_at);
    }

    /**
     * TEST 12: Multiple volunteers get unique 6-digit IDs and isolate private data.
     */
    public function test_multiple_volunteers_unique_ids_and_data_isolation(): void
    {
        $v1 = $this->volunteerApproved;

        $m2 = Membership::create([
            'membership_id' => '666666666666',
            'phone' => '9876543266',
            'payment_status' => 'success',
            'full_name' => 'VOLUNTEER TWO',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kurnool',
            'is_completed' => 1
        ]);

        $v2 = Volunteer::create([
            'membership_id' => $m2->membership_id,
            'phone' => $m2->phone,
            'qualification' => 'Graduate',
            'voter_id_number' => 'VTR6666',
            'email' => 'vol2@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Vol Two',
            'account_number' => '666666',
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
            'volunteer_login_id' => '100004',
            'volunteer_id' => '100004',
            'password' => Hash::make('ABVH@Vol2Pass'),
            'must_change_password' => false,
            'cadre' => 'State Coordinator',
        ]);

        $this->assertNotEquals($v1->volunteer_login_id, $v2->volunteer_login_id);
        $this->assertEquals('100002', $v1->volunteer_login_id);
        $this->assertEquals('100004', $v2->volunteer_login_id);

        // V2 logs in
        $this->actingAs($v2, 'volunteer');
        $res = $this->get(route('volunteer.dashboard'));
        $res->assertStatus(200);
        $res->assertSee('VOLUNTEER TWO');
        $res->assertSee('100004');
        $res->assertDontSee('APPROVED VOLUNTEER KASI');
    }
}
