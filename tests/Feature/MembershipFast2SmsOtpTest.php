<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Membership;
use App\Services\Fast2SmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MembershipFast2SmsOtpTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Sending OTP creates secure DB record and returns production-safe success message without OTP
     */
    public function test_send_otp_stores_securely_and_does_not_expose_otp_in_ui_or_session(): void
    {
        $phone = '9876543210';

        $response = $this->post('/membership/send-otp', [
            'phone' => $phone
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('otp_sent_to', $phone);
        $response->assertSessionHas('success', 'OTP sent successfully. Please check your registered mobile number.');

        // Verify the success message does NOT contain test OTP code
        $successMsg = session('success');
        $this->assertStringNotContainsString('For testing', $successMsg);
        $this->assertStringNotContainsString('use code', $successMsg);
        $this->assertStringNotContainsString('code:', $successMsg);

        // Verify record in database
        $record = DB::table('phone_verifications')->where('phone', $phone)->first();
        $this->assertNotNull($record);
        $this->assertEquals(6, strlen((string) $record->otp));
        $this->assertFalse((bool) $record->is_verified);
        $this->assertTrue(Carbon::parse($record->expired_at)->isFuture());
    }

    /**
     * Test 2: Valid OTP verification succeeds and redirects appropriately
     */
    public function test_valid_otp_verifies_successfully_and_sets_session(): void
    {
        $phone = '9123456789';
        $otp = '456789';

        DB::table('phone_verifications')->insert([
            'phone' => $phone,
            'otp' => $otp,
            'is_verified' => false,
            'expired_at' => Carbon::now()->addMinutes(5),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $response = $this->post('/membership/verify-otp', [
            'phone' => $phone,
            'otp' => $otp
        ]);

        $response->assertRedirect('/membership/payment');
        $response->assertSessionHas('verified_membership_phone', $phone);

        // DB record marked as verified and expired immediately to prevent replay
        $record = DB::table('phone_verifications')->where('phone', $phone)->first();
        $this->assertTrue((bool) $record->is_verified);
        $this->assertTrue(Carbon::parse($record->expired_at)->isPast());
    }

    /**
     * Test 3: Invalid OTP is rejected with clear error message
     */
    public function test_invalid_otp_fails_verification(): void
    {
        $phone = '9123456780';
        $correctOtp = '123456';
        $wrongOtp = '999999';

        DB::table('phone_verifications')->insert([
            'phone' => $phone,
            'otp' => $correctOtp,
            'is_verified' => false,
            'expired_at' => Carbon::now()->addMinutes(5),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $response = $this->post('/membership/verify-otp', [
            'phone' => $phone,
            'otp' => $wrongOtp
        ]);

        $response->assertRedirect('/membership');
        $response->assertSessionHas('error', 'Invalid or Expired OTP code. Please try again.');
        $response->assertSessionMissing('verified_membership_phone');
    }

    /**
     * Test 4: Expired OTP is rejected
     */
    public function test_expired_otp_fails_verification(): void
    {
        $phone = '9123456781';
        $otp = '555555';

        DB::table('phone_verifications')->insert([
            'phone' => $phone,
            'otp' => $otp,
            'is_verified' => false,
            'expired_at' => Carbon::now()->subMinute(), // Expired 1 min ago
            'created_at' => now()->subMinutes(6),
            'updated_at' => now()->subMinutes(6)
        ]);

        $response = $this->post('/membership/verify-otp', [
            'phone' => $phone,
            'otp' => $otp
        ]);

        $response->assertRedirect('/membership');
        $response->assertSessionHas('error', 'Invalid or Expired OTP code. Please try again.');
    }

    /**
     * Test 5: Reusing an already verified OTP fails (single-use enforcement)
     */
    public function test_reusing_already_verified_otp_fails(): void
    {
        $phone = '9123456782';
        $otp = '777888';

        DB::table('phone_verifications')->insert([
            'phone' => $phone,
            'otp' => $otp,
            'is_verified' => false,
            'expired_at' => Carbon::now()->addMinutes(5),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // First verification succeeds
        $firstResponse = $this->post('/membership/verify-otp', [
            'phone' => $phone,
            'otp' => $otp
        ]);
        $firstResponse->assertRedirect('/membership/payment');

        // Second verification with the same OTP must fail
        $secondResponse = $this->post('/membership/verify-otp', [
            'phone' => $phone,
            'otp' => $otp
        ]);
        $secondResponse->assertRedirect('/membership');
        $secondResponse->assertSessionHas('error', 'Invalid or Expired OTP code. Please try again.');
    }

    /**
     * Test 6: Fast2SmsService executes HTTP request when API key is configured
     */
    public function test_fast2sms_service_handles_gateway_dispatch(): void
    {
        config([
            'services.fast2sms.api_key' => 'test_api_key',
            'services.fast2sms.sender_id' => 'ABVHPS',
            'services.fast2sms.template_id' => '1234567890123456',
        ]);

        Http::fake([
            'https://www.fast2sms.com/dev/bulkV2' => Http::response([
                'return' => true,
                'request_id' => 'req_test_123',
                'message' => ['SMS sent successfully.']
            ], 200)
        ]);

        $result = Fast2SmsService::sendOtp('9876543210', '123456');

        $this->assertTrue($result['success']);
        $this->assertEquals('sent', $result['status']);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://www.fast2sms.com/dev/bulkV2' &&
                   $request->hasHeader('authorization', 'test_api_key') &&
                   $request['route'] === 'dlt' &&
                   $request['sender_id'] === 'ABVHPS' &&
                   $request['message'] === '1234567890123456' &&
                   $request['variables_values'] === '123456' &&
                   $request['numbers'] === '9876543210';
        });
    }

    /**
     * Test 7: Fast2SmsService gracefully skips when API key is empty
     */
    public function test_fast2sms_service_gracefully_handles_empty_api_key(): void
    {
        config(['services.fast2sms.api_key' => '']);

        $result = Fast2SmsService::sendOtp('9876543210', '123456');

        $this->assertTrue($result['success']);
        $this->assertEquals('skipped', $result['status']);
    }
}
