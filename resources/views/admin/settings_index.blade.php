<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Global Settings | ABVHPS Central Board</title>
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
<body class="bg-gray-100 font-sans text-gray-800 flex h-screen overflow-hidden">

    <!-- BLOCK 1: MASTER UNIFIED CENTRAL ADMIN SIDEBAR -->
    <div class="w-64 bg-brandDarkGray flex flex-col justify-between shadow-xl flex-shrink-0">
        <div class="p-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full overflow-hidden border border-brandOrange shadow-md flex items-center justify-center bg-white p-0.5 shrink-0">
                <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS">
            </div>
            <div>
                <h2 class="text-xs font-black tracking-widest text-brandOrange uppercase">ABVHPS CENTRAL BOARD</h2>
                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block">Unified Management Console</span>
            </div>
        </div>

        <nav class="flex-1 p-3 space-y-1 overflow-y-auto text-[10px] font-black tracking-wider uppercase text-gray-300">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📊</span> DASHBOARD HOME
            </a>

            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">WINGS SUBSYSTEMS</div>
            <a href="{{ route('admin.team.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>👥</span> 1. OUR TEAM
            </a>
            <a href="{{ route('admin.donations.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>💰</span> 2. DONATIONS LEDGER
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📰</span> 3. BLOGS MANAGER
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🖼️</span> 4. MEDIA GALLERY
            </a>
            <a href="{{ route('admin.support.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🌱</span> 5. OUR SUPPORT CORES
            </a>

            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">MEMBERSHIP & CADRES</div>
            <a href="{{ route('admin.membership.ledger') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>💳</span> 6. APPROVED MEMBERSHIP
            </a>
            <a href="{{ route('admin.membership.pending') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>⏳</span> 7. PENDING MEMBERSHIP LIST
            </a>
            <a href="{{ route('admin.volunteers.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🤝</span> 8. VOLUNTEER DESK
            </a>
            <a href="{{ route('admin.rudrasena.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🔱</span> 9. RUDRASENA
            </a>
            <a href="{{ route('admin.local_gateways.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🏡</span> 10. LOCAL GP GATEWAYS
            </a>

            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">SERVICES & CORES</div>
            <a href="{{ route('admin.exams.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📝</span> 11. EXAMS INFO BOARD
            </a>
            <a href="{{ route('admin.fundraising.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📢</span> 12. FUNDRAISING MATRICES
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📩</span> 13. CONTACT FORMS AUDIT
            </a>
            <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📜</span> 14. TAX CERTIFICATES
            </a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
                <span>⚙️</span> 15. SITE GLOBAL SETTINGS
            </a>
            <a href="{{ route('admin.banner.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🚩</span> 16. BANNER MANAGEMENT
            </a>
            <a href="{{ \App\Models\SiteSetting::getWhatsAppUrl() }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-800/60 text-emerald-400 hover:text-white rounded-lg transition font-bold">
                <svg class="w-3.5 h-3.5 fill-current shrink-0 text-emerald-400" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.972.531 1.776.813 2.796.813 3.183 0 5.768-2.587 5.769-5.766.001-3.182-2.585-5.77-5.769-5.77zm3.377 8.239c-.144.405-.837.774-1.17.824-.312.045-.694.076-2.155-.529-1.803-.746-2.956-2.58-3.045-2.7-.091-.12-1.222-1.625-1.222-3.099 0-1.474.773-2.197 1.047-2.496.275-.299.598-.374.797-.374.199 0 .399.002.573.01.184.01.432-.07.674.512.25.599.852 2.079.927 2.23.075.15.125.326.025.525-.099.199-.15.324-.298.499-.15.175-.316.39-.45.524-.15.15-.306.314-.132.613.175.299.776 1.28 1.666 2.072 1.144 1.02 2.11 1.335 2.41 1.485.3.15.474.125.65-.075.174-.2.748-.873.948-1.173.199-.3.399-.25.674-.15.275.1 1.748.824 2.048.974.3.15.499.225.574.35.074.125.074.724-.07 1.129zM12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.436 5.178L2 22l4.958-1.3c1.47.839 3.167 1.3 4.978 1.3 5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.167c-1.637 0-3.17-.492-4.455-1.336l-.319-.208-2.946.772.786-2.871-.227-.361A8.125 8.125 0 013.833 12c0-4.503 3.664-8.167 8.167-8.167 4.503 0 8.167 3.664 8.167 8.167 0 4.503-3.664 8.167-8.167 8.167z"/></svg>
                <span>17. WHATSAPP ({{ substr(\App\Models\SiteSetting::getNormalizedWhatsAppNumber(), -10) }})</span>
            </a>
        </nav>
        
        <div class="p-3 bg-gray-900 border-t border-gray-800 text-center text-[8px] font-bold text-gray-500 tracking-wider">
            ABVHPS SECURITY CORE V2.0
        </div>
    </div>

    <!-- BLOCK 2: WORKSPACE -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <span class="text-sm font-black text-brandGray uppercase tracking-wider">Module:</span>
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">15. Global Configuration & Site Settings</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                Real-Time Config Engine
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            @if(session('success'))
                <div class="p-3 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-bold flex items-center justify-between">
                    <span>✓ {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 font-black">×</button>
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-4xl">
                @csrf

                <!-- Section 1: Contact & Address Settings -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="font-black text-sm text-gray-900 uppercase">1. Organization Contact Information</h3>
                        <p class="text-[10px] text-gray-500">Displayed in top header bar, footer, and contact page.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">Helpline Phone Number *</label>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                        </div>
                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">Official Email Address *</label>
                            <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-black text-gray-700 uppercase mb-1">Headquarters Physical Address *</label>
                        <textarea name="contact_address" rows="2" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">{{ old('contact_address', $settings['contact_address']) }}</textarea>
                    </div>
                </div>

                <!-- Section: WhatsApp Contact -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
                    <div class="border-b border-gray-100 pb-2 flex items-center justify-between">
                        <div>
                            <h3 class="font-black text-sm text-gray-900 uppercase flex items-center gap-2">
                                <span class="text-emerald-500">💬</span> WHATSAPP CONTACT
                            </h3>
                            <p class="text-[10px] text-gray-500">Live official WhatsApp number configuration for public website & admin support links.</p>
                        </div>
                        <span class="bg-emerald-50 text-emerald-700 text-[10px] font-black px-2.5 py-1 rounded-full border border-emerald-200 uppercase">Live Integration</span>
                    </div>

                    <div class="max-w-md">
                        <label class="block font-black text-gray-700 uppercase mb-1">WhatsApp Number *</label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '+91 9989980055') }}" placeholder="e.g. +91 9989980055" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                        <p class="text-[10px] text-gray-500 mt-1.5 font-medium">
                            This number is used by the website WhatsApp contact buttons. Administrators can update it here without changing the code.
                        </p>
                    </div>
                </div>

                <!-- Section 2: Social Media URLs -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="font-black text-sm text-gray-900 uppercase">2. Social Media Links</h3>
                        <p class="text-[10px] text-gray-500">Synced to header bar social links and footer.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">Facebook URL</label>
                            <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                        </div>
                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">Twitter / X URL</label>
                            <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                        </div>
                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">YouTube URL</label>
                            <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url']) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Brand Assets & Media Uploads -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="font-black text-sm text-gray-900 uppercase">3. Brand Media & Assets</h3>
                        <p class="text-[10px] text-gray-500">Update the site wordmark logo and browser favicon.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">Upload Site Logo (PNG)</label>
                            <input type="file" name="site_logo" accept="image/png,image/jpeg" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-600">
                            <span class="text-[10px] text-gray-400">Transparent PNG recommended (Max: 2MB)</span>
                        </div>
                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">Upload Site Favicon</label>
                            <input type="file" name="site_favicon" accept="image/png,image/x-icon,image/vnd.microsoft.icon" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-600">
                            <span class="text-[10px] text-gray-400">Square PNG or ICO (Max: 1MB)</span>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Site Title & Footer Info -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="font-black text-sm text-gray-900 uppercase">4. SEO & Footer Descriptions</h3>
                    </div>

                    <div>
                        <label class="block font-black text-gray-700 uppercase mb-1">Global Site Title *</label>
                        <input type="text" name="site_title" value="{{ old('site_title', $settings['site_title']) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                    </div>

                    <div>
                        <label class="block font-black text-gray-700 uppercase mb-1">Footer "About ABVHPS" Description *</label>
                        <textarea name="footer_about" rows="3" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">{{ old('footer_about', $settings['footer_about']) }}</textarea>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-xs px-8 py-3 rounded-xl shadow uppercase tracking-wider transition">
                        Save Global Settings
                    </button>
                </div>
            </form>
        </main>
    </div>

    <!-- Floating WhatsApp Quick Connect Button -->
    <x-whatsapp-floating-button />

</body>
</html>
