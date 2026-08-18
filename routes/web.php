<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RudrasenaController;
use App\Http\Controllers\KalaBrundamController;
use App\Http\Controllers\GramaSevaDalController;
use App\Http\Controllers\OrganicFarmerController;
use App\Http\Controllers\FundraisingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\OurTeamController;
use App\Http\Controllers\DonationController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);

use App\Http\Controllers\MembershipController;

// 1. Membership OTP Verification Process Routes
Route::get('/membership', [MembershipController::class, 'showOtpForm']);
Route::post('/membership/send-otp', [MembershipController::class, 'sendOtp']);
Route::post('/membership/verify-otp', [MembershipController::class, 'verifyOtp']);

// 2. Membership Gateway Payment Process Routes
Route::get('/membership/payment', [MembershipController::class, 'showPaymentPage']);
Route::post('/membership/process-payment', [MembershipController::class, 'processPayment']);

// 3. Render Membership Final Data Registration Form Desk
Route::get('/membership/application', [MembershipController::class, 'showApplicationForm']);

// 4. Secure Form Submission Desk Mapped to url('/submit-membership')
Route::post('/submit-membership', [MembershipController::class, 'submitApplication']);

// 5. Display and Print Generated Membership PVC ID Card View Screen
Route::get('/membership/view-card', [MembershipController::class, 'viewCard']);


use App\Http\Controllers\VolunteerController;

// Volunteer Identity Check Verification Routing Rules
Route::get('/volunteer', [VolunteerController::class, 'showCheckForm']);
Route::post('/volunteer/verify-membership', [VolunteerController::class, 'verifyMembership']);
Route::get('/volunteer/application', [VolunteerController::class, 'showApplicationForm']);

// Dynamic view verification test endpoint mapping
Route::get('/volunteer/application-placeholder-test', function() {
    return 'Volunteer Form Framework - Pending Configuration Stage';
});

// Volunteer Form Data Submission & Success Routing
Route::post('/volunteer/submit-application', [VolunteerController::class, 'submitApplication']);
Route::get('/volunteer/success-notice', [VolunteerController::class, 'showSuccessNotice']);

// Central Admin Panel Volunteer Desk Routes Configuration Setup (Redirect legacy desk to unified index)
Route::redirect('/admin/volunteer-desk', '/admin/volunteers');
Route::post('/admin/volunteer/approve', [VolunteerController::class, 'updateVolunteerStatus']);
Route::get('/admin/volunteer/view-card/{volunteerIdCode}', [VolunteerController::class, 'viewVolunteerCard'])->name('admin.volunteer.view_card');

// Volunteer and Presidents Core Login Engine Routes Setup
Route::get('/volunteer/login', [VolunteerController::class, 'showLoginForm']);
Route::post('/volunteer/process-login', [VolunteerController::class, 'processLogin']);
Route::get('/volunteer/logout', [VolunteerController::class, 'logoutVolunteer']);

// Village President Dashboard Search and Compression Routing Engine Map Links Setup
Route::get('/volunteer/dashboard/village', [VolunteerController::class, 'showVillageDashboard']);
Route::post('/volunteer/dashboard/village/search-member', [VolunteerController::class, 'searchMember']);
Route::post('/volunteer/dashboard/village/deliver-seva', [VolunteerController::class, 'deliverSeva']);

// Mandal President Dashboard Core Mapping Link Routing Rule
Route::get('/volunteer/dashboard/mandal', [VolunteerController::class, 'showMandalDashboard']);

// Assembly Segment President Dashboard Core Mapping Link Routing Rule
Route::get('/volunteer/dashboard/assembly', [VolunteerController::class, 'showAssemblyDashboard']);

// District President Dashboard Core Mapping Link Routing Rule
Route::get('/volunteer/dashboard/district', [VolunteerController::class, 'showDistrictDashboard']);

// Global Master Dashboard Pipeline Mapping Link Routing Rule
Route::get('/volunteer/dashboard/global', [VolunteerController::class, 'showGlobalDashboard']);

// Village President Group Event Album Upload Route Link Setup
Route::post('/volunteer/dashboard/village/upload-group-event', [VolunteerController::class, 'uploadGroupEvent']);


use App\Http\Controllers\ExamController;

// Exam Application System Form Route
Route::get('/exam-application', [ExamController::class, 'showApplicationForm'])->name('exam.form');

