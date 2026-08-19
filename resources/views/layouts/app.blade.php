<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ABVHPS - Akhanda Bharatha Viswa Hindu Parirakshana Samiti</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_abvhps.png') }}">
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
    <header class="bg-brandGray text-white text-sm py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span>📞 {{ \App\Models\SiteSetting::get('contact_phone', '+91 8884933379') }}</span>
                <span>✉️ {{ \App\Models\SiteSetting::get('contact_email', 'info@abvhps.org') }}</span>
            </div>
            <div class="flex gap-4 text-xs">
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

            <!-- 12 Menu Navigation Links -->
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

                <a href="/donation" class="bg-brandOrange text-white px-4 py-2 rounded shadow hover:bg-opacity-90 transition">Donation</a>
            </div>

        </div>
    </nav>

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

</body>
</html>
