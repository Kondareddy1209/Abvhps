{{-- ABVHPS CENTRAL ADMINISTRATIVE SIDEBAR & MOBILE DRAWER (SINGLE SOURCE OF TRUTH) --}}
@php
    $currentRoute = Route::currentRouteName();
    $isDashboard = request()->routeIs('admin.dashboard');
    $isTeam = request()->routeIs('admin.team.*') || request()->routeIs('admin.our_team.*');
    $isDonations = request()->routeIs('admin.donations.*') || request()->routeIs('admin.donation.*');
    $isBlogs = request()->routeIs('admin.blogs.*') || request()->routeIs('admin.blog.*');
    $isGallery = request()->routeIs('admin.gallery.*');
    $isSupport = request()->routeIs('admin.support.*') || request()->routeIs('admin.our_support.*') || request()->routeIs('admin.our_supports.*');
    $isApprovedMembers = request()->routeIs('admin.membership.ledger') || (request()->routeIs('admin.membership.*') && !request()->routeIs('admin.membership.pending'));
    $isPendingMembers = request()->routeIs('admin.membership.pending');
    $isVolunteers = request()->routeIs('admin.volunteers.*');
    $isRudrasena = request()->routeIs('admin.rudrasena.*');
    $isLocalGateways = request()->routeIs('admin.local_gateways.*');
    $isExams = request()->routeIs('admin.exams.*');
    $isFundraising = request()->routeIs('admin.fundraising.*');
    $isContacts = request()->routeIs('admin.contacts.*');
    $isCertificates = request()->routeIs('admin.certificates.*');
    $isSettings = request()->routeIs('admin.settings.*');
    $isBanner = request()->routeIs('admin.banner.*') || request()->routeIs('admin.banners.*');
@endphp

