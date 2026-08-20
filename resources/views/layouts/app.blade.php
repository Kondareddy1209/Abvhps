<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- 1. Primary Page Title & Meta Description --}}
    <title>@yield('title', 'ABVHPS | Akhanda Bharatha Viswa Hindu Parirakshana Samiti')</title>
    <meta name="description" content="@yield('meta_description', 'Akhanda Bharatha Viswa Hindu Parirakshana Samiti (ABVHPS) is dedicated to preserving Sanatana Dharma, constructing temples, expanding goshalas, Annapurna daily meals, and community empowerment across India.')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">

    {{-- 2. Canonical URL --}}
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    <link rel="icon" type="image/png" href="{{ asset('images/logo_abvhps.png') }}">

    {{-- 3. Open Graph / Facebook / WhatsApp Metadata --}}
    <meta property="og:site_name" content="ABVHPS">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'ABVHPS | Akhanda Bharatha Viswa Hindu Parirakshana Samiti')">
    <meta property="og:description" content="@yield('og_description', 'Akhanda Bharatha Viswa Hindu Parirakshana Samiti (ABVHPS) is dedicated to preserving Sanatana Dharma, constructing temples, expanding goshalas, and community empowerment across India.')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('images/ABVHPS_LOGO.jpg'))">
    <meta property="og:image:alt" content="@yield('og_image_alt', 'ABVHPS Emblem')">

    {{-- 4. Twitter / X Card Metadata --}}
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', 'ABVHPS | Akhanda Bharatha Viswa Hindu Parirakshana Samiti')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Official Portal of Akhanda Bharatha Viswa Hindu Parirakshana Samiti.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/ABVHPS_LOGO.jpg'))">

    {{-- 5. Schema.org JSON-LD Structured Data (Organization & WebSite) --}}
    @php
        $seoAppUrl = rtrim(config('app.url', 'https://abvhps.org'), '/');
        $schemaData = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    '@id' => $seoAppUrl . '/#organization',
                    'name' => 'Akhanda Bharatha Viswa Hindu Parirakshana Samiti',
                    'alternateName' => 'ABVHPS',
                    'url' => $seoAppUrl,
                    'logo' => asset('images/ABVHPS_LOGO.jpg'),
                    'contactPoint' => [
                        '@type' => 'ContactPoint',
                        'telephone' => \App\Models\SiteSetting::get('contact_phone', '+91 8884933379'),
                        'contactType' => 'customer service',
                        'email' => \App\Models\SiteSetting::get('contact_email', 'info@abvhps.org'),
                        'areaServed' => 'IN',
                        'availableLanguage' => ['en', 'te', 'hi']
                    ]
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => $seoAppUrl . '/#website',
                    'url' => $seoAppUrl,
                    'name' => 'ABVHPS Official Portal',
                    'publisher' => [
                        '@id' => $seoAppUrl . '/#organization'
                    ]
                ]
            ]
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

    <!-- Tailwind CSS v4 Browser/Play CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-brandOrange: #FF6600;
            --color-brandGray: #4A4A4A;
            --color-brandDarkGray: #1A1A1A;
            --color-brandLightOrange: #FFF5EE;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- 1. Top Header -->
    <header class="bg-brandGray text-white text-[11px] sm:text-xs py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-4 gap-y-1">
                <span>📞 {{ \App\Models\SiteSetting::get('contact_phone', '+91 8884933379') }}</span>
                <span>✉️ {{ \App\Models\SiteSetting::get('contact_email', 'info@abvhps.org') }}</span>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1 text-[11px] sm:text-xs">
                <a href="{{ \App\Models\SiteSetting::get('facebook_url', '#') }}" target="_blank" class="hover:text-brandOrange">Facebook</a>
                <a href="{{ \App\Models\SiteSetting::get('twitter_url', '#') }}" target="_blank" class="hover:text-brandOrange">Twitter</a>
                <a href="{{ \App\Models\SiteSetting::get('youtube_url', '#') }}" target="_blank" class="hover:text-brandOrange">YouTube</a>
                <a href="{{ route('public.certificates') }}" class="hover:text-brandOrange font-bold text-orange-300">📜 80G/12A Compliance</a>
            </div>
        </div>
    </header>

    <!-- 2. Main Navigation Bar with 12 Menu Items -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center py-2.5 sm:py-3">
            <a href="/" class="flex items-center gap-3.5 group shrink-0">
                <!-- Circular Emblem (Enlarged 64px / w-16 h-16) -->
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full flex items-center justify-center overflow-hidden bg-orange-50/90 border-2 border-brandOrange shadow group-hover:border-orange-600 transition shrink-0 p-1">
                    <img src="{{ asset('images/logo_abvhps.png') }}" class="w-full h-full object-contain" alt="ABVHPS Emblem">
                </div>
                <!-- Stylized Wordmark Graphic (Enlarged to h-12 sm:h-14) -->
                <img src="{{ asset('images/logo.png') }}" class="h-11 sm:h-14 w-auto max-w-[170px] sm:max-w-[240px] object-contain shrink-0 transition group-hover:opacity-95" alt="Akhanda Bharata - Viswa Hindu Parirakshana Samiti">
            </a>

            <!-- Mobile Hamburger Button (< 1280px / xl) -->
            <button type="button" id="public-mobile-menu-btn" onclick="togglePublicMobileMenu()" class="xl:hidden flex items-center justify-center p-2.5 rounded-xl bg-orange-50 hover:bg-orange-100 text-brandOrange border border-orange-200 transition focus:outline-none focus:ring-2 focus:ring-brandOrange cursor-pointer min-w-[44px] min-h-[44px]" aria-label="Open navigation" aria-expanded="false" aria-controls="public-mobile-drawer">
                <svg id="public-hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- 12 Menu Navigation Links (Desktop >= 1280px / xl) -->
            <div class="hidden xl:flex items-center gap-4 font-semibold text-sm text-brandGray">
                <a href="/" class="hover:text-brandOrange transition">Home</a>
                <a href="/about" class="hover:text-brandOrange transition">About</a>
                <a href="{{ route('public.team') }}" class="nav-link">Our Team</a>
                <a href="/gallery" class="hover:text-brandOrange transition">Gallery</a>
                <a href="/membership" class="hover:text-brandOrange transition">Membership</a>
                <a href="/volunteer" class="hover:text-brandOrange transition">Volunteer</a>

                <!-- Fixed Exam Sub-Menu Dropdown Desk with Notice Board -->
                <div class="relative group py-2">
                    <button class="hover:text-brandOrange transition cursor-pointer flex items-center gap-1 focus:outline-none">
                        <span>Exam</span>
                        <span class="text-xs text-gray-400">▼</span>
                    </button>
                    <div class="absolute left-0 pt-2 w-48 hidden group-hover:block z-50 top-full">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-xl py-1">
                            <a href="{{ route('public.exams_board') }}" class="block px-4 py-2 text-gray-700 hover:bg-brandLightOrange hover:text-brandOrange font-bold transition text-xs border-b border-gray-100">
                                📋 Exams Notice Board
                            </a>
                            <a href="{{ route('exam.form') }}" class="block px-4 py-2 text-gray-700 hover:bg-brandLightOrange hover:text-brandOrange font-medium transition text-xs">
                                Apply Online
                            </a>
                            <a href="{{ route('exam.results_portal') }}" class="block px-4 py-2 text-gray-700 hover:bg-brandLightOrange hover:text-brandOrange font-medium transition text-xs border-t border-gray-100">
                                View Results
                            </a>
                        </div>
                    </div>
                </div>

                <!-- GLOBAL OUR WINGS DROPDOWN DESK SYSTEM -->
                <div class="relative inline-block text-left group">
                    <button type="button" class="inline-flex items-center gap-1 font-bold text-gray-700 hover:text-brandOrange transition uppercase cursor-pointer py-2">
                        <span>OUR WINGS</span>
                        <svg class="w-4 h-4 transition transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div class="absolute left-0 w-56 bg-white border border-gray-200 rounded-lg shadow-xl py-1 z-50 hidden group-hover:block transition animate-fadeIn">
                        <a href="{{ route('rudrasena.form') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs font-black text-gray-700 hover:bg-orange-50 hover:text-brandOrange transition border-b border-gray-100">
                            <span>🔱</span> RUDRASENA DAL
                        </a>
                        <a href="{{ route('kalabrundam.form') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs font-black text-gray-700 hover:bg-orange-50 hover:text-brandOrange transition border-b border-gray-100">
                            <span>🪘</span> KALA BRUNDAM
                        </a>
                        <a href="{{ route('gramasevadal.form') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs font-black text-gray-700 hover:bg-orange-50 hover:text-brandOrange transition border-b border-gray-100">
                            <span>🌱</span> GRAMA SEVA DAL
                        </a>
                        <a href="{{ route('organicfarmers.form') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs font-black text-gray-700 hover:bg-orange-50 hover:text-brandOrange transition">
                            <span>🌾</span> ORGANIC FARMERS
                        </a>
                    </div>
                </div>

                <a href="{{ route('donations.grid') }}" class="hover:text-brandOrange transition">FUNDRAISE</a>
                <a href="{{ route('public.blogs') }}" class="nav-link font-semibold text-gray-700 hover:text-orange-500 transition">Blogs</a>
                <a href="{{ route('public.contact') }}" class="hover:text-brandOrange transition">Contact</a>
                <a href="{{ route('donations.grid') }}" class="bg-brandOrange text-white px-4 py-2 rounded shadow hover:bg-opacity-90 transition">Donation</a>
            </div>

        </div>
    </nav>

    <!-- Public Mobile Navigation Drawer (< 1280px / xl) -->
    <div id="public-mobile-backdrop" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-[70] hidden opacity-0 transition-opacity duration-300 xl:hidden" onclick="togglePublicMobileMenu(false)" aria-hidden="true"></div>

    <div id="public-mobile-drawer" class="fixed inset-y-0 right-0 w-[320px] max-w-[85vw] bg-white z-[80] shadow-2xl flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-in-out xl:hidden select-none" role="dialog" aria-modal="true" aria-label="Public Navigation Menu">
        <!-- Header of Drawer -->
        <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-orange-50/50">
            <a href="/" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-brandOrange shadow-xs flex items-center justify-center bg-white p-0.5 shrink-0">
                    <img src="{{ asset('images/logo_abvhps.png') }}" class="w-full h-full object-contain" alt="ABVHPS">
                </div>
                <div>
                    <span class="text-xs font-black text-brandOrange uppercase tracking-wider block">ABVHPS CENTRAL</span>
                    <span class="text-[9px] text-gray-500 font-bold uppercase tracking-wider block">Parirakshana Samiti</span>
                </div>
            </a>
            <button type="button" id="public-mobile-close-btn" onclick="togglePublicMobileMenu(false)" class="p-2 rounded-xl text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition min-w-[44px] min-h-[44px] flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-brandOrange cursor-pointer" aria-label="Close navigation">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation List (Scrollable) -->
        <nav class="flex-1 px-4 py-3 space-y-1 overflow-y-auto text-xs font-bold text-gray-700 min-h-0">
            <a href="/" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2.5 px-3.5 py-3 min-h-[44px] rounded-xl {{ request()->is('/') ? 'bg-orange-50 text-brandOrange font-black border border-orange-200 shadow-xs' : 'hover:bg-gray-50 hover:text-brandOrange transition' }}">
                <span>🏠</span> Home
            </a>
            <a href="/about" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2.5 px-3.5 py-3 min-h-[44px] rounded-xl {{ request()->is('about*') ? 'bg-orange-50 text-brandOrange font-black border border-orange-200 shadow-xs' : 'hover:bg-gray-50 hover:text-brandOrange transition' }}">
                <span>📖</span> About
            </a>
            <a href="{{ route('public.team') }}" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2.5 px-3.5 py-3 min-h-[44px] rounded-xl {{ request()->routeIs('public.team*') ? 'bg-orange-50 text-brandOrange font-black border border-orange-200 shadow-xs' : 'hover:bg-gray-50 hover:text-brandOrange transition' }}">
                <span>👥</span> Our Team
            </a>
            <a href="/gallery" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2.5 px-3.5 py-3 min-h-[44px] rounded-xl {{ request()->is('gallery*') ? 'bg-orange-50 text-brandOrange font-black border border-orange-200 shadow-xs' : 'hover:bg-gray-50 hover:text-brandOrange transition' }}">
                <span>🖼️</span> Gallery
            </a>
            <a href="/membership" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2.5 px-3.5 py-3 min-h-[44px] rounded-xl {{ request()->is('membership*') ? 'bg-orange-50 text-brandOrange font-black border border-orange-200 shadow-xs' : 'hover:bg-gray-50 hover:text-brandOrange transition' }}">
                <span>💳</span> Membership
            </a>
            <a href="/volunteer" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2.5 px-3.5 py-3 min-h-[44px] rounded-xl {{ request()->is('volunteer*') ? 'bg-orange-50 text-brandOrange font-black border border-orange-200 shadow-xs' : 'hover:bg-gray-50 hover:text-brandOrange transition' }}">
                <span>🤝</span> Volunteer
            </a>

            <!-- Accordion 1: Exam -->
            <div class="border border-gray-100 rounded-xl overflow-hidden my-1 bg-gray-50/50">
                <button type="button" onclick="togglePublicSubmenu('public-exam-submenu', 'public-exam-arrow')" class="w-full flex items-center justify-between px-3.5 py-3 min-h-[44px] text-gray-700 hover:text-brandOrange transition focus:outline-none cursor-pointer">
                    <span class="flex items-center gap-2.5"><span>📝</span> Exam</span>
                    <svg id="public-exam-arrow" class="w-4 h-4 transition-transform duration-200 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="public-exam-submenu" class="hidden pl-6 pr-3 pb-2 space-y-1 bg-white border-t border-gray-100 text-[11px]">
                    <a href="{{ route('public.exams_board') }}" onclick="togglePublicMobileMenu(false)" class="block px-3 py-2.5 min-h-[44px] rounded-lg text-gray-600 hover:text-brandOrange hover:bg-orange-50 transition border-b border-gray-50">
                        📋 Exams Notice Board
                    </a>
                    <a href="{{ route('exam.form') }}" onclick="togglePublicMobileMenu(false)" class="block px-3 py-2.5 min-h-[44px] rounded-lg text-gray-600 hover:text-brandOrange hover:bg-orange-50 transition border-b border-gray-50">
                        ✍️ Apply Online
                    </a>
                    <a href="{{ route('exam.results_portal') }}" onclick="togglePublicMobileMenu(false)" class="block px-3 py-2.5 min-h-[44px] rounded-lg text-gray-600 hover:text-brandOrange hover:bg-orange-50 transition">
                        🏆 View Results
                    </a>
                </div>
            </div>

            <!-- Accordion 2: Our Wings -->
            <div class="border border-gray-100 rounded-xl overflow-hidden my-1 bg-gray-50/50">
                <button type="button" onclick="togglePublicSubmenu('public-wings-submenu', 'public-wings-arrow')" class="w-full flex items-center justify-between px-3.5 py-3 min-h-[44px] text-gray-700 hover:text-brandOrange transition focus:outline-none cursor-pointer">
                    <span class="flex items-center gap-2.5 uppercase font-black"><span>🚩</span> OUR WINGS</span>
                    <svg id="public-wings-arrow" class="w-4 h-4 transition-transform duration-200 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="public-wings-submenu" class="hidden pl-6 pr-3 pb-2 space-y-1 bg-white border-t border-gray-100 text-[11px]">
                    <a href="{{ route('rudrasena.form') }}" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2 px-3 py-2.5 min-h-[44px] rounded-lg text-gray-700 hover:text-brandOrange hover:bg-orange-50 font-black transition border-b border-gray-50">
                        <span>🔱</span> RUDRASENA DAL
                    </a>
                    <a href="{{ route('kalabrundam.form') }}" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2 px-3 py-2.5 min-h-[44px] rounded-lg text-gray-700 hover:text-brandOrange hover:bg-orange-50 font-black transition border-b border-gray-50">
                        <span>🪘</span> KALA BRUNDAM
                    </a>
                    <a href="{{ route('gramasevadal.form') }}" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2 px-3 py-2.5 min-h-[44px] rounded-lg text-gray-700 hover:text-brandOrange hover:bg-orange-50 font-black transition border-b border-gray-50">
                        <span>🌱</span> GRAMA SEVA DAL
                    </a>
                    <a href="{{ route('organicfarmers.form') }}" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2 px-3 py-2.5 min-h-[44px] rounded-lg text-gray-700 hover:text-brandOrange hover:bg-orange-50 font-black transition">
                        <span>🌾</span> ORGANIC FARMERS
                    </a>
                </div>
            </div>

            <a href="{{ route('donations.grid') }}" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2.5 px-3.5 py-3 min-h-[44px] rounded-xl {{ request()->routeIs('donations.*') ? 'bg-orange-50 text-brandOrange font-black border border-orange-200 shadow-xs' : 'hover:bg-gray-50 hover:text-brandOrange transition' }}">
                <span>💰</span> Fundraise
            </a>
            <a href="{{ route('public.blogs') }}" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2.5 px-3.5 py-3 min-h-[44px] rounded-xl {{ request()->routeIs('public.blogs*') ? 'bg-orange-50 text-brandOrange font-black border border-orange-200 shadow-xs' : 'hover:bg-gray-50 hover:text-brandOrange transition' }}">
                <span>📰</span> Blogs
            </a>
            <a href="{{ route('public.contact') }}" onclick="togglePublicMobileMenu(false)" class="flex items-center gap-2.5 px-3.5 py-3 min-h-[44px] rounded-xl {{ request()->routeIs('public.contact*') ? 'bg-orange-50 text-brandOrange font-black border border-orange-200 shadow-xs' : 'hover:bg-gray-50 hover:text-brandOrange transition' }}">
                <span>📩</span> Contact
            </a>

            <div class="pt-3 pb-1">
                <a href="{{ route('donations.grid') }}" onclick="togglePublicMobileMenu(false)" class="w-full bg-brandOrange text-white font-black text-center py-3 min-h-[44px] rounded-xl shadow hover:bg-opacity-95 transition flex items-center justify-center gap-2 uppercase tracking-wider">
                    <span>🙏</span> Make a Donation
                </a>
            </div>
        </nav>

        <!-- Footer of Drawer -->
        <div class="p-4 border-t border-gray-100 bg-gray-50 space-y-2 text-[11px]">
            <a href="{{ route('public.certificates') }}" onclick="togglePublicMobileMenu(false)" class="block text-brandOrange font-bold hover:underline">
                📜 80G / 12A Tax Exemption Compliance
            </a>
            <div class="text-gray-500 text-[10px] space-y-0.5">
                <div>📞 {{ \App\Models\SiteSetting::get('contact_phone', '+91 8884933379') }}</div>
                <div>✉️ {{ \App\Models\SiteSetting::get('contact_email', 'info@abvhps.org') }}</div>
            </div>
        </div>
    </div>

    <!-- 3. Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- 4. Footer Component -->
    <footer class="bg-brandDarkGray text-gray-300 pt-10 pb-4 px-4 mt-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 border-b border-gray-700 pb-8">
            <div>
                <h3 class="text-white font-bold text-lg mb-4 text-brandOrange">About ABVHPS</h3>
                <p class="text-sm leading-relaxed">
                    {{ \App\Models\SiteSetting::get('footer_about', 'Dedicated to preserving and promoting Hindu culture and values worldwide under the behest of Rajaguru Sri Sri Sri Subrahmanneswara Swamy Garu.') }}
                </p>
            </div>
            <div>
                <h3 class="text-white font-bold text-lg mb-4 text-brandOrange">Quick Links</h3>
                <div class="grid grid-cols-1 gap-1.5 text-sm">
                    <a href="/about" class="hover:text-white">About Us</a>
                    <a href="/membership" class="hover:text-white">Membership</a>
                    <a href="/volunteer" class="hover:text-white">Volunteer</a>
                    <a href="/donation" class="hover:text-white">Donation</a>
                    <a href="{{ route('public.contact') }}" class="hover:text-white">Contact Us</a>
                    <a href="{{ route('public.certificates') }}" class="hover:text-white">80G / 12A</a>
                </div>
            </div>
            <div>
                <h3 class="text-white font-bold text-lg mb-4 text-brandOrange">Our Wings</h3>
                <div class="space-y-1.5 text-sm">
                    <a href="{{ route('rudrasena.form') }}" class="hover:text-white block">🔱 Rudrasena Dal</a>
                    <a href="{{ route('kalabrundam.form') }}" class="hover:text-white block">🪘 Kala Brundam</a>
                    <a href="{{ route('gramasevadal.form') }}" class="hover:text-white block">🌱 Grama Seva Dal</a>
                    <a href="{{ route('organicfarmers.form') }}" class="hover:text-white block font-bold text-emerald-400">🌾 Organic Farmers</a>
                </div>
            </div>
            <div>
                <h3 class="text-white font-bold text-lg mb-4 text-brandOrange">Services & Exams</h3>
                <div class="space-y-1.5 text-sm">
                    <a href="{{ route('public.exams_board') }}" class="hover:text-white block">Exams Notice Board</a>
                    <a href="{{ route('exam.form') }}" class="hover:text-white block">Exam Application</a>
                    <a href="{{ route('exam.results_portal') }}" class="hover:text-white block">Check Results</a>
                    <a href="{{ route('donations.grid') }}" class="hover:text-white block">Fundraise Campaigns</a>
                </div>
            </div>
            <div>
                <h3 class="text-white font-bold text-lg mb-4 text-brandOrange">Contact Us</h3>
                <p class="text-sm leading-relaxed mb-2">
                    {{ \App\Models\SiteSetting::get('contact_address', 'Survey No:1826, Shanmukhapuram, Akkalareddy Palli Village and Post, Porumamilla Mandalam, Kadapa, A.P - 516193') }}
                </p>
                <div class="text-xs font-mono text-gray-400 space-y-1">
                    <div>📞 {{ \App\Models\SiteSetting::get('contact_phone', '+91 8884933379') }}</div>
                    <div>✉️ {{ \App\Models\SiteSetting::get('contact_email', 'info@abvhps.org') }}</div>
                </div>
            </div>
        </div>
        <div class="text-center text-xs text-gray-500 pt-4">
            &copy; {{ date('Y') }} ABVHPS. All Rights Reserved.
        </div>
    </footer>

    <!-- Floating WhatsApp Quick Connect Button -->
    <x-whatsapp-floating-button />

    <script>
        (function() {
            var lastFocusedPublicElem = null;

            window.togglePublicMobileMenu = function(forceState) {
                var drawer = document.getElementById('public-mobile-drawer');
                var backdrop = document.getElementById('public-mobile-backdrop');
                var menuBtn = document.getElementById('public-mobile-menu-btn');
                var closeBtn = document.getElementById('public-mobile-close-btn');

                if (!drawer || !backdrop) return;

                var isOpen = !drawer.classList.contains('translate-x-full');
                var shouldOpen = typeof forceState === 'boolean' ? forceState : !isOpen;

                if (shouldOpen) {
                    lastFocusedPublicElem = document.activeElement;
                    backdrop.classList.remove('hidden');
                    setTimeout(function() {
                        backdrop.classList.remove('opacity-0');
                        backdrop.classList.add('opacity-100');
                        drawer.classList.remove('translate-x-full');
                        drawer.classList.add('translate-x-0');
                    }, 10);

                    document.body.style.overflow = 'hidden';
                    if (menuBtn) menuBtn.setAttribute('aria-expanded', 'true');
                    if (closeBtn) setTimeout(function() { closeBtn.focus(); }, 150);
                } else {
                    drawer.classList.remove('translate-x-0');
                    drawer.classList.add('translate-x-full');
                    backdrop.classList.remove('opacity-100');
                    backdrop.classList.add('opacity-0');

                    setTimeout(function() {
                        backdrop.classList.add('hidden');
                        document.body.style.overflow = '';
                    }, 300);

                    if (menuBtn) menuBtn.setAttribute('aria-expanded', 'false');
                    if (lastFocusedPublicElem && typeof lastFocusedPublicElem.focus === 'function') {
                        lastFocusedPublicElem.focus();
                    }
                }
            };

            window.togglePublicSubmenu = function(submenuId, arrowId) {
                var submenu = document.getElementById(submenuId);
                var arrow = document.getElementById(arrowId);
                if (!submenu) return;

                var isHidden = submenu.classList.contains('hidden');
                if (isHidden) {
                    submenu.classList.remove('hidden');
                    if (arrow) arrow.classList.add('rotate-180');
                } else {
                    submenu.classList.add('hidden');
                    if (arrow) arrow.classList.remove('rotate-180');
                }
            };

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' || e.keyCode === 27) {
                    var drawer = document.getElementById('public-mobile-drawer');
                    if (drawer && !drawer.classList.contains('translate-x-full')) {
                        window.togglePublicMobileMenu(false);
                    }
                }
            });
        })();
    </script>
</body>
</html>
