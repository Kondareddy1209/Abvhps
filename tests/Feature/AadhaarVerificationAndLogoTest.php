<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AadhaarVerificationAndLogoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Membership verification page uses official logo and no lotus emoji (🪷).
     */
    public function test_membership_verification_page_uses_official_logo_and_no_lotus_emoji(): void
    {
        $response = $this->get('/membership');
        $response->assertStatus(200);
        $response->assertDontSee('🪷');
        $response->assertSee('images/ABVHPS_LOGO.jpg');
    }

    /**
     * Test: Membership ID card view does not contain lotus emoji (🪷).
     */
    public function test_membership_card_view_uses_official_logo_and_no_lotus_emoji(): void
    {
        $member = Membership::create([
            'membership_id' => '123456789012',
            'phone' => '9876543210',
            'payment_status' => 'success',
            'full_name' => 'ANANYA SHARMA',
            'country' => 'India',
            'state' => 'Andhra Pradesh',
            'district' => 'Kadapa',
            'is_completed' => 1
        ]);

        $response = $this->withSession([
            'verified_membership_phone' => '9876543210',
            'last_email_log' => [
                'recipient_email' => 'ananya@example.com',
                'assigned_language' => 'en',
                'status' => 'queued'
            ]
        ])->get('/membership/view-card');

        $response->assertStatus(200);
        $response->assertDontSee('🪷');
        $response->assertSee('images/ABVHPS_LOGO.jpg');
    }

    /**
     * Test CASE 1: Verify applicant A -> Applicant A's actual verified data returned.
     */
    public function test_case_1_verify_applicant_a_returns_actual_verified_data(): void
    {
        $applicantA = Membership::create([
            'membership_id' => '111122223333',
            'phone' => '9111111111',
            'payment_status' => 'success',
            'aadhaar_number' => '444455556666',
            'full_name' => 'RAHUL SHARMA',
            'dob' => '1995-05-15',
            'gender' => 'Male',
            'father_or_husband_name' => 'Suresh Sharma',
            'permanent_address' => 'House 123, Gandhi Nagar, Kadapa',
            'is_completed' => 1
        ]);

        $response = $this->withSession(['verified_membership_phone' => '9111111111'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '444455556666'
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'full_name' => 'RAHUL SHARMA',
                'dob' => '1995-05-15',
                'gender' => 'Male',
                'permanent_address' => 'House 123, Gandhi Nagar, Kadapa',
                'father_or_husband_name' => 'Suresh Sharma'
            ]
        ]);
        $response->assertJsonMissing(['full_name' => 'SRINIVASA RAO']);
    }

    /**
     * Test CASE 2: Verify applicant B -> Applicant B's actual verified data returned.
     */
    public function test_case_2_verify_applicant_b_returns_actual_verified_data(): void
    {
        $applicantB = Membership::create([
            'membership_id' => '999988887777',
            'phone' => '9222222222',
            'payment_status' => 'success',
            'aadhaar_number' => '777788889999',
            'full_name' => 'PRIYA VENKATESH',
            'dob' => '1998-11-20',
            'gender' => 'Female',
            'father_or_husband_name' => 'Venkatesh Babu',
            'permanent_address' => 'Flat 401, Tirupati Heights, Tirupati',
            'is_completed' => 1
        ]);

        $response = $this->withSession(['verified_membership_phone' => '9222222222'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '777788889999'
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'full_name' => 'PRIYA VENKATESH',
                'dob' => '1998-11-20',
                'gender' => 'Female',
                'permanent_address' => 'Flat 401, Tirupati Heights, Tirupati',
                'father_or_husband_name' => 'Venkatesh Babu'
            ]
        ]);
        $response->assertJsonMissing(['full_name' => 'SRINIVASA RAO']);
    }

    /**
     * Test CASE 3: Failed Aadhaar verification -> No applicant's unrelated data appears.
     */
    public function test_case_3_failed_aadhaar_verification_returns_error(): void
    {
        // Invalid Aadhaar (e.g. less than 12 digits or starts with 0)
        $response = $this->withSession(['verified_membership_phone' => '9333333333'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '012345678901'
            ]);

        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'error'
        ]);
        $response->assertJsonMissing(['data' => ['full_name' => 'SRINIVASA RAO']]);
    }

    /**
     * Test CASE 4: Fresh application without prior verification -> No default fake name appears.
     */
    public function test_case_4_fresh_application_form_does_not_contain_hardcoded_srinivasa_rao(): void
    {
        $newApplicant = Membership::create([
            'membership_id' => '555566667777',
            'phone' => '9444444444',
            'payment_status' => 'success',
            'is_completed' => 0
        ]);

        $response = $this->withSession(['verified_membership_phone' => '9444444444'])
            ->get('/membership/application');

        $response->assertStatus(200);
        $response->assertDontSee('SRINIVASA RAO');
        $response->assertDontSee('🪷');
    }

    /**
     * Test CASE 5: Data isolation across multiple applicants.
     */
    public function test_case_5_applicant_a_data_does_not_leak_to_applicant_b(): void
    {
        $applicantA = Membership::create([
            'membership_id' => '111100001111',
            'phone' => '9555555555',
            'payment_status' => 'success',
            'full_name' => 'APPLICANT A PERSON',
            'is_completed' => 1
        ]);

        $applicantB = Membership::create([
            'membership_id' => '222200002222',
            'phone' => '9666666666',
            'payment_status' => 'success',
            'full_name' => 'APPLICANT B PERSON',
            'is_completed' => 1
        ]);

        // Session of applicant B should only get applicant B's data
        $responseB = $this->withSession(['verified_membership_phone' => '9666666666'])
            ->get('/membership/application');

        $responseB->assertStatus(200);
        $responseB->assertSee('APPLICANT B PERSON');
        $responseB->assertDontSee('APPLICANT A PERSON');
        $responseB->assertDontSee('SRINIVASA RAO');
    }
}
