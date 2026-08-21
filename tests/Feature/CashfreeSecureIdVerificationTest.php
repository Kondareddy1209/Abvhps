<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use App\Models\Membership;
use App\Services\CashfreeSecureIdService;

class CashfreeSecureIdVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('services.cashfree.verify_client_id', 'CF_TEST_VERIFY_CLIENT_ID_12345');
        Config::set('services.cashfree.verify_client_secret', 'cfsk_test_verify_secret_key_67890');
        Config::set('services.cashfree.verification_base_url', 'https://sandbox.cashfree.com/verification');
    }

    /**
     * Helper to mock successful Cashfree Secure ID response.
     */
    protected function mockCashfreeSuccess(array $overrideData = []): void
    {
        $defaultData = [
            'status'          => 'SUCCESS',
            'ref_id'          => 'CF_REF_987654321',
            'verification_id' => 'ABVHPS_VER_12345',
            'name'            => 'KONDA REDDY',
            'dob'             => '1990-05-20',
            'gender'          => 'M',
            'care_of'         => 'Narayana Reddy',
            'address'         => '12-34 Main Bazar, Porumamilla',
            'split_address'   => [
                'pincode'  => '516193',
                'district' => 'YSR Kadapa',
                'state'    => 'Andhra Pradesh',
            ],
        ];

        $responseData = array_merge($defaultData, $overrideData);

        Http::fake([
            'https://sandbox.cashfree.com/verification/*' => Http::response($responseData, 200),
        ]);
    }

    /**
     * Test 1: Valid Aadhaar + matching name -> SUCCESS
     */
    public function test_matching_aadhaar_and_name_verifies_and_persists_cashfree_identity(): void
    {
        $this->mockCashfreeSuccess([
            'name' => 'KONDA REDDY',
        ]);

        $member = Membership::create([
            'membership_id'  => '123456789012',
            'phone'          => '9876543210',
            'payment_status' => 'success',
            'is_completed'   => false,
        ]);

        $response = $this->withSession(['verified_membership_phone' => '9876543210'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '234567890123',
                'full_name'      => 'Konda Reddy',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status'              => 'success',
            'is_name_matched'     => true,
            'is_aadhaar_verified' => true,
            'verified_name'       => 'KONDA REDDY',
            'data' => [
                'full_name'              => 'KONDA REDDY',
                'dob'                    => '1990-05-20',
                'gender'                 => 'Male',
                'father_or_husband_name' => 'Narayana Reddy',
                'pincode'                => '516193',
                'district'               => 'YSR Kadapa',
                'state'                  => 'Andhra Pradesh',
            ],
        ]);

        $member->refresh();
        $this->assertTrue($member->is_aadhaar_verified);
        $this->assertEquals('234567890123', $member->aadhaar_number);
        $this->assertEquals('KONDA REDDY', $member->full_name);
        $this->assertEquals('1990-05-20', $member->dob);
        $this->assertEquals('Male', $member->gender);
        $this->assertEquals('Narayana Reddy', $member->father_or_husband_name);
        $this->assertEquals('516193', $member->pincode);
        $this->assertNotNull($member->aadhaar_verified_at);
    }

    /**
     * Test 2: Valid Aadhaar + mismatching name -> FAIL (is_name_matched = false)
     */
    public function test_mismatching_name_fails_verification_and_does_not_persist(): void
    {
        $this->mockCashfreeSuccess([
            'name' => 'KONDA REDDY',
        ]);

        $member = Membership::create([
            'membership_id'  => '123456789012',
            'phone'          => '9876543210',
            'payment_status' => 'success',
            'full_name'      => null,
            'is_completed'   => false,
        ]);

        $response = $this->withSession(['verified_membership_phone' => '9876543210'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '234567890123',
                'full_name'      => 'Ravi Kumar', // Deliberately different name
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status'              => 'error',
            'is_name_matched'     => false,
            'is_aadhaar_verified' => false,
            'message'             => 'Aadhaar number verified, but the name does not match Aadhaar records.',
        ]);

        $member->refresh();
        $this->assertFalse($member->is_aadhaar_verified);
        $this->assertNull($member->full_name);
        $this->assertNull($member->aadhaar_verified_at);
    }

    /**
     * Test 3: Invalid Aadhaar format (starts with 0 or 1, or not 12 digits) -> 422
     */
    public function test_invalid_aadhaar_format_rejected(): void
    {
        $member = Membership::create([
            'membership_id'  => '123456789012',
            'phone'          => '9876543210',
            'payment_status' => 'success',
            'is_completed'   => false,
        ]);

        // Starts with 0
        $response = $this->withSession(['verified_membership_phone' => '9876543210'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '012345678901',
                'full_name'      => 'Konda Reddy',
            ]);
        $response->assertStatus(422);

        // Starts with 1
        $response2 = $this->withSession(['verified_membership_phone' => '9876543210'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '112345678901',
                'full_name'      => 'Konda Reddy',
            ]);
        $response2->assertStatus(422);

        // Less than 12 digits
        $response3 = $this->withSession(['verified_membership_phone' => '9876543210'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '2345678901',
                'full_name'      => 'Konda Reddy',
            ]);
        $response3->assertStatus(422);
    }

    /**
     * Test 4: Missing session -> 401 Unauthorized
     */
    public function test_missing_session_returns_401(): void
    {
        $response = $this->postJson('/membership/verify-aadhaar', [
            'aadhaar_number' => '234567890123',
            'full_name'      => 'Konda Reddy',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'status'              => 'error',
            'is_name_matched'     => false,
            'is_aadhaar_verified' => false,
        ]);
    }

    /**
     * Test 5: Cashfree API gateway error -> Fails safely
     */
    public function test_cashfree_api_gateway_error_fails_safely(): void
    {
        Http::fake([
            'https://sandbox.cashfree.com/verification/*' => Http::response([
                'status'  => 'FAILED',
                'message' => 'Invalid Aadhaar number according to UIDAI gateway.',
            ], 400),
        ]);

        $member = Membership::create([
            'membership_id'  => '123456789012',
            'phone'          => '9876543210',
            'payment_status' => 'success',
            'is_completed'   => false,
        ]);

        $response = $this->withSession(['verified_membership_phone' => '9876543210'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '234567890123',
                'full_name'      => 'Konda Reddy',
            ]);

        $response->assertStatus(422);
        $response->assertJson([
            'status'              => 'error',
            'is_name_matched'     => false,
            'is_aadhaar_verified' => false,
        ]);

        $member->refresh();
        $this->assertFalse($member->is_aadhaar_verified);
    }

    /**
     * Test 6: Cashfree unconfigured -> Fails safely without fake simulation
     */
    public function test_unconfigured_credentials_fails_safely(): void
    {
        Config::set('services.cashfree.verify_client_id', '');
        Config::set('services.cashfree.verify_client_secret', '');

        $member = Membership::create([
            'membership_id'  => '123456789012',
            'phone'          => '9876543210',
            'payment_status' => 'success',
            'is_completed'   => false,
        ]);

        $response = $this->withSession(['verified_membership_phone' => '9876543210'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '234567890123',
                'full_name'      => 'Konda Reddy',
            ]);

        $response->assertStatus(422);
        $response->assertJson([
            'status'              => 'error',
            'is_name_matched'     => false,
            'is_aadhaar_verified' => false,
        ]);

        $member->refresh();
        $this->assertFalse($member->is_aadhaar_verified);
    }

    /**
     * Test 7: Case-insensitive, punctuation, and multi-space name matching
     */
    public function test_name_normalization_and_matching_rules(): void
    {
        // Exact case variations
        $this->assertTrue(CashfreeSecureIdService::compareNames('konda reddy', 'KONDA REDDY'));
        $this->assertTrue(CashfreeSecureIdService::compareNames('Konda Reddy', 'KONDA REDDY'));

        // Whitespace collapse
        $this->assertTrue(CashfreeSecureIdService::compareNames('KONDA   REDDY', 'KONDA REDDY'));
        $this->assertTrue(CashfreeSecureIdService::compareNames('  KONDA REDDY  ', 'KONDA REDDY'));

        // Punctuation normalization
        $this->assertTrue(CashfreeSecureIdService::compareNames('Konda-Reddy', 'KONDA REDDY'));
        $this->assertTrue(CashfreeSecureIdService::compareNames('Konda.Reddy', 'KONDA REDDY'));

        // Token order variations
        $this->assertTrue(CashfreeSecureIdService::compareNames('Reddy Konda', 'Konda Reddy'));

        // Disparate names must fail
        $this->assertFalse(CashfreeSecureIdService::compareNames('Konda Reddy', 'Ravi Kumar'));
        $this->assertFalse(CashfreeSecureIdService::compareNames('Srinivasa Rao', 'Venkat Reddy'));
    }

    /**
     * Test 8: Authoritative verified name is saved (not user entered casing/spelling)
     */
    public function test_authoritative_cashfree_name_is_saved(): void
    {
        $this->mockCashfreeSuccess([
            'name' => 'KONDA VENKATA REDDY',
        ]);

        $member = Membership::create([
            'membership_id'  => '123456789012',
            'phone'          => '9876543210',
            'payment_status' => 'success',
            'is_completed'   => false,
        ]);

        $response = $this->withSession(['verified_membership_phone' => '9876543210'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '234567890123',
                'full_name'      => 'konda venkata reddy', // Lowercase user entry
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status'        => 'success',
            'verified_name' => 'KONDA VENKATA REDDY',
        ]);

        $member->refresh();
        $this->assertEquals('KONDA VENKATA REDDY', $member->full_name);
    }

    /**
     * Test 9: One member cannot verify or update another member's record
     */
    public function test_data_isolation_between_sessions(): void
    {
        $this->mockCashfreeSuccess([
            'name' => 'MEMBER ONE',
        ]);

        $member1 = Membership::create([
            'membership_id'  => '111111111111',
            'phone'          => '9111111111',
            'payment_status' => 'success',
            'is_completed'   => false,
        ]);

        $member2 = Membership::create([
            'membership_id'  => '222222222222',
            'phone'          => '9222222222',
            'payment_status' => 'success',
            'is_completed'   => false,
        ]);

        $this->withSession(['verified_membership_phone' => '9111111111'])
            ->postJson('/membership/verify-aadhaar', [
                'aadhaar_number' => '234567890123',
                'full_name'      => 'MEMBER ONE',
            ]);

        $member1->refresh();
        $member2->refresh();

        $this->assertTrue($member1->is_aadhaar_verified);
        $this->assertEquals('MEMBER ONE', $member1->full_name);

        $this->assertFalse($member2->is_aadhaar_verified);
        $this->assertNull($member2->full_name);
    }
}
