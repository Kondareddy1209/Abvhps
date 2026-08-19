<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Banner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PageSpecificBannerManagementTest extends TestCase
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
     * 1. Admin can access Admin Banner Management Index
     */
    public function test_admin_can_access_banner_management_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.banner.index'));
        $response->assertStatus(200);
        $response->assertSee('Section 16: Page-Specific Website Banners Desk');
        $response->assertSee('Filter By Page');
        $response->assertSee('+ Add Banner');
    }

    /**
     * 2. Non-authenticated guests cannot access Admin Banner routes
     */
    public function test_guest_is_redirected_from_admin_banner_routes(): void
    {
        $response = $this->get(route('admin.banner.index'));
        $response->assertRedirect(route('login'));

        $createResponse = $this->get(route('admin.banner.create'));
        $createResponse->assertRedirect(route('login'));
    }

    /**
     * 3. Add Banner page renders page selection dropdown
     */
    public function test_add_banner_page_contains_page_dropdown_options(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.banner.create'));
        $response->assertStatus(200);
        $response->assertSee('Select Website Page');
        $response->assertSee('Gallery (slug: gallery)');
        $response->assertSee('Home (slug: home)');
        $response->assertSee('About (slug: about)');
        $response->assertSee('Desktop Banner *');
        $response->assertSee('Mobile Banner');
    }

    /**
     * 4. Admin can create a new page-specific banner
     */
    public function test_admin_can_create_banner_with_page_assignment(): void
    {
        $desktopFile = UploadedFile::fake()->image('gallery-desktop.jpg', 1920, 600);
        $mobileFile  = UploadedFile::fake()->image('gallery-mobile.jpg', 768, 600);

        $response = $this->actingAs($this->admin)->post(route('admin.banner.store'), [
            'page_key'       => 'gallery',
            'desktop_banner' => $desktopFile,
            'mobile_banner'  => $mobileFile,
            'status'         => 'show',
            'title'          => 'Gallery Sacred Showcase',
            'subtitle'       => 'Visual Glimpses of Service',
            'sort_order'     => 1,
        ]);

        $response->assertRedirect(route('admin.banner.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('banners', [
            'page_key'   => 'gallery',
            'page_name'  => 'Gallery',
            'title'      => 'Gallery Sacred Showcase',
            'status'     => 'show',
            'sort_order' => 1,
        ]);

        $banner = Banner::where('page_key', 'gallery')->first();
        $this->assertNotNull($banner);
        Storage::disk('public')->assertExists($banner->desktop_banner);
        Storage::disk('public')->assertExists($banner->mobile_banner);
    }

    /**
     * 5. Admin can edit page assignment and banner details
     */
    public function test_admin_can_edit_page_assignment_and_preserve_images(): void
    {
        $desktopPath = UploadedFile::fake()->image('original-desktop.jpg')->store('banners', 'public');
        $mobilePath  = UploadedFile::fake()->image('original-mobile.jpg')->store('banners', 'public');

        $banner = Banner::create([
            'page_key'       => 'about',
            'page_name'      => 'About',
            'title'          => 'Initial About Title',
            'desktop_banner' => $desktopPath,
            'mobile_banner'  => $mobilePath,
            'status'         => 'show',
            'sort_order'     => 0,
        ]);

        // Edit view loads successfully
        $editView = $this->actingAs($this->admin)->get(route('admin.banner.edit', $banner->id));
        $editView->assertStatus(200);
        $editView->assertSee('Initial About Title');

        // Update page from 'about' to 'gallery' without re-uploading images
        $updateResponse = $this->actingAs($this->admin)->post(route('admin.banner.update', $banner->id), [
            'page_key'   => 'gallery',
            'status'     => 'show',
            'title'      => 'Updated Gallery Title',
            'sort_order' => 5,
        ]);

        $updateResponse->assertRedirect(route('admin.banner.index'));

        $banner->refresh();
        $this->assertEquals('gallery', $banner->page_key);
        $this->assertEquals('Gallery', $banner->page_name);
        $this->assertEquals('Updated Gallery Title', $banner->title);
        $this->assertEquals($desktopPath, $banner->desktop_banner);
        $this->assertEquals($mobilePath, $banner->mobile_banner);
    }

    /**
     * 6. Admin can toggle banner visibility status
     */
    public function test_admin_can_toggle_banner_status(): void
    {
        $banner = Banner::create([
            'page_key'       => 'home',
            'page_name'      => 'Home',
            'desktop_banner' => 'banners/dummy.jpg',
            'status'         => 'show',
        ]);

        $this->assertTrue($banner->is_visible);

        $this->actingAs($this->admin)->post(route('admin.banner.toggle', $banner->id));

        $banner->refresh();
        $this->assertEquals('hide', $banner->status);
        $this->assertFalse($banner->is_visible);
    }

    /**
     * 7. Admin can delete a banner and its files
     */
    public function test_admin_can_delete_banner(): void
    {
        $desktopPath = UploadedFile::fake()->image('to-delete.jpg')->store('banners', 'public');
        $banner = Banner::create([
            'page_key'       => 'contact',
            'page_name'      => 'Contact',
            'desktop_banner' => $desktopPath,
            'status'         => 'show',
        ]);

        Storage::disk('public')->assertExists($desktopPath);

        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.banner.delete', $banner->id));
        $deleteResponse->assertRedirect(route('admin.banner.index'));

        $this->assertDatabaseMissing('banners', ['id' => $banner->id]);
        Storage::disk('public')->assertMissing($desktopPath);
    }

    /**
     * 8. Page filter and search query filters banners on index
     */
    public function test_page_filtering_and_search_work_correctly(): void
    {
        Banner::create(['page_key' => 'home', 'page_name' => 'Home', 'title' => 'Home Special', 'desktop_banner' => 'banners/h.jpg', 'status' => 'show']);
        Banner::create(['page_key' => 'gallery', 'page_name' => 'Gallery', 'title' => 'Gallery Art', 'desktop_banner' => 'banners/g.jpg', 'status' => 'show']);
        Banner::create(['page_key' => 'about', 'page_name' => 'About', 'title' => 'About Us', 'desktop_banner' => 'banners/a.jpg', 'status' => 'show']);

        // Filter by page=gallery
        $filterRes = $this->actingAs($this->admin)->get(route('admin.banner.index', ['page' => 'gallery']));
        $filterRes->assertStatus(200);
        $filterRes->assertSee('Gallery Art');
        $filterRes->assertDontSee('Home Special');

        // Search by token
        $searchRes = $this->actingAs($this->admin)->get(route('admin.banner.index', ['search' => 'Special']));
        $searchRes->assertStatus(200);
        $searchRes->assertSee('Home Special');
        $searchRes->assertDontSee('Gallery Art');
    }

    /**
     * 9. Active Gallery banner renders on /gallery and Home banner on /
     */
    public function test_public_pages_load_only_their_assigned_banners(): void
    {
        $galleryDesktop = UploadedFile::fake()->image('gallery-desk.jpg')->store('banners', 'public');
        $galleryMobile  = UploadedFile::fake()->image('gallery-mob.jpg')->store('banners', 'public');

        $homeDesktop = UploadedFile::fake()->image('home-desk.jpg')->store('banners', 'public');

        Banner::create([
            'page_key'       => 'gallery',
            'page_name'      => 'Gallery',
            'title'          => 'Exclusive Sacred Gallery',
            'desktop_banner' => $galleryDesktop,
            'mobile_banner'  => $galleryMobile,
            'status'         => 'show',
        ]);

        Banner::create([
            'page_key'       => 'home',
            'page_name'      => 'Home',
            'title'          => 'Welcome to ABVHPS Central Home',
            'desktop_banner' => $homeDesktop,
            'status'         => 'show',
        ]);

        // 1. Visit /gallery
        $galleryRes = $this->get('/gallery');
        $galleryRes->assertStatus(200);
        $galleryRes->assertSee('Exclusive Sacred Gallery');
        $galleryRes->assertSee($galleryDesktop);
        $galleryRes->assertSee($galleryMobile);
        // Ensure Home banner title does NOT leak into Gallery page
        $galleryRes->assertDontSee('Welcome to ABVHPS Central Home');

        // 2. Visit Home (/)
        $homeRes = $this->get('/');
        $homeRes->assertStatus(200);
        $homeRes->assertSee('Welcome to ABVHPS Central Home');
        $homeRes->assertSee($homeDesktop);
        // Ensure Gallery banner title does NOT leak into Home page
        $homeRes->assertDontSee('Exclusive Sacred Gallery');
    }

    /**
     * 10. Hidden banner is NOT displayed on public website
     */
    public function test_hidden_banner_is_not_displayed_publicly(): void
    {
        $galleryDesktop = UploadedFile::fake()->image('hidden-gallery.jpg')->store('banners', 'public');

        Banner::create([
            'page_key'       => 'gallery',
            'page_name'      => 'Gallery',
            'title'          => 'Hidden Secret Gallery Title',
            'desktop_banner' => $galleryDesktop,
            'status'         => 'hide', // Inactive
        ]);

        $response = $this->get('/gallery');
        $response->assertStatus(200);
        $response->assertDontSee('Hidden Secret Gallery Title');
        $response->assertDontSee($galleryDesktop);
    }

    /**
     * 11. Mobile fallback uses desktop banner when mobile banner is null
     */
    public function test_mobile_banner_falls_back_to_desktop_banner_when_null(): void
    {
        $desktopPath = 'banners/desk-only.jpg';

        $banner = Banner::create([
            'page_key'       => 'about',
            'page_name'      => 'About',
            'desktop_banner' => $desktopPath,
            'mobile_banner'  => null,
            'status'         => 'show',
        ]);

        $this->assertEquals(asset('storage/' . $desktopPath), $banner->desktop_url);
        $this->assertEquals(asset('storage/' . $desktopPath), $banner->mobile_url);
    }

    /**
     * 12. Validation rejects invalid file or missing required page
     */
    public function test_validation_rejects_missing_page_and_invalid_files(): void
    {
        $nonImage = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($this->admin)->post(route('admin.banner.store'), [
            'page_key'       => '',
            'desktop_banner' => $nonImage,
            'status'         => 'show',
        ]);

        $response->assertSessionHasErrors(['page_key', 'desktop_banner']);
    }
}
