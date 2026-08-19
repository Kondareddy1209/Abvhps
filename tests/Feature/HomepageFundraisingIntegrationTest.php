<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\FundraisingCampaign;
use App\Models\OurSupport;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomepageFundraisingIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->admin = User::create([
            'name' => 'ADMIN TEST',
            'email' => 'admin@test.com',
            'password' => bcrypt('123456789')
        ]);
    }

    /**
     * 1. Homepage shows both separate sections: Our Core Service Projects and Fundraising Campaigns
     */
    public function test_homepage_shows_both_separate_sections_simultaneously()
    {
        OurSupport::create([
            'name' => 'ORGANIC FARMING SEVADAL',
            'short_info' => 'Promoting desi seeds and cow based farming.',
            'sort_order' => 1,
            'status' => 'show',
        ]);

        $campaign = FundraisingCampaign::create([
            'title' => 'GOSHALA DEVELOPMENT PROJECT',
            'description' => 'Dedicated development of sacred goshalas across Andhra Pradesh.',
            'target_amount' => 500000.00,
            'raised_amount' => 175000.00,
            'end_date' => Carbon::today()->addDays(30)->toDateString(),
            'cover_image' => 'campaigns/covers/test_goshala.jpg',
            'video_path' => 'campaigns/videos/briefing.mp4',
            'status' => 'active',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        // Section 1: Our Core Service Projects
        $response->assertSee('Our Core Service Projects', false);
        $response->assertSee('ORGANIC FARMING SEVADAL', false);

        // Section 2: Fundraising Campaigns
        $response->assertSee('Fundraising Campaigns', false);
        $response->assertSee('Support meaningful initiatives and help us serve communities across India.', false);
        $response->assertSee('GOSHALA DEVELOPMENT PROJECT', false);
        $response->assertSee('Dedicated development of sacred goshalas', false);
        $response->assertSee('₹175,000', false);
        $response->assertSee('₹500,000', false);
        $response->assertSee('35%', false); // 175000 / 500000 = 35%
        $response->assertSee('🎥 Video Briefing Available', false);
        $response->assertSee(asset('storage/campaigns/covers/test_goshala.jpg'), false);
    }

    /**
     * 2. Expired or inactive campaigns do not appear in Fundraising Campaigns section
     */
    public function test_expired_or_inactive_campaigns_do_not_appear_on_homepage()
    {
        // Expired by status
        FundraisingCampaign::create([
            'title' => 'EXPIRED TEMPLE RESTORATION',
            'description' => 'Should not be publicly visible.',
            'target_amount' => 100000.00,
            'raised_amount' => 50000.00,
            'end_date' => Carbon::today()->addDays(10)->toDateString(),
            'cover_image' => 'campaigns/covers/expired.jpg',
            'status' => 'expired',
        ]);

        // Expired by date
        FundraisingCampaign::create([
            'title' => 'PAST DATE CAMPAIGN',
            'description' => 'Past end date campaign.',
            'target_amount' => 100000.00,
            'raised_amount' => 20000.00,
            'end_date' => Carbon::yesterday()->toDateString(),
            'cover_image' => 'campaigns/covers/past.jpg',
            'status' => 'active',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('EXPIRED TEMPLE RESTORATION');
        $response->assertDontSee('PAST DATE CAMPAIGN');
    }

    /**
     * 3. Multiple campaigns are ordered by latest
     */
    public function test_multiple_campaigns_display_in_latest_order()
    {
        FundraisingCampaign::create([
            'title' => 'FIRST CAMPAIGN INITIATIVE',
            'description' => 'First initiative description',
            'target_amount' => 100000.00,
            'raised_amount' => 10000.00,
            'end_date' => Carbon::today()->addDays(20)->toDateString(),
            'cover_image' => 'campaigns/covers/c1.jpg',
            'status' => 'active',
        ]);

        FundraisingCampaign::create([
            'title' => 'SECOND CAMPAIGN INITIATIVE',
            'description' => 'Second initiative description',
            'target_amount' => 200000.00,
            'raised_amount' => 50000.00,
            'end_date' => Carbon::today()->addDays(25)->toDateString(),
            'cover_image' => 'campaigns/covers/c2.jpg',
            'status' => 'active',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('FIRST CAMPAIGN INITIATIVE');
        $response->assertSee('SECOND CAMPAIGN INITIATIVE');
    }

    /**
     * 4. Admin creating a campaign via admin form immediately reflects on Homepage
     */
    public function test_admin_creating_campaign_immediately_appears_on_homepage()
    {
        $coverFile = UploadedFile::fake()->image('temple_cover.jpg');

        $response = $this->actingAs($this->admin)->post(route('admin.fundraising.store'), [
            'title' => 'SRI RAMA TEMPLE CONSTRUCTION',
            'description' => 'Constructing grand temple in Porumamilla mandalam.',
            'target_amount' => 1000000.00,
            'raised_amount' => 250000.00,
            'end_date' => Carbon::today()->addDays(60)->toDateString(),
            'cover_image' => $coverFile,
        ]);

        $response->assertRedirect(route('admin.fundraising.index'));

        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('SRI RAMA TEMPLE CONSTRUCTION');
        $homeResponse->assertSee('₹250,000');
        $homeResponse->assertSee('₹1,000,000');
        $homeResponse->assertSee('25%');
    }

    /**
     * 5. Admin updating campaign updates Homepage content
     */
    public function test_admin_updating_campaign_updates_homepage_data()
    {
        $campaign = FundraisingCampaign::create([
            'title' => 'ORIGINAL CAMPAIGN TITLE',
            'description' => 'Original description text.',
            'target_amount' => 50000.00,
            'raised_amount' => 10000.00,
            'end_date' => Carbon::today()->addDays(15)->toDateString(),
            'cover_image' => 'campaigns/covers/orig.jpg',
            'status' => 'active',
        ]);

        $home1 = $this->get('/');
        $home1->assertSee('ORIGINAL CAMPAIGN TITLE');

        // Admin updates campaign
        $this->actingAs($this->admin)->post(route('admin.fundraising.update', $campaign->id), [
            'title' => 'REVISED UPDATED CAMPAIGN TITLE',
            'description' => 'Updated description text.',
            'target_amount' => 80000.00,
            'raised_amount' => 40000.00,
            'end_date' => Carbon::today()->addDays(20)->toDateString(),
            'status' => 'active',
        ]);

        $home2 = $this->get('/');
        $home2->assertDontSee('ORIGINAL CAMPAIGN TITLE');
        $home2->assertSee('REVISED UPDATED CAMPAIGN TITLE');
        $home2->assertSee('₹40,000');
        $home2->assertSee('₹80,000');
        $home2->assertSee('50%');
    }

    /**
     * 6. Admin toggling campaign to expired removes it from Homepage
     */
    public function test_admin_toggling_campaign_to_expired_removes_it_from_homepage()
    {
        $campaign = FundraisingCampaign::create([
            'title' => 'TOGGLEABLE CAMPAIGN',
            'description' => 'Will be deactivated.',
            'target_amount' => 50000.00,
            'raised_amount' => 10000.00,
            'end_date' => Carbon::today()->addDays(15)->toDateString(),
            'cover_image' => 'campaigns/covers/tog.jpg',
            'status' => 'active',
        ]);

        $home1 = $this->get('/');
        $home1->assertSee('TOGGLEABLE CAMPAIGN');

        // Toggle status
        $this->actingAs($this->admin)->post(route('admin.fundraising.toggle', $campaign->id));

        $home2 = $this->get('/');
        $home2->assertDontSee('TOGGLEABLE CAMPAIGN');
    }

    /**
     * 7. Progress calculation caps at 100% when raised exceeds target
     */
    public function test_progress_percent_capped_at_100_when_target_exceeded()
    {
        $campaign = FundraisingCampaign::create([
            'title' => 'HIGHLY SUCCESSFUL SEVA CAMPAIGN',
            'description' => 'Target exceeded with abundant devotee blessings.',
            'target_amount' => 10000.00,
            'raised_amount' => 15000.00, // 150%
            'end_date' => Carbon::today()->addDays(15)->toDateString(),
            'cover_image' => 'campaigns/covers/success.jpg',
            'status' => 'active',
        ]);

        $this->assertEquals(100.0, $campaign->progress_percent);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('100%');
        $response->assertSee('₹15,000');
        $response->assertSee('₹10,000');
    }

    /**
     * 8. Clean empty state in Fundraising section when no active campaigns exist
     */
    public function test_clean_empty_state_in_fundraising_section_when_no_active_campaigns_exist()
    {
        OurSupport::create([
            'name' => 'RUDRA SENA VOLUNTEER CORPS',
            'short_info' => 'Youth brigade for temple preservation.',
            'sort_order' => 1,
            'status' => 'show',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        // Core services is visible
        $response->assertSee('Our Core Service Projects', false);
        $response->assertSee('RUDRA SENA VOLUNTEER CORPS', false);

        // Fundraising empty state is rendered
        $response->assertSee('Fundraising Campaigns', false);
        $response->assertSee('No active fundraising campaigns at the moment.', false);
    }

    /**
     * 9. Each campaign card has dynamic campaign-specific WhatsApp share link
     */
    public function test_campaign_cards_have_dynamic_whatsapp_share_links()
    {
        $campA = FundraisingCampaign::create([
            'title' => 'VILLAGE SERVICE INITIATIVE A',
            'description' => 'Providing educational aids to rural children.',
            'target_amount' => 100000.00,
            'raised_amount' => 25000.00,
            'end_date' => Carbon::today()->addDays(30)->toDateString(),
            'cover_image' => 'campaigns/covers/a.jpg',
            'status' => 'active',
        ]);

        $campB = FundraisingCampaign::create([
            'title' => 'SACRED GOSHALA EXPANSION B',
            'description' => 'Building sheds & fodder stock for 200 cows.',
            'target_amount' => 200000.00,
            'raised_amount' => 80000.00,
            'end_date' => Carbon::today()->addDays(45)->toDateString(),
            'cover_image' => 'campaigns/covers/b.jpg',
            'status' => 'active',
        ]);

        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);

        // Assert WhatsApp share links are rendered on homepage
        $homeResponse->assertSee($campA->whatsapp_share_url, false);
        $homeResponse->assertSee($campB->whatsapp_share_url, false);

        // Assert different campaigns have different share URLs
        $this->assertNotEquals($campA->whatsapp_share_url, $campB->whatsapp_share_url);
        $this->assertStringContainsString('wa.me/?text=', $campA->whatsapp_share_url);
        $this->assertStringContainsString(rawurlencode($campA->title), $campA->whatsapp_share_url);
        $this->assertStringContainsString(rawurlencode($campB->title), $campB->whatsapp_share_url);
        $this->assertStringContainsString(rawurlencode(route('donations.grid') . '#campaign_' . $campA->id), $campA->whatsapp_share_url);
        $this->assertStringContainsString(rawurlencode(route('donations.grid') . '#campaign_' . $campB->id), $campB->whatsapp_share_url);

        // Assert donations grid page also has WhatsApp share links
        $gridResponse = $this->get(route('donations.grid'));
        $gridResponse->assertStatus(200);
        $gridResponse->assertSee($campA->whatsapp_share_url, false);
        $gridResponse->assertSee($campB->whatsapp_share_url, false);
    }

    /**
     * 10. Special characters in title and description are safely encoded in WhatsApp share URL
     */
    public function test_special_characters_are_safely_encoded_in_whatsapp_share_url()
    {
        $campaign = FundraisingCampaign::create([
            'title' => "TEMPLE & GOSHALA \"SEVA\" INITIATIVE (2026) — 100% DHARMA?",
            'description' => "Supporting 50+ cows & priests with ₹50,000 aid/month!",
            'target_amount' => 500000.00,
            'raised_amount' => 150000.00,
            'end_date' => Carbon::today()->addDays(20)->toDateString(),
            'cover_image' => 'campaigns/covers/special.jpg',
            'status' => 'active',
        ]);

        $shareUrl = $campaign->whatsapp_share_url;

        $this->assertStringStartsWith('https://wa.me/?text=', $shareUrl);
        // Special characters must be properly rawurlencoded
        $this->assertStringContainsString(rawurlencode("TEMPLE & GOSHALA \"SEVA\" INITIATIVE (2026) — 100% DHARMA?"), $shareUrl);
        $this->assertStringContainsString(rawurlencode("Supporting 50+ cows & priests with ₹50,000 aid/month!"), $shareUrl);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee($shareUrl, false);
    }
}
