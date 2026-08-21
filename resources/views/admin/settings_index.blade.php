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
    @include('admin.partials.sidebar')

    <!-- BLOCK 2: WORKSPACE -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2 min-w-0 max-w-full">
                @include('admin.partials.header_button')
                <span class="text-xs sm:text-sm font-black text-brandGray uppercase tracking-wider shrink-0">Module:</span>
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm break-words whitespace-normal leading-tight">Global Configuration &amp; Site Settings</span>
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

                <!-- Organization Contact Settings -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="font-black text-sm text-gray-900 uppercase">Organization Contact Information</h3>
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

                <!-- WhatsApp Contact -->
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

                <!-- Social Media URLs -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="font-black text-sm text-gray-900 uppercase">Social Media Links</h3>
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

                <!-- Brand Assets & Media Uploads -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="font-black text-sm text-gray-900 uppercase">Brand Media & Assets</h3>
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

                <!-- SEO & Footer Descriptions -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="font-black text-sm text-gray-900 uppercase">SEO & Footer Descriptions</h3>
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
