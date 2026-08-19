<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;
use App\Models\ContactMessage;
use App\Models\AuditLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimezoneConfigurationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test global Laravel timezone configuration is set to Asia/Kolkata.
     */
    public function test_app_timezone_is_configured_to_asia_kolkata(): void
    {
        $this->assertEquals('Asia/Kolkata', config('app.timezone'));
        $this->assertEquals('Asia/Kolkata', date_default_timezone_get());
        $this->assertEquals('Asia/Kolkata', Carbon::now()->timezone->getName());
        $this->assertEquals('Asia/Kolkata', now()->timezone->getName());
    }

    /**
     * Test user-visible UTC timestamp conversion to IST.
     * Example: 2026-08-19 05:00:00 UTC -> 19 Aug 2026, 10:30 AM IST (+05:30)
     */
    public function test_utc_timestamp_converts_correctly_to_ist(): void
    {
        $utcCarbon = Carbon::createFromFormat('Y-m-d H:i:s', '2026-08-19 05:00:00', 'UTC');
        
        // Convert to application timezone (Asia/Kolkata)
        $istCarbon = $utcCarbon->copy()->setTimezone(config('app.timezone'));

        $this->assertEquals('Asia/Kolkata', $istCarbon->timezone->getName());
        $this->assertEquals('19 Aug 2026, 10:30 AM', $istCarbon->format('d M Y, h:i A'));
        $this->assertEquals('19 Aug 2026, 10:30 AM IST', $istCarbon->format('d M Y, h:i A') . ' IST');
        $this->assertEquals('+05:30', $istCarbon->format('P'));
    }

    /**
     * Test Eloquent model timestamps are created and resolved in Asia/Kolkata timezone.
     */
    public function test_eloquent_timestamps_use_ist_timezone(): void
    {
        $contact = ContactMessage::create([
            'name'       => 'Sita Ramaiah',
            'email'      => 'sita@example.com',
            'phone'      => '9876543210',
            'subject'    => 'Timezone Verification',
            'message'    => 'Verifying global IST timestamp generation in Eloquent.',
            'status'     => 'unread',
            'ip_address' => '127.0.0.1',
        ]);

        $this->assertNotNull($contact->created_at);
        $this->assertEquals('Asia/Kolkata', $contact->created_at->timezone->getName());

        $formatted = $contact->created_at->format('d M Y, h:i A');
        $this->assertNotEmpty($formatted);
    }

    /**
     * Test AuditLogger creates timestamps in Asia/Kolkata timezone.
     */
    public function test_audit_logs_use_ist_timezone(): void
    {
        \App\Services\AuditLogger::log(
            'TIMEZONE_AUDIT_CHECK',
            'Admin',
            'admin@abvhps.org',
            ['test' => true]
        );

        $log = AuditLog::where('action', 'TIMEZONE_AUDIT_CHECK')->first();
        $this->assertNotNull($log);
        $this->assertNotNull($log->created_at);
        $this->assertEquals('Asia/Kolkata', $log->created_at->timezone->getName());
    }
}