// Security & Verification Channels
Route::post('/exam-application/send-otp', [ExamController::class, 'sendEmailOtp'])->name('exam.send_otp');
Route::post('/exam-application/verify-otp', [ExamController::class, 'verifyEmailOtp'])->name('exam.verify_otp');
Route::post('/exam-application/check-membership', [ExamController::class, 'checkMembershipId'])->name('exam.check_membership');

// Anti-Fraud Payment Delivery Engine & Success Handlers
Route::post('/exam-application/process-payment', [ExamController::class, 'processApplicationPayment'])->name('exam.process_payment');
Route::post('/exam-application/submit', [ExamController::class, 'submitFinalApplication'])->name('exam.submit');

// Post-Submission Digital Desks
Route::get('/exam-application/success/{id}', [ExamController::class, 'showSuccessNotice'])->name('exam.success');
Route::get('/exam-application/download-syllabus/{id}', [ExamController::class, 'downloadSyllabusPdf'])->name('exam.download_syllabus');

// Central Exam Results Portal & Winners Showcase Desks
Route::get('/exam-results', [ExamController::class, 'showResultsPortal'])->name('exam.results_portal');
Route::post('/exam-results/search', [ExamController::class, 'searchStudentResult'])->name('exam.results_search');

// Rudrasena Dal Sacred Registration Wing Core Pipelines
Route::get('/rudrasena-apply', [RudrasenaController::class, 'showApplicationDesk'])->name('rudrasena.form');
Route::post('/rudrasena-apply/verify-member', [RudrasenaController::class, 'verifyCoreMembership'])->name('rudrasena.verify_member');
Route::post('/rudrasena-apply/submit', [RudrasenaController::class, 'submitApplicationPacket'])->name('rudrasena.submit');

// Kala Brundam Cultural Network Core Pipelines
Route::get('/kala-brundam-apply', [KalaBrundamController::class, 'showApplicationDesk'])->name('kalabrundam.form');
Route::post('/kala-brundam-apply/fetch-member', [KalaBrundamController::class, 'fetchMemberForTeam'])->name('kalabrundam.fetch_member');
Route::post('/kala-brundam-apply/submit', [KalaBrundamController::class, 'submitTeamPacket'])->name('kalabrundam.submit');

// Grama Seva Dal Youth Network Core Pipelines
Route::get('/grama-seva-dal-apply', [GramaSevaDalController::class, 'showApplicationDesk'])->name('gramasevadal.form');
Route::post('/grama-seva-dal-apply/fetch-member', [GramaSevaDalController::class, 'fetchMemberForDal'])->name('gramasevadal.fetch_member');
Route::post('/grama-seva-dal-apply/submit', [GramaSevaDalController::class, 'submitDalPacket'])->name('gramasevadal.submit');

// Organic Farmers Agriculture Network Core Pipelines
Route::get('/organic-farmers-apply', [OrganicFarmerController::class, 'showApplicationDesk'])->name('organicfarmers.form');
Route::post('/organic-farmers-apply/fetch-member', [OrganicFarmerController::class, 'fetchMemberForFarming'])->name('organicfarmers.fetch_member');
Route::post('/organic-farmers-apply/submit', [OrganicFarmerController::class, 'submitFarmerPacket'])->name('organicfarmers.submit');

// Central Multimedia Fundraising Campaign Pipelines
Route::get('/donations', [FundraisingController::class, 'showDonationsGrid'])->name('donations.grid');
Route::get('/admin/fundraising/create', [FundraisingController::class, 'showCreateForm'])->name('admin.fundraising.create');
Route::post('/admin/fundraising/store', [FundraisingController::class, 'storeCampaignPacket'])->name('admin.fundraising.store');

// Central Master Administrative Panel Core Pipelines
Route::get('/admin/dashboard', [AdminDashboardController::class, 'showMasterDashboard'])->name('admin.dashboard');
Route::post('/admin/dashboard/verify-wing', [AdminDashboardController::class, 'processWingApproval'])->name('admin.dashboard.verify_wing');


/// ======================================================================
// 👑 CENTRAL AUTHENTIC ADMINISTRATIVE CONTROL ROUTE PIPELINES
// ======================================================================

// 1. PUBLIC UNPROTECTED GATEWAYS (Accessible without any active login session)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginView'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'executeAuthentication'])->name('admin.login.submit');

// PUBLIC ROSTER LOOKUP ENGINE: Accessible to all public devotees and guests globally
Route::get('/admin/our-team', [OurTeamController::class, 'index'])->name('admin.our_team.index');
Route::get('/verify-member/{membership_id}', [\App\Http\Controllers\OurTeamController::class, 'publicLiveVerification'])->name('member.public_verify');


