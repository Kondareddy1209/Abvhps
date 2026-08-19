<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Membership;
use App\Models\RudrasenaMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\VolunteerWelcomeMail;
use App\Mail\RudrasenaWelcomeMail;
use App\Models\Volunteer;

class RudrasenaAdminTest extends TestCase
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
            'membership_id' => '915000111222',
            'phone' => '9876543210',
            'payment_status' => 'success',
            'payment_id' => 'TXN-RUDRASENA',
            'aadhaar_number' => '987654321098',
            'full_name' => 'KASI RUDRASENA',
            'father_or_husband_name' => 'Father Name',
            'gotram' => 'Siva Gotram',
            'occupation' => 'Business',
            'blood_group' => 'O+',
            'email' => 'rudrasena@test.com',
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

    public function test_sidebar_displays_rudrasena_without_matrix(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.membership.ledger'));
        $response->assertStatus(200);
        $response->assertSee('9. RUDRASENA');
        $response->assertDontSee('9. RUDRASENA MATRIX');
    }

    public function test_public_rudrasena_submission_requires_and_stores_volunteer_type(): void
    {
        $response = $this->postJson(route('rudrasena.submit'), [
            'membership_id' => $this->member->membership_id,
            'full_name' => 'KASI RUDRASENA',
            'email' => 'rudrasena@test.com',
            'mobile' => '9876543210',
            'volunteer_type' => 'Emergency Response',
            'dob' => '1995-05-15',
            'age' => 31,
            'blood_group' => 'O+',
            'gotram' => 'Siva Gotram',
            'nominee_name' => 'Nominee Lakshmi',
            'nominee_relation' => 'Mother',
            'nominee_age' => 55,
            'nominee_contact' => '9876543211',
            'bank_holder_name' => 'Kasi Rudrasena',
            'bank_account_number' => '123456789012',
            'bank_ifsc_code' => 'SBIN0001234',
            'bank_name_branch' => 'SBI Porumamilla',
            'document_health_declaration' => UploadedFile::fake()->create('health.jpg', 100, 'image/jpeg'),
            'document_family_declaration' => UploadedFile::fake()->create('family.jpg', 100, 'image/jpeg'),
            'document_id_proof' => UploadedFile::fake()->create('id.jpg', 100, 'image/jpeg'),
            'document_bank_proof' => UploadedFile::fake()->create('bank.jpg', 100, 'image/jpeg'),
            'disclaimer_accepted' => true,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $created = RudrasenaMember::where('membership_id', $this->member->membership_id)->first();
        $this->assertNotNull($created);
        $this->assertEquals('Emergency Response', $created->volunteer_type);
        $this->assertEquals('pending', $created->status);
    }

    public function test_admin_can_access_rudrasena_roster_grid(): void
    {
        $rudra = RudrasenaMember::create([
            'membership_id' => $this->member->membership_id,
            'full_name' => 'KASI RUDRASENA',
            'email' => 'rudrasena@test.com',
            'mobile' => '9876543210',
            'volunteer_type' => 'Full-Time Volunteer',
            'dob' => '1995-05-15',
            'age' => 31,
            'nominee_name' => 'Nominee',
            'nominee_relation' => 'Mother',
            'nominee_age' => 55,
            'nominee_contact' => '9876543211',
            'bank_holder_name' => 'Kasi',
            'bank_account_number' => '1234567890',
            'bank_ifsc_code' => 'SBIN0001234',
            'bank_name_branch' => 'SBI Porumamilla',
            'document_health_declaration' => 'doc1.jpg',
            'document_family_declaration' => 'doc2.jpg',
            'document_id_proof' => 'doc3.jpg',
            'document_bank_proof' => 'doc4.jpg',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.rudrasena.index'));
        $response->assertStatus(200);
        $response->assertSee('Rudrasena Member Roster');
        $response->assertSee('KASI RUDRASENA');
        $response->assertSee('Full-Time Volunteer');
        $response->assertSee('PENDING');
        $response->assertSee('ID Card');
    }

    public function test_admin_can_view_rudrasena_profile_dossier(): void
    {
        $rudra = RudrasenaMember::create([
            'membership_id' => $this->member->membership_id,
            'full_name' => 'KASI RUDRASENA',
            'email' => 'rudrasena@test.com',
            'mobile' => '9876543210',
            'volunteer_type' => 'Emergency Response',
            'dob' => '1995-05-15',
            'age' => 31,
            'nominee_name' => 'Nominee Mother',
            'nominee_relation' => 'Mother',
            'nominee_age' => 55,
            'nominee_contact' => '9876543211',
            'bank_holder_name' => 'Kasi',
            'bank_account_number' => '1234567890',
            'bank_ifsc_code' => 'SBIN0001234',
            'bank_name_branch' => 'SBI Porumamilla',
            'document_health_declaration' => 'doc1.jpg',
            'document_family_declaration' => 'doc2.jpg',
            'document_id_proof' => 'doc3.jpg',
            'document_bank_proof' => 'doc4.jpg',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.rudrasena.view', $rudra->id));
        $response->assertStatus(200);
        $response->assertSee('Rudrasena Dossier: KASI RUDRASENA');
        $response->assertSee('Emergency Response');
        $response->assertSee('View ID Card');
    }

    public function test_admin_can_view_rudrasena_id_card_preview_for_pending_and_verified(): void
    {
        $rudra = RudrasenaMember::create([
            'membership_id' => $this->member->membership_id,
            'full_name' => 'KASI RUDRASENA',
            'email' => 'rudrasena@test.com',
            'mobile' => '9876543210',
            'volunteer_type' => 'Emergency Response',
            'dob' => '1995-05-15',
            'age' => 31,
            'blood_group' => 'O+',
            'nominee_name' => 'Nominee Mother',
            'nominee_relation' => 'Mother',
            'nominee_age' => 55,
            'nominee_contact' => '9876543211',
            'bank_holder_name' => 'Kasi',
            'bank_account_number' => '1234567890',
            'bank_ifsc_code' => 'SBIN0001234',
            'bank_name_branch' => 'SBI Porumamilla',
            'document_health_declaration' => 'doc1.jpg',
            'document_family_declaration' => 'doc2.jpg',
            'document_id_proof' => 'doc3.jpg',
            'document_bank_proof' => 'doc4.jpg',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.rudrasena.view_card', $rudra->id));
        $response->assertStatus(200);
        $response->assertSee('rudrasena_card_bg.png');
        $response->assertSee('KASI RUDRASENA');
        $response->assertSee('PENDING APPROVAL');
        $response->assertSee('Pending Approval');
    }

    public function test_sequential_id_generation_rs0001_and_rs0002_on_first_approval(): void
    {
        $rudra1 = RudrasenaMember::create([
            'membership_id' => '915000111221',
            'full_name' => 'FIRST RUDRASENA',
            'email' => 'first@test.com',
            'mobile' => '9876543201',
            'volunteer_type' => 'Full-Time',
            'dob' => '1995-05-15',
            'age' => 31,
            'nominee_name' => 'Nominee 1',
            'nominee_relation' => 'Mother',
            'nominee_age' => 55,
            'nominee_contact' => '9876543211',
            'bank_holder_name' => 'User 1',
            'bank_account_number' => '1234567890',
            'bank_ifsc_code' => 'SBIN0001234',
            'bank_name_branch' => 'SBI Porumamilla',
            'document_health_declaration' => 'doc1.jpg',
            'document_family_declaration' => 'doc2.jpg',
            'document_id_proof' => 'doc3.jpg',
            'document_bank_proof' => 'doc4.jpg',
            'status' => 'pending'
        ]);

        $rudra2 = RudrasenaMember::create([
            'membership_id' => '915000111222',
            'full_name' => 'SECOND RUDRASENA',
            'email' => 'second@test.com',
            'mobile' => '9876543202',
            'volunteer_type' => 'Part-Time',
            'dob' => '1996-06-16',
            'age' => 30,
            'nominee_name' => 'Nominee 2',
            'nominee_relation' => 'Father',
            'nominee_age' => 58,
            'nominee_contact' => '9876543212',
            'bank_holder_name' => 'User 2',
            'bank_account_number' => '1234567891',
            'bank_ifsc_code' => 'SBIN0001234',
            'bank_name_branch' => 'SBI Badvel',
            'document_health_declaration' => 'doc1.jpg',
            'document_family_declaration' => 'doc2.jpg',
            'document_id_proof' => 'doc3.jpg',
            'document_bank_proof' => 'doc4.jpg',
            'status' => 'pending'
        ]);

        // Approve Rudrasena 1
        $res1 = $this->actingAs($this->admin)->post(route('admin.rudrasena.update', $rudra1->id), [
            'status' => 'Verified',
            'assigned_cadder' => 'Commander',
            'assigned_locality' => 'Porumamilla'
        ]);
        $res1->assertRedirect(route('admin.rudrasena.index'));

        $rudra1->refresh();
        $this->assertEquals('RS0001', $rudra1->rudrasena_id);
        $this->assertEquals('verified', $rudra1->status);
        $this->assertEquals('Commander', $rudra1->assigned_cadder);

        // Approve Rudrasena 2 -> should get RS0002 sequentially!
        $res2 = $this->actingAs($this->admin)->post(route('admin.rudrasena.update', $rudra2->id), [
            'status' => 'Verified',
            'assigned_cadder' => 'Captain',
            'assigned_locality' => 'Badvel'
        ]);
        $res2->assertRedirect(route('admin.rudrasena.index'));

        $rudra2->refresh();
        $this->assertEquals('RS0002', $rudra2->rudrasena_id);
        $this->assertEquals('verified', $rudra2->status);

        // Re-edit Rudrasena 1 cadre only -> RS0001 must be preserved!
        $res3 = $this->actingAs($this->admin)->post(route('admin.rudrasena.update', $rudra1->id), [
            'status' => 'Verified',
            'assigned_cadder' => 'Senior Commander',
            'assigned_locality' => 'Kadapa'
        ]);
        $rudra1->refresh();
        $this->assertEquals('RS0001', $rudra1->rudrasena_id); // Preserved!
        $this->assertEquals('Senior Commander', $rudra1->assigned_cadder);
    }

    public function test_rudrasena_approval_triggers_welcome_email_with_pdf_id_card(): void
    {
        Mail::fake();

        $rudra = RudrasenaMember::create([
            'membership_id' => $this->member->membership_id,
            'full_name' => 'KASI RUDRASENA',
            'email' => 'rudrasenamail@test.com',
            'mobile' => '9876543210',
            'volunteer_type' => 'Emergency Response',
            'dob' => '1995-05-15',
            'age' => 31,
            'blood_group' => 'O+',
            'nominee_name' => 'Nominee Mother',
            'nominee_relation' => 'Mother',
            'nominee_age' => 55,
            'nominee_contact' => '9876543211',
            'bank_holder_name' => 'Kasi',
            'bank_account_number' => '1234567890',
            'bank_ifsc_code' => 'SBIN0001234',
            'bank_name_branch' => 'SBI Porumamilla',
            'document_health_declaration' => 'doc1.jpg',
            'document_family_declaration' => 'doc2.jpg',
            'document_id_proof' => 'doc3.jpg',
            'document_bank_proof' => 'doc4.jpg',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.rudrasena.update', $rudra->id), [
            'status' => 'Verified',
            'assigned_cadder' => 'Disaster Relief Commander',
            'assigned_locality' => 'Kadapa'
        ]);

        $rudra->refresh();
        $this->assertEquals('verified', $rudra->status);
        $this->assertNotNull($rudra->rudrasena_id);

        Mail::assertSent(RudrasenaWelcomeMail::class, function ($mail) use ($rudra) {
            return $mail->hasTo('rudrasenamail@test.com') &&
                   $mail->memberData['rudrasena_id'] === $rudra->rudrasena_id &&
                   $mail->memberData['assigned_cadder'] === 'Disaster Relief Commander';
        });
    }

    public function test_volunteer_approval_triggers_welcome_email_with_pdf_id_card(): void
    {
        Mail::fake();

        $volunteer = Volunteer::create([
            'membership_id' => $this->member->membership_id,
            'phone' => $this->member->phone,
            'qualification' => 'Post Graduate',
            'voter_id_number' => 'VTRMAIL999',
            'email' => 'volunteermail@test.com',
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
            'cadre' => 'District Co-Ordinator',
            'locality' => 'Kadapa'
        ]);

        $volunteer->refresh();
        $this->assertEquals('approved', $volunteer->status);
        $this->assertNotNull($volunteer->volunteer_id);

        Mail::assertSent(VolunteerWelcomeMail::class, function ($mail) use ($volunteer) {
            return $mail->hasTo('volunteermail@test.com') &&
                   ($mail->volunteerData['volunteer_id'] === $volunteer->volunteer_id || $mail->volunteerData['formatted_volunteer_id'] === $volunteer->volunteer_id) &&
                   !empty($mail->volunteerData['plainPassword']);
        });
    }
}
