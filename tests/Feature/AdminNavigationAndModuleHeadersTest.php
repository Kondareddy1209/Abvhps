<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminNavigationAndModuleHeadersTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'ADMIN TEST OFFICER',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456789')
        ]);
    }

    /**
     * Test: Admin sidebar and mobile drawer contain unnumbered navigation items.
     */
    public function test_admin_sidebar_and_drawer_have_unnumbered_navigation_items(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);

        // Assert unnumbered labels are present
        $response->assertSee('OUR TEAM');
        $response->assertSee('DONATIONS LEDGER');
        $response->assertSee('BLOGS MANAGER');
        $response->assertSee('MEDIA GALLERY');
        $response->assertSee('OUR SUPPORT CORES');
        $response->assertSee('APPROVED MEMBERSHIP');
        $response->assertSee('PENDING MEMBERSHIP LIST');
        $response->assertSee('VOLUNTEER DESK');
        $response->assertSee('RUDRASENA');
        $response->assertSee('LOCAL GP GATEWAYS');
        $response->assertSee('EXAMS INFO BOARD');
        $response->assertSee('FUNDRAISING MATRICES');
        $response->assertSee('CONTACT FORMS AUDIT');
        $response->assertSee('TAX CERTIFICATES');
        $response->assertSee('SITE GLOBAL SETTINGS');
        $response->assertSee('BANNER MANAGEMENT');
        $response->assertSee('WHATSAPP');

        // Assert numbered prefixes are absent from navigation
        $response->assertDontSee('1. OUR TEAM');
        $response->assertDontSee('2. DONATIONS LEDGER');
        $response->assertDontSee('3. BLOGS MANAGER');
        $response->assertDontSee('4. MEDIA GALLERY');
        $response->assertDontSee('5. OUR SUPPORT CORES');
        $response->assertDontSee('6. APPROVED MEMBERSHIP');
        $response->assertDontSee('7. PENDING MEMBERSHIP LIST');
        $response->assertDontSee('8. VOLUNTEER DESK');
        $response->assertDontSee('9. RUDRASENA');
        $response->assertDontSee('10. LOCAL GP GATEWAYS');
        $response->assertDontSee('11. EXAMS INFO BOARD');
        $response->assertDontSee('12. FUNDRAISING MATRICES');
        $response->assertDontSee('13. CONTACT FORMS AUDIT');
        $response->assertDontSee('14. TAX CERTIFICATES');
        $response->assertDontSee('15. SITE GLOBAL SETTINGS');
        $response->assertDontSee('16. BANNER MANAGEMENT');
        $response->assertDontSee('17. WHATSAPP');
    }

    /**
     * Test: Module headers do not contain numeric prefixes.
     */
    public function test_admin_module_headers_have_no_number_prefixes(): void
    {
        // Exams Index
        $responseExams = $this->actingAs($this->admin)->get(route('admin.exams.index'));
        $responseExams->assertStatus(200);
        $responseExams->assertSee('Exams Management &amp; Multi-Exam Roster', false);
        $responseExams->assertDontSee('11. Exams Management');

        // Settings Index
        $responseSettings = $this->actingAs($this->admin)->get(route('admin.settings.index'));
        $responseSettings->assertStatus(200);
        $responseSettings->assertSee('Global Configuration & Site Settings');
        $responseSettings->assertDontSee('15. Global Configuration');

        // Local Gateways Index
        $responseGateways = $this->actingAs($this->admin)->get(route('admin.local_gateways.index'));
        $responseGateways->assertStatus(200);
        $responseGateways->assertSee('Local GP Gateways Roster');
        $responseGateways->assertDontSee('10. Local GP Gateways');

        // Fundraising Index
        $responseFundraising = $this->actingAs($this->admin)->get(route('admin.fundraising.index'));
        $responseFundraising->assertStatus(200);
        $responseFundraising->assertSee('Multi-Campaign Fundraising Matrices');
        $responseFundraising->assertDontSee('12. Multi-Campaign');

        // Contacts Index
        $responseContacts = $this->actingAs($this->admin)->get(route('admin.contacts.index'));
        $responseContacts->assertStatus(200);
        $responseContacts->assertSee('Public Inquiries & Contact Forms Audit');
        $responseContacts->assertDontSee('13. Public Inquiries');

        // Certificates Index
        $responseCerts = $this->actingAs($this->admin)->get(route('admin.certificates.index'));
        $responseCerts->assertStatus(200);
        $responseCerts->assertSee('Donation & Tax Compliance Certificates');
        $responseCerts->assertDontSee('14. Donation & Tax');
    }
}