// 2. PROTECTED ADMINISTRATIVE BOARD GATEWAYS (Strictly requires valid logged-in commander session)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Core Administrative Dashboard Entry Point Node
    Route::get('/dashboard', [AdminDashboardController::class, 'showMasterDashboard'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'executeSessionTermination'])->name('logout');

    // ------------------------------------------------------------------
    // MODULE 1: OUR TEAM - ADMINISTRATIVE MANIPULATION CORE (SECURE WRITE ACTIONS)
    // ------------------------------------------------------------------
    Route::get('/our-team/create', [OurTeamController::class, 'create'])->name('our_team.create');
    Route::post('/our-team/store', [OurTeamController::class, 'store'])->name('our_team.store');
    Route::get('/our-team/{id}/edit', [OurTeamController::class, 'edit'])->name('our_team.edit');
    Route::post('/our-team/{id}/update', [OurTeamController::class, 'update'])->name('our_team.update');
    Route::post('/our-team/{id}/delete', [OurTeamController::class, 'destroy'])->name('our_team.destroy');

 
    // Public Anti-Fraud QR Verification Gateway lookup link node
    Route::get('/verify-member/{membership_id}', [OurTeamController::class, 'publicLiveVerification'])->name('member.public_verify');

});
    
// ======================================================================
// 🌐 PUBLIC ABSOLUTE ANTI-FRAUD QR VERIFICATION GATEWAY (OUTSIDE GROUP)
// ======================================================================
Route::get('/verify-member/{membership_id}', [\App\Http\Controllers\OurTeamController::class, 'publicLiveVerification'])->name('member.public_verify');

   // ======================================================================
// 📜 CENTRAL DONATION LEDGER INDEPENDENT PIPELINES (OUTSIDE GROUP)
// ======================================================================
Route::get('/admin/donations', [\App\Http\Controllers\DonationController::class, 'index'])->name('admin.donation.index');
Route::get('/admin/donations/{id}/receipt', [\App\Http\Controllers\DonationController::class, 'downloadReceipt'])->name('admin.donation.receipt');

// ======================================================================
// 📝 CENTRAL BLOGS MANAGEMENT INDEPENDENT PIPELINES (OUTSIDE GROUP)
// ======================================================================
Route::get('/admin/blogs', [\App\Http\Controllers\BlogController::class, 'index'])->name('admin.blog.index');
Route::get('/admin/blogs/create', [\App\Http\Controllers\BlogController::class, 'create'])->name('admin.blog.create');
Route::post('/admin/blogs/store', [\App\Http\Controllers\BlogController::class, 'store'])->name('admin.blog.store');
Route::get('/admin/blogs/{id}/edit', [\App\Http\Controllers\BlogController::class, 'edit'])->name('admin.blog.edit');
Route::post('/admin/blogs/{id}/update', [\App\Http\Controllers\BlogController::class, 'update'])->name('admin.blog.update');
Route::post('/admin/blogs/{id}/delete', [\App\Http\Controllers\BlogController::class, 'destroy'])->name('admin.blog.destroy');

// ======================================================================
// 🖼️ CENTRAL GALLERY HUB INDEPENDENT PIPELINES (OUTSIDE GROUP)
// ======================================================================
Route::get('/admin/gallery', [\App\Http\Controllers\GalleryController::class, 'index'])->name('admin.gallery.index');
Route::post('/admin/gallery/store', [\App\Http\Controllers\GalleryController::class, 'store'])->name('admin.gallery.store');
Route::post('/admin/gallery/{id}/delete', [\App\Http\Controllers\GalleryController::class, 'destroy'])->name('admin.gallery.destroy');

// ======================================================================
// 🤝 OUR SUPPORT CORE MISSIONS INDEPENDENT PIPELINES (OUTSIDE GROUP)
// ======================================================================
Route::get('/admin/our-supports', [\App\Http\Controllers\OurSupportController::class, 'index'])->name('admin.our_support.index');
Route::get('/admin/our-supports/create', [\App\Http\Controllers\OurSupportController::class, 'create'])->name('admin.our_support.create');
Route::post('/admin/our-supports/store', [\App\Http\Controllers\OurSupportController::class, 'store'])->name('admin.our_support.store');
Route::get('/admin/our-supports/{id}/edit', [\App\Http\Controllers\OurSupportController::class, 'edit'])->name('admin.our_supports.edit');
Route::post('/admin/our-supports/{id}/update', [\App\Http\Controllers\OurSupportController::class, 'update'])->name('admin.our_supports.update');
Route::post('/admin/our-supports/{id}/delete', [\App\Http\Controllers\OurSupportController::class, 'destroy'])->name('admin.our_supports.destroy');

