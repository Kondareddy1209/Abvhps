<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Membership;
use App\Models\Volunteer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VolunteerAdminTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $member;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->admin = User::create([
            'name' => 'ADMIN TEST',
            'email' => 'admin@test.com',
            'password' => bcrypt('123456789')
        ]);

        $this->member = Membership::create([
            'membership_id' => '123456789012',
            'phone' => '9876543210',
            'payment_status' => 'success',
            'payment_id' => 'TXN-VOLTEST',
            'aadhaar_number' => '987654321098',
            'full_name' => 'KASI VOLUNTEER',
            'father_or_husband_name' => 'Father Name',
            'gotram' => 'Gotram',
            'occupation' => 'Business',
            'blood_group' => 'B+',
            'email' => 'volunteer@test.com',
            'pincode' => '516193',
            'grama_panchayat' => 'Porumamilla',
            'mandal' => 'Porumamilla',
            'assembly_segment' => 'Badvel',
            'district' => 'Kadapa',
            'state' => 'Andhra Pradesh',
            'country' => 'India',
            'is_completed' => 1
        ]);
    }

    public function test_admin_can_access_volunteer_list_screen_one(): void
    {
        $volunteer = Volunteer::create([
            'membership_id' => $this->member->membership_id,
            'phone' => $this->member->phone,
            'qualification' => 'Graduate',
            'voter_id_number' => 'VOTER12345',
            'email' => 'volunteer@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Kasi',
            'account_number' => '1234567890',
            'ifsc_code' => 'SBIN0001234',
            'branch_name' => 'Porumamilla',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Mother',
            'nominee_phone' => '9876543211',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.volunteers.index'));
        $response->assertStatus(200);
        $response->assertSee('Volunteer List');
        $response->assertSee('Home - Volunteer');
        $response->assertSee('Search Volunteer');
        $response->assertSee('KASI VOLUNTEER');
        $response->assertSee('9876543210');
        $response->assertSee('View');
        $response->assertSee('Edit');
        $response->assertSee('Update');
        $response->assertSee('Delete');
    }

    public function test_admin_can_view_volunteer_profile_dossier(): void
    {
        $volunteer = Volunteer::create([
            'membership_id' => $this->member->membership_id,
            'phone' => $this->member->phone,
            'qualification' => 'Post Graduate',
            'voter_id_number' => 'VOTERVIEW1',
            'email' => 'view@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Kasi',
            'account_number' => '1234567890',
            'ifsc_code' => 'SBIN0001234',
            'branch_name' => 'Porumamilla',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Mother',
            'nominee_phone' => '9876543211',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.volunteers.view', $volunteer->id));
        $response->assertStatus(200);
        $response->assertSee('Volunteer Dossier: KASI VOLUNTEER');
        $response->assertSee('VOTERVIEW1');
        $response->assertSee('Banking & Nominee Details', false);
    }

    public function test_admin_can_view_full_edit_form(): void
    {
        $volunteer = Volunteer::create([
            'membership_id' => $this->member->membership_id,
            'phone' => $this->member->phone,
            'qualification' => 'B.Tech Graduate',
            'voter_id_number' => 'VOTERFULL1',
            'email' => 'editfull@test.com',
            'bank_name' => 'Canara Bank',
            'account_holder_name' => 'Kasi Reddy',
            'account_number' => '987654321012',
            'ifsc_code' => 'CNRB0001234',
            'branch_name' => 'Porumamilla Main',
            'nominee_name' => 'Lakshmi',
            'nominee_relation' => 'Mother',
            'nominee_phone' => '9876543219',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.volunteers.edit', $volunteer->id));
        $response->assertStatus(200);
        $response->assertSee('Edit Volunteer Application Profile');
        $response->assertSee('B.Tech Graduate');
        $response->assertSee('CNRB0001234');
        $response->assertSee('Porumamilla Main');
    }

    public function test_admin_can_update_full_profile_without_touching_status_or_cadre(): void
    {
        $volunteer = Volunteer::create([
            'membership_id' => $this->member->membership_id,
            'phone' => $this->member->phone,
            'qualification' => 'Intermediate',
            'voter_id_number' => 'VOTEROLD1',
            'email' => 'old@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Kasi',
            'account_number' => '111122223333',
            'ifsc_code' => 'SBIN0001111',
            'branch_name' => 'Old Branch',
            'nominee_name' => 'Old Nominee',
            'nominee_relation' => 'Father',
            'nominee_phone' => '9876543210',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'pending',
            'cadre' => 'Existing Cadre',
            'locality' => 'Existing Locality'
        ]);

        $newDeclFile = UploadedFile::fake()->create('new_decl.pdf', 100);

        $response = $this->actingAs($this->admin)->post(route('admin.volunteers.update', $volunteer->id), [
            'qualification' => 'Master of Computer Applications',
            'voter_id_number' => 'VOTERNEW99',
            'email' => 'newemail@test.com',
            'bank_name' => 'HDFC Bank',
            'account_holder_name' => 'Kasi Swamireddy',
            'account_number' => '5010023456789',
            'ifsc_code' => 'HDFC0001234',
            'branch_name' => 'Kadapa City',
            'nominee_name' => 'Sujatha',
            'nominee_relation' => 'Spouse',
            'nominee_phone' => '9123456789',
            'doc_declaration' => $newDeclFile
        ]);

        $response->assertRedirect(route('admin.volunteers.index'));

        $volunteer->refresh();
        $this->assertEquals('Master of Computer Applications', $volunteer->qualification);
        $this->assertEquals('VOTERNEW99', $volunteer->voter_id_number);
        $this->assertEquals('newemail@test.com', $volunteer->email);
        $this->assertEquals('HDFC Bank', $volunteer->bank_name);
        $this->assertEquals('5010023456789', $volunteer->account_number);
        $this->assertEquals('HDFC0001234', $volunteer->ifsc_code);
        $this->assertEquals('Sujatha', $volunteer->nominee_name);
        // Untouched fields
        $this->assertEquals('pending', $volunteer->status);
        $this->assertEquals('Existing Cadre', $volunteer->cadre);
        $this->assertEquals('Existing Locality', $volunteer->locality);
        $this->assertNull($volunteer->volunteer_id);
    }

    public function test_admin_can_view_cadre_edit_form(): void
    {
        $volunteer = Volunteer::create([
            'membership_id' => $this->member->membership_id,
            'phone' => $this->member->phone,
            'qualification' => 'Graduate',
            'voter_id_number' => 'VOTERCADRE1',
            'email' => 'cadre@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Kasi',
            'account_number' => '1234567890',
            'ifsc_code' => 'SBIN0001234',
            'branch_name' => 'Porumamilla',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Mother',
            'nominee_phone' => '9876543211',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'pending',
            'cadre' => 'Youth Seva Core',
            'locality' => 'Porumamilla'
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.volunteers.cadreEdit', $volunteer->id));
        $response->assertStatus(200);
        $response->assertSee('Volunteer Approval Details');
        $response->assertSee('KASI VOLUNTEER');
        $response->assertSee('Youth Seva Core');
        $response->assertSee('Porumamilla');
    }

    public function test_admin_can_approve_volunteer_via_cadre_update_and_generate_credentials(): void
    {
        $volunteer = Volunteer::create([
            'membership_id' => $this->member->membership_id,
            'phone' => $this->member->phone,
            'qualification' => 'Post Graduate',
            'voter_id_number' => 'VTR999888',
            'email' => 'volunteer@test.com',
            'bank_name' => 'HDFC',
            'account_holder_name' => 'Kasi',
            'account_number' => '9876543210',
            'ifsc_code' => 'HDFC0001234',
            'branch_name' => 'Kadapa',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Brother',
            'nominee_phone' => '9876543212',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.volunteers.cadreUpdate', $volunteer->id), [
            'status' => 'Verified',
            'cadre' => 'National Co-Ordinator',
            'locality' => 'Badvel'
        ]);

        $volunteer->refresh();

        $this->assertEquals('approved', $volunteer->status);
        $this->assertEquals('National Co-Ordinator', $volunteer->cadre);
        $this->assertEquals('Badvel', $volunteer->locality);
        $this->assertNotNull($volunteer->volunteer_id);
        $this->assertNotNull($volunteer->password);

        $response->assertRedirect('/admin/volunteer/view-card/' . $volunteer->volunteer_id);
    }

    public function test_subsequent_cadre_update_preserves_volunteer_id(): void
    {
        $volunteer = Volunteer::create([
            'membership_id' => $this->member->membership_id,
            'phone' => $this->member->phone,
            'qualification' => 'Graduate',
            'voter_id_number' => 'VTR111222',
            'email' => 'volunteer@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Kasi',
            'account_number' => '1112223334',
            'ifsc_code' => 'SBIN0001111',
            'branch_name' => 'Badvel',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Father',
            'nominee_phone' => '9876543213',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'approved',
            'volunteer_id' => '654321',
            'password' => bcrypt('ABVHPS@9999'),
            'cadre' => 'Original Cadre',
            'locality' => 'Badvel'
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.volunteers.cadreUpdate', $volunteer->id), [
            'status' => 'Verified',
            'cadre' => 'Apex Leadership Cadre',
            'locality' => 'Kadapa City'
        ]);

        $volunteer->refresh();

        $this->assertEquals('654321', $volunteer->volunteer_id); // Preserved without regenerating!
        $this->assertEquals('Apex Leadership Cadre', $volunteer->cadre);
        $this->assertEquals('Kadapa City', $volunteer->locality);

        $response->assertRedirect('/admin/volunteer/view-card/654321');
    }

    public function test_admin_can_reject_volunteer_via_cadre_update(): void
    {
        $volunteer = Volunteer::create([
            'membership_id' => $this->member->membership_id,
            'phone' => $this->member->phone,
            'qualification' => 'Intermediate',
            'voter_id_number' => 'VTRREJECT1',
            'email' => 'reject@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Reject User',
            'account_number' => '5556667778',
            'ifsc_code' => 'SBIN0005555',
            'branch_name' => 'Branch',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Friend',
            'nominee_phone' => '9876543214',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.volunteers.cadreUpdate', $volunteer->id), [
            'status' => 'Rejected',
            'cadre' => 'Invalid Docs',
            'locality' => 'None'
        ]);

        $volunteer->refresh();

        $this->assertEquals('rejected', $volunteer->status);
        $this->assertNull($volunteer->volunteer_id);
        $this->assertNull($volunteer->password);

        $response->assertRedirect(route('admin.volunteers.index'));
    }

    public function test_admin_can_delete_volunteer(): void
    {
        $volunteer = Volunteer::create([
            'membership_id' => $this->member->membership_id,
            'phone' => $this->member->phone,
            'qualification' => 'Intermediate',
            'voter_id_number' => 'VTRDEL1',
            'email' => 'delete@test.com',
            'bank_name' => 'SBI',
            'account_holder_name' => 'Delete User',
            'account_number' => '5556667778',
            'ifsc_code' => 'SBIN0005555',
            'branch_name' => 'Branch',
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Friend',
            'nominee_phone' => '9876543214',
            'document_declaration_path' => 'doc1.pdf',
            'document_voter_path' => 'doc2.pdf',
            'document_bank_path' => 'doc3.pdf',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.volunteers.delete', $volunteer->id));
        $response->assertRedirect(route('admin.volunteers.index'));

        $this->assertDatabaseMissing('volunteers', ['id' => $volunteer->id]);
    }
}