{{-- ========================================================= --}}
{{-- 1. DESKTOP SIDEBAR (>= 768px: Persistent Left Sidebar)    --}}
{{-- ========================================================= --}}
<aside class="hidden md:flex md:w-64 bg-brandDarkGray text-white flex-col justify-between shadow-xl shrink-0 select-none border-r-4 border-brandOrange">
    <div class="p-4 border-b border-gray-800 flex items-center gap-3 bg-gray-900">
        <div class="w-10 h-10 rounded-full overflow-hidden border border-brandOrange shadow-md flex items-center justify-center bg-white p-0.5 shrink-0">
            <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS">
        </div>
        <div>
            <h2 class="text-xs font-black tracking-widest text-brandOrange uppercase">ABVHPS CENTRAL BOARD</h2>
            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block">Unified Management Console</span>
        </div>
    </div>

    <nav class="flex-1 p-3 space-y-1 overflow-y-auto text-[10px] font-black tracking-wider uppercase text-gray-300">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 {{ $isDashboard ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📊</span> DASHBOARD HOME
        </a>

        <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">WINGS SUBSYSTEMS</div>
        <a href="{{ route('admin.team.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isTeam ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>👥</span> OUR TEAM
        </a>
        <a href="{{ route('admin.donations.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isDonations ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>💰</span> DONATIONS LEDGER
        </a>
        <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isBlogs ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📰</span> BLOGS MANAGER
        </a>
        <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isGallery ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🖼️</span> MEDIA GALLERY
        </a>
        <a href="{{ route('admin.support.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isSupport ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🌱</span> OUR SUPPORT CORES
        </a>

        <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">MEMBERSHIP & CADRES</div>
        <a href="{{ route('admin.membership.ledger') }}" class="flex items-center gap-2 px-3 py-2 {{ $isApprovedMembers ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>💳</span> APPROVED MEMBERSHIP
        </a>
        <a href="{{ route('admin.membership.pending') }}" class="flex items-center gap-2 px-3 py-2 {{ $isPendingMembers ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>⏳</span> PENDING MEMBERSHIP LIST
        </a>
        <a href="{{ route('admin.volunteers.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isVolunteers ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🤝</span> VOLUNTEER DESK
        </a>
        <a href="{{ route('admin.rudrasena.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isRudrasena ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🔱</span> RUDRASENA
        </a>
        <a href="{{ route('admin.local_gateways.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isLocalGateways ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🏡</span> LOCAL GP GATEWAYS
        </a>

        <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">SERVICES & CORES</div>
        <a href="{{ route('admin.exams.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isExams ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📝</span> EXAMS INFO BOARD
        </a>
        <a href="{{ route('admin.fundraising.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isFundraising ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📢</span> FUNDRAISING MATRICES
        </a>
        <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isContacts ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📩</span> CONTACT FORMS AUDIT
        </a>
        <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isCertificates ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📜</span> TAX CERTIFICATES
        </a>
        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isSettings ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>⚙️</span> SITE GLOBAL SETTINGS
        </a>
        <a href="{{ route('admin.banner.index') }}" class="flex items-center gap-2 px-3 py-2 {{ $isBanner ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🚩</span> BANNER MANAGEMENT
        </a>
        <a href="{{ \App\Models\SiteSetting::getWhatsAppUrl() }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-800/60 text-emerald-400 hover:text-white rounded-lg transition font-bold">
            <svg class="w-3.5 h-3.5 fill-current shrink-0 text-emerald-400" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.972.531 1.776.813 2.796.813 3.183 0 5.768-2.587 5.769-5.766.001-3.182-2.585-5.77-5.769-5.77zm3.377 8.239c-.144.405-.837.774-1.17.824-.312.045-.694.076-2.155-.529-1.803-.746-2.956-2.58-3.045-2.7-.091-.12-1.222-1.625-1.222-3.099 0-1.474.773-2.197 1.047-2.496.275-.299.598-.374.797-.374.199 0 .399.002.573.01.184.01.432-.07.674.512.25.599.852 2.079.927 2.23.075.15.125.326.025.525-.099.199-.15.324-.298.499-.15.175-.316.39-.45.524-.15.15-.306.314-.132.613.175.299.776 1.28 1.666 2.072 1.144 1.02 2.11 1.335 2.41 1.485.3.15.474.125.65-.075.174-.2.748-.873.948-1.173.199-.3.399-.25.674-.15.275.1 1.748.824 2.048.974.3.15.499.225.574.35.074.125.074.724-.07 1.129zM12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.436 5.178L2 22l4.958-1.3c1.47.839 3.167 1.3 4.978 1.3 5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.167c-1.637 0-3.17-.492-4.455-1.336l-.319-.208-2.946.772.786-2.871-.227-.361A8.125 8.125 0 013.833 12c0-4.503 3.664-8.167 8.167-8.167 4.503 0 8.167 3.664 8.167 8.167 0 4.503-3.664 8.167-8.167 8.167z"/></svg>
            <span>WHATSAPP ({{ substr(\App\Models\SiteSetting::getNormalizedWhatsAppNumber(), -10) }})</span>
        </a>

        @if(auth()->guard('web')->check())
        <div class="pt-2 border-t border-gray-800/60">
            <form action="{{ route('admin.logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-rose-400 hover:bg-rose-950/40 hover:text-rose-300 rounded-lg transition font-black tracking-wider cursor-pointer">
                    <span>🚪</span> SIGN OUT
                </button>
            </form>
        </div>
        @endif
    </nav>

    <div class="p-3 bg-gray-900 border-t border-gray-800 text-center text-[8px] font-bold text-gray-500 tracking-wider">
        ABVHPS SECURITY CORE V2.0
    </div>
</aside>

{{-- ========================================================= --}}
{{-- 2. MOBILE DRAWER (< 768px: Slide-Over Offcanvas Drawer)   --}}
{{-- ========================================================= --}}
<div id="admin-drawer-backdrop" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-[70] hidden opacity-0 transition-opacity duration-300 md:hidden" onclick="toggleAdminDrawer(false)" aria-hidden="true"></div>

<div id="admin-mobile-drawer" class="fixed inset-y-0 left-0 w-72 max-w-[85vw] bg-brandDarkGray text-white z-[80] shadow-2xl flex flex-col justify-between transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden select-none" role="dialog" aria-modal="true" aria-label="Admin Navigation Menu">
    <div class="p-4 border-b border-gray-800 flex items-center justify-between bg-gray-900">
        <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-full overflow-hidden border border-brandOrange shadow-md flex items-center justify-center bg-white p-0.5 shrink-0">
                <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS">
            </div>
            <div>
                <h2 class="text-xs font-black tracking-widest text-brandOrange uppercase">ABVHPS CENTRAL</h2>
                <span class="text-[8px] text-gray-400 font-bold uppercase tracking-wider block">Admin Control Desk</span>
            </div>
        </div>
        <button type="button" id="admin-drawer-close-btn" onclick="toggleAdminDrawer(false)" class="p-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition min-w-[44px] min-h-[44px] flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-brandOrange cursor-pointer" aria-label="Close navigation">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <nav class="flex-1 p-3 space-y-1 overflow-y-auto text-[11px] font-black tracking-wider uppercase text-gray-300 min-h-0">
        <a href="{{ route('admin.dashboard') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isDashboard ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📊</span> DASHBOARD HOME
        </a>

        <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">WINGS SUBSYSTEMS</div>
        <a href="{{ route('admin.team.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isTeam ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>👥</span> OUR TEAM
        </a>
        <a href="{{ route('admin.donations.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isDonations ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>💰</span> DONATIONS LEDGER
        </a>
        <a href="{{ route('admin.blogs.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isBlogs ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📰</span> BLOGS MANAGER
        </a>
        <a href="{{ route('admin.gallery.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isGallery ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🖼️</span> MEDIA GALLERY
        </a>
        <a href="{{ route('admin.support.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isSupport ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🌱</span> OUR SUPPORT CORES
        </a>

        <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">MEMBERSHIP & CADRES</div>
        <a href="{{ route('admin.membership.ledger') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isApprovedMembers ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>💳</span> APPROVED MEMBERSHIP
        </a>
        <a href="{{ route('admin.membership.pending') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isPendingMembers ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>⏳</span> PENDING MEMBERSHIP LIST
        </a>
        <a href="{{ route('admin.volunteers.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isVolunteers ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🤝</span> VOLUNTEER DESK
        </a>
        <a href="{{ route('admin.rudrasena.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isRudrasena ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🔱</span> RUDRASENA
        </a>
        <a href="{{ route('admin.local_gateways.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isLocalGateways ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🏡</span> LOCAL GP GATEWAYS
        </a>

        <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">SERVICES & CORES</div>
        <a href="{{ route('admin.exams.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isExams ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📝</span> EXAMS INFO BOARD
        </a>
        <a href="{{ route('admin.fundraising.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isFundraising ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📢</span> FUNDRAISING MATRICES
        </a>
        <a href="{{ route('admin.contacts.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isContacts ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📩</span> CONTACT FORMS AUDIT
        </a>
        <a href="{{ route('admin.certificates.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isCertificates ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>📜</span> TAX CERTIFICATES
        </a>
        <a href="{{ route('admin.settings.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isSettings ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>⚙️</span> SITE GLOBAL SETTINGS
        </a>
        <a href="{{ route('admin.banner.index') }}" onclick="toggleAdminDrawer(false)" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] {{ $isBanner ? 'bg-brandOrange text-white rounded-lg shadow-sm' : 'hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40' }}">
            <span>🚩</span> BANNER MANAGEMENT
        </a>
        <a href="{{ \App\Models\SiteSetting::getWhatsAppUrl() }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] hover:bg-emerald-800/60 text-emerald-400 hover:text-white rounded-lg transition font-bold">
            <svg class="w-4 h-4 fill-current shrink-0 text-emerald-400" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.972.531 1.776.813 2.796.813 3.183 0 5.768-2.587 5.769-5.766.001-3.182-2.585-5.77-5.769-5.77zm3.377 8.239c-.144.405-.837.774-1.17.824-.312.045-.694.076-2.155-.529-1.803-.746-2.956-2.58-3.045-2.7-.091-.12-1.222-1.625-1.222-3.099 0-1.474.773-2.197 1.047-2.496.275-.299.598-.374.797-.374.199 0 .399.002.573.01.184.01.432-.07.674.512.25.599.852 2.079.927 2.23.075.15.125.326.025.525-.099.199-.15.324-.298.499-.15.175-.316.39-.45.524-.15.15-.306.314-.132.613.175.299.776 1.28 1.666 2.072 1.144 1.02 2.11 1.335 2.41 1.485.3.15.474.125.65-.075.174-.2.748-.873.948-1.173.199-.3.399-.25.674-.15.275.1 1.748.824 2.048.974.3.15.499.225.574.35.074.125.074.724-.07 1.129zM12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.436 5.178L2 22l4.958-1.3c1.47.839 3.167 1.3 4.978 1.3 5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.167c-1.637 0-3.17-.492-4.455-1.336l-.319-.208-2.946.772.786-2.871-.227-.361A8.125 8.125 0 013.833 12c0-4.503 3.664-8.167 8.167-8.167 4.503 0 8.167 3.664 8.167 8.167 0 4.503-3.664 8.167-8.167 8.167z"/></svg>
            <span>WHATSAPP ({{ substr(\App\Models\SiteSetting::getNormalizedWhatsAppNumber(), -10) }})</span>
        </a>

        @if(auth()->guard('web')->check())
        <div class="pt-2 border-t border-gray-800/60">
            <form action="{{ route('admin.logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2.5 min-h-[44px] text-rose-400 hover:bg-rose-950/40 hover:text-rose-300 rounded-lg transition font-black tracking-wider cursor-pointer">
                    <span>🚪</span> SIGN OUT
                </button>
            </form>
        </div>
        @endif
    </nav>

    <div class="p-3 bg-gray-900 border-t border-gray-800 text-center text-[8px] font-bold text-gray-500 tracking-wider">
        ABVHPS SECURITY CORE V2.0
    </div>
</div>

<script>
    (function() {
        var lastFocusedAdminElem = null;

        window.toggleAdminDrawer = function(forceState) {
            var drawer = document.getElementById('admin-mobile-drawer');
            var backdrop = document.getElementById('admin-drawer-backdrop');
            var closeBtn = document.getElementById('admin-drawer-close-btn');
            var hamburgerBtns = document.querySelectorAll('[data-admin-drawer-toggle]');

            if (!drawer || !backdrop) return;

            var isOpen = !drawer.classList.contains('-translate-x-full');
            var shouldOpen = typeof forceState === 'boolean' ? forceState : !isOpen;

            if (shouldOpen) {
                lastFocusedAdminElem = document.activeElement;
                backdrop.classList.remove('hidden');
                setTimeout(function() {
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                    drawer.classList.remove('-translate-x-full');
                    drawer.classList.add('translate-x-0');
                }, 10);

                document.body.style.overflow = 'hidden';
                hamburgerBtns.forEach(function(btn) { btn.setAttribute('aria-expanded', 'true'); });
                if (closeBtn) setTimeout(function() { closeBtn.focus(); }, 150);
            } else {
                drawer.classList.remove('translate-x-0');
                drawer.classList.add('-translate-x-full');
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');

                setTimeout(function() {
                    backdrop.classList.add('hidden');
                    document.body.style.overflow = '';
                }, 300);

                hamburgerBtns.forEach(function(btn) { btn.setAttribute('aria-expanded', 'false'); });
                if (lastFocusedAdminElem && typeof lastFocusedAdminElem.focus === 'function') {
                    lastFocusedAdminElem.focus();
                }
            }
        };

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                var drawer = document.getElementById('admin-mobile-drawer');
                if (drawer && !drawer.classList.contains('-translate-x-full')) {
                    window.toggleAdminDrawer(false);
                }
            }
        });
    })();
</script>