Route::get('/admin/membership-ledger', [App\Http\Controllers\MembershipController::class, 'adminIndex'])->name('admin.membership.ledger')->middleware('auth');

    // 🔱 ABVHPS CENTRAL ADMINISTRATIVE PANEL 15 CORE ROUTES MATRIX
    // ----------------------------------------------------------------------
         // 1. Our Team Management Module Routes
    Route::get('/admin/team', [App\Http\Controllers\OurTeamController::class, 'index'])->name('admin.team.index');
    Route::get('/admin/team/create', [App\Http\Controllers\OurTeamController::class, 'create'])->name('admin.team.create');
    Route::get('/our-team-members', [App\Http\Controllers\HomeController::class, 'team'])->name('public.team');

        // 2. Donation Ledger Module Routes (Connected to Official Donation Controller)
    Route::get('/admin/donations', [App\Http\Controllers\DonationController::class, 'index'])->name('admin.donations.index');
    Route::get('/admin/donations/receipt/{id}', [App\Http\Controllers\DonationController::class, 'downloadReceipt'])->name('admin.donations.receipt');

        // 3. Blogs Management Module Routes (Fixed Route Names)
    Route::get('/admin/blogs', [App\Http\Controllers\BlogController::class, 'index'])->name('admin.blogs.index');
    Route::get('/admin/blogs/create', [App\Http\Controllers\BlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/admin/blogs/store', [App\Http\Controllers\BlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/admin/blogs/edit/{id}', [App\Http\Controllers\BlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::post('/admin/blogs/update/{id}', [App\Http\Controllers\BlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/admin/blogs/delete/{id}', [App\Http\Controllers\BlogController::class, 'destroy'])->name('admin.blogs.delete');
    
    // 4. Gallery Media Module Routes (Connected to Authentic Gallery Controller)
    Route::get('/admin/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('admin.gallery.index');
    Route::post('/admin/gallery/store', [App\Http\Controllers\GalleryController::class, 'store'])->name('admin.gallery.store');
    Route::delete('/admin/gallery/delete/{id}', [App\Http\Controllers\GalleryController::class, 'destroy'])->name('admin.gallery.delete');
    Route::get('/gallery', [App\Http\Controllers\HomeController::class, 'gallery'])->name('public.gallery');

        // 5. Our Support Cores Module Routes (Connected to Authentic OurSupport Controller)
    Route::get('/admin/support', [App\Http\Controllers\OurSupportController::class, 'index'])->name('admin.support.index');
    Route::get('/admin/support/create', [App\Http\Controllers\OurSupportController::class, 'create'])->name('admin.support.create');
    Route::post('/admin/support/store', [App\Http\Controllers\OurSupportController::class, 'store'])->name('admin.our_support.store');
    Route::get('/admin/support/edit/{id}', [App\Http\Controllers\OurSupportController::class, 'edit'])->name('admin.support.edit');
    Route::post('/admin/support/update/{id}', [App\Http\Controllers\OurSupportController::class, 'update'])->name('admin.support.update');
    Route::delete('/admin/support/delete/{id}', [App\Http\Controllers\OurSupportController::class, 'destroy'])->name('admin.support.delete');

        // 6. Approved Membership Individual Actions Routes
    Route::get('/admin/membership/view/{id}', [App\Http\Controllers\MembershipController::class, 'viewProfile'])->name('admin.membership.view')->middleware('auth');
    Route::get('/admin/membership/idcard/{id}', [App\Http\Controllers\MembershipController::class, 'downloadIdCard'])->name('admin.membership.idcard')->middleware('auth');
    Route::get('/admin/membership/edit/{id}', [App\Http\Controllers\MembershipController::class, 'editProfile'])->name('admin.membership.edit')->middleware('auth');
    Route::post('/admin/membership/update/{id}', [App\Http\Controllers\MembershipController::class, 'updateProfile'])->name('admin.membership.update')->middleware('auth');
    Route::delete('/admin/membership/delete/{id}', [App\Http\Controllers\MembershipController::class, 'deleteProfile'])->name('admin.membership.delete')->middleware('auth');

    // 7. Pending Membership List
    Route::get('/admin/membership-pending', [App\Http\Controllers\MembershipController::class, 'pendingIndex'])->name('admin.membership.pending')->middleware('auth');

    // 8. Volunteer Desk Management
    Route::get('/admin/volunteers', [VolunteerController::class, 'adminIndex'])->name('admin.volunteers.index')->middleware('auth');
    Route::get('/admin/volunteers/view/{id}', [VolunteerController::class, 'viewProfile'])->name('admin.volunteers.view')->middleware('auth');
    Route::get('/admin/volunteers/edit/{id}', [VolunteerController::class, 'editFull'])->name('admin.volunteers.edit')->middleware('auth');
    Route::post('/admin/volunteers/update/{id}', [VolunteerController::class, 'updateFull'])->name('admin.volunteers.update')->middleware('auth');
    Route::post('/admin/volunteers/update-full/{id}', [VolunteerController::class, 'updateFull'])->name('admin.volunteers.updateFull')->middleware('auth');
    Route::get('/admin/volunteers/cadre/{id}', [VolunteerController::class, 'cadreEditForm'])->name('admin.volunteers.cadreEdit')->middleware('auth');
    Route::post('/admin/volunteers/cadre/{id}', [VolunteerController::class, 'cadreUpdate'])->name('admin.volunteers.cadreUpdate')->middleware('auth');
    Route::delete('/admin/volunteers/delete/{id}', [VolunteerController::class, 'deleteVolunteer'])->name('admin.volunteers.delete')->middleware('auth');

    // 9. Rudrasena
    Route::get('/admin/rudrasena', [App\Http\Controllers\RudrasenaController::class, 'adminIndex'])->name('admin.rudrasena.index')->middleware('auth');
    Route::get('/admin/rudrasena/view/{id}', [App\Http\Controllers\RudrasenaController::class, 'viewMember'])->name('admin.rudrasena.view')->middleware('auth');
    Route::get('/admin/rudrasena/view-card/{id}', [App\Http\Controllers\RudrasenaController::class, 'viewCard'])->name('admin.rudrasena.view_card')->middleware('auth');
    Route::get('/admin/rudrasena/edit/{id}', [App\Http\Controllers\RudrasenaController::class, 'editMemberForm'])->name('admin.rudrasena.edit')->middleware('auth');
    Route::post('/admin/rudrasena/update/{id}', [App\Http\Controllers\RudrasenaController::class, 'updateMember'])->name('admin.rudrasena.update')->middleware('auth');
    Route::post('/admin/rudrasena/approve/{id}', [App\Http\Controllers\RudrasenaController::class, 'approveMember'])->name('admin.rudrasena.approve')->middleware('auth');
    Route::delete('/admin/rudrasena/delete/{id}', [App\Http\Controllers\RudrasenaController::class, 'deleteMember'])->name('admin.rudrasena.delete')->middleware('auth');

    // 10. Kala Brundam, Grama Seva Dal, Organic Farmers Local GP Gateway
    Route::get('/admin/local-gateways', [App\Http\Controllers\LocalGatewayController::class, 'index'])->name('admin.local_gateways.index')->middleware('auth');
    Route::post('/admin/local-gateways/approve/{wing}/{id}', [App\Http\Controllers\LocalGatewayController::class, 'approveGroup'])->name('admin.local_gateways.approve')->middleware('auth');
    Route::get('/admin/local-gateways/view/{wing}/{id}', [App\Http\Controllers\LocalGatewayController::class, 'viewGroup'])->name('admin.local_gateways.view')->middleware('auth');
    Route::delete('/admin/local-gateways/delete/{wing}/{id}', [App\Http\Controllers\LocalGatewayController::class, 'destroyGroup'])->name('admin.local_gateways.delete')->middleware('auth');

    // 11. Exams Information Notice Board Loop
    Route::get('/admin/exams', [App\Http\Controllers\ExamController::class, 'adminIndex'])->name('admin.exams.index')->middleware('auth');
    Route::get('/admin/exams/create', [App\Http\Controllers\ExamController::class, 'adminCreate'])->name('admin.exams.create')->middleware('auth');
    Route::post('/admin/exams/store', [App\Http\Controllers\ExamController::class, 'adminStore'])->name('admin.exams.store')->middleware('auth');
    Route::get('/admin/exams/edit/{id}', [App\Http\Controllers\ExamController::class, 'adminEdit'])->name('admin.exams.edit')->middleware('auth');
    Route::post('/admin/exams/update/{id}', [App\Http\Controllers\ExamController::class, 'adminUpdate'])->name('admin.exams.update')->middleware('auth');
    Route::delete('/admin/exams/delete/{id}', [App\Http\Controllers\ExamController::class, 'adminDelete'])->name('admin.exams.delete')->middleware('auth');
    Route::get('/exams-notice-board', [App\Http\Controllers\ExamController::class, 'publicNoticeBoard'])->name('public.exams_board');

    // 12. Fundraise Multi-Campaign Media Block
    Route::get('/admin/fundraising', [App\Http\Controllers\FundraisingController::class, 'adminIndex'])->name('admin.fundraising.index')->middleware('auth');
    Route::get('/admin/fundraising/create', [App\Http\Controllers\FundraisingController::class, 'showCreateForm'])->name('admin.fundraising.create')->middleware('auth');
    Route::post('/admin/fundraising/store', [App\Http\Controllers\FundraisingController::class, 'storeCampaignPacket'])->name('admin.fundraising.store')->middleware('auth');
    Route::get('/admin/fundraising/edit/{id}', [App\Http\Controllers\FundraisingController::class, 'showEditForm'])->name('admin.fundraising.edit')->middleware('auth');
    Route::post('/admin/fundraising/update/{id}', [App\Http\Controllers\FundraisingController::class, 'updateCampaign'])->name('admin.fundraising.update')->middleware('auth');
    Route::post('/admin/fundraising/toggle/{id}', [App\Http\Controllers\FundraisingController::class, 'toggleStatus'])->name('admin.fundraising.toggle')->middleware('auth');
    Route::delete('/admin/fundraising/delete/{id}', [App\Http\Controllers\FundraisingController::class, 'destroyCampaign'])->name('admin.fundraising.delete')->middleware('auth');

    // 13. Contact Forms Audit Tracker
    Route::get('/admin/contacts', [App\Http\Controllers\ContactController::class, 'adminIndex'])->name('admin.contacts.index')->middleware('auth');
    Route::get('/admin/contacts/view/{id}', [App\Http\Controllers\ContactController::class, 'adminView'])->name('admin.contacts.view')->middleware('auth');
    Route::delete('/admin/contacts/delete/{id}', [App\Http\Controllers\ContactController::class, 'adminDelete'])->name('admin.contacts.delete')->middleware('auth');
    Route::get('/contact', [App\Http\Controllers\ContactController::class, 'showContactPage'])->name('public.contact');
    Route::post('/contact/submit', [App\Http\Controllers\ContactController::class, 'submitContact'])->name('public.contact.submit');

    // 14. ABVHPS Donation & Tax Certificates Core Gateway
    Route::get('/admin/certificates', [App\Http\Controllers\CertificateController::class, 'adminIndex'])->name('admin.certificates.index')->middleware('auth');
    Route::post('/admin/certificates/store', [App\Http\Controllers\CertificateController::class, 'adminStore'])->name('admin.certificates.store')->middleware('auth');
    Route::post('/admin/certificates/toggle/{id}', [App\Http\Controllers\CertificateController::class, 'adminToggle'])->name('admin.certificates.toggle')->middleware('auth');
    Route::delete('/admin/certificates/delete/{id}', [App\Http\Controllers\CertificateController::class, 'adminDelete'])->name('admin.certificates.delete')->middleware('auth');
    Route::get('/compliance-certificates', [App\Http\Controllers\CertificateController::class, 'publicIndex'])->name('public.certificates');

    // 15. Site Settings Central Desk Engine
    Route::get('/admin/settings', [App\Http\Controllers\SettingController::class, 'adminIndex'])->name('admin.settings.index')->middleware('auth');
    Route::post('/admin/settings/update', [App\Http\Controllers\SettingController::class, 'adminUpdate'])->name('admin.settings.update')->middleware('auth');

    // 🔱 ABVHPS PUBLIC WEBSITE MAIN NAVIGATION ROUTES
// ----------------------------------------------------------------------
// Public Web Home Route
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('public.home');

// Public Web Gallery Route Link
Route::get('/gallery', [App\Http\Controllers\HomeController::class, 'gallery'])->name('public.gallery');

// Public Web Blogs List Route Link
Route::get('/blogs', [App\Http\Controllers\HomeController::class, 'blogs'])->name('public.blogs');

// Public Web Our Team Leaders Route Link
Route::get('/team', [App\Http\Controllers\HomeController::class, 'team'])->name('public.team');

// Public Web Single Project Full Details Route Link
Route::get('/project/{id}', [App\Http\Controllers\HomeController::class, 'showProject'])->name('public.project.show');


