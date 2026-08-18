@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100/60 flex flex-col md:flex-row select-none">
    
    <!-- BLOCK 1: MASTER ADMINISTRATIVE LEFT SIDEBAR CONTROLLER -->
    <div class="w-full md:w-64 bg-brandDarkGray text-white flex flex-col border-r-4 border-brandOrange shrink-0 shadow-xl">
        <div class="p-5 text-center bg-gray-900 border-b border-gray-800">
            <span class="text-3xl block mb-1 drop-shadow-md">👑</span>
            <h2 class="text-xs font-black tracking-widest text-brandOrange uppercase">ABVHPS CENTRAL BOARD</h2>
            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Master Control Panel Desk</p>
        </div>
        
        <!-- 15 Core Navigation Matrix Link Nodes -->
        <nav class="flex-1 p-3 space-y-1 overflow-y-auto text-[10px] font-black tracking-wider uppercase text-gray-300">
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
                <span>📊</span> DASHBOARD HOME
            </a>

            <!-- WINGS SUBSYSTEMS -->
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

            <!-- MEMBERSHIP & CADRES -->
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

            <!-- EXAMS & CAMPAIGNS -->
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
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition">
                <span>⚙️</span> 15. SITE GLOBAL SETTINGS
            </a>
        </nav>
        
        <div class="p-3 bg-gray-900 border-t border-gray-800 text-center text-[8px] font-bold text-gray-500 tracking-wider">
            ABVHPS SECURITY CORE V2.0
        </div>
    </div>
    <!-- BLOCK 2: MASTER MAIN WORKSPACE VIEWPORT DESK -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Workspace Top Status Banner Navbar -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <span class="text-sm font-black text-brandGray uppercase tracking-wider">System View:</span>
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Central Commander</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            <!-- SECTION 1: MASTER ANALYTICAL REGISTRY COUNTERS GRID (6 CORE WIDGETS) -->
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Counter Card 1: Total Base System Registries -->
                <div class="bg-white border border-gray-200 rounded-xl p-4 md:p-5 shadow-sm flex items-center justify-between transform hover:scale-[1.01] transition-all">
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Central Base Register</span>
                        <span class="text-xl md:text-3xl font-black font-mono text-brandGray mt-0.5 block">{{ number_format($stats['total_members'] ?? 0) }}</span>
                        <span class="text-[9px] font-bold text-gray-500 block mt-1">Total Verified Profiles</span>
                    </div>
                    <div class="text-2xl md:text-3xl p-3 bg-gray-50 rounded-xl border border-gray-100">👥</div>
                </div>

                <!-- Counter Card 2: Rudrasena Roster Force Matrix -->
                <div class="bg-white border border-gray-200 rounded-xl p-4 md:p-5 shadow-sm flex items-center justify-between transform hover:scale-[1.01] transition-all">
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Rudrasena Military Force</span>
                        <span class="text-xl md:text-3xl font-black font-mono text-brandOrange mt-0.5 block">{{ number_format($stats['rudrasena_count'] ?? 0) }}</span>
                        <span class="text-[9px] font-bold text-brandOrange block mt-1">🛡️ Active Command Force</span>
                    </div>
                    <div class="text-2xl md:text-3xl p-3 bg-orange-50 rounded-xl border border-orange-100">🔱</div>
                </div>

                <!-- Counter Card 3: Kala Brundam Culture Registry -->
                <div class="bg-white border border-gray-200 rounded-xl p-4 md:p-5 shadow-sm flex items-center justify-between transform hover:scale-[1.01] transition-all">
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Kala Brundam Roster</span>
                        <span class="text-xl md:text-3xl font-black font-mono text-indigo-700 mt-0.5 block">{{ number_format($stats['kala_brundam_count'] ?? 0) }}</span>
                        <span class="text-[9px] font-bold text-indigo-600 block mt-1">🎻 Verified Culture Artists</span>
                    </div>
                    <div class="text-2xl md:text-3xl p-3 bg-indigo-50 rounded-xl border border-indigo-100">🪘</div>
                </div>

                <!-- Counter Card 4: Grama Seva Dal Commitee Matrix -->
                <div class="bg-white border border-gray-200 rounded-xl p-4 md:p-5 shadow-sm flex items-center justify-between transform hover:scale-[1.01] transition-all">
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Grama Seva Dal Networks</span>
                        <span class="text-xl md:text-3xl font-black font-mono text-emerald-700 mt-0.5 block">{{ number_format($stats['grama_seva_dal_count'] ?? 0) }}</span>
                        <span class="text-[9px] font-bold text-emerald-600 block mt-1">🌱 Village Charters Issued</span>
                    </div>
                    <div class="text-2xl md:text-3xl p-3 bg-emerald-50 rounded-xl border border-emerald-100">🌿</div>
                </div>

                <!-- Counter Card 5: Organic Farmers Association -->
                <div class="bg-white border border-gray-200 rounded-xl p-4 md:p-5 shadow-sm flex items-center justify-between transform hover:scale-[1.01] transition-all">
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Organic Agriculture Wing</span>
                        <span class="text-xl md:text-3xl font-black font-mono text-green-700 mt-0.5 block">{{ number_format($stats['organic_farmers_count'] ?? 0) }}</span>
                        <span class="text-[9px] font-bold text-green-600 block mt-1">🌾 Nature Certified Farmers</span>
                    </div>
                    <div class="text-2xl md:text-3xl p-3 bg-green-50 rounded-xl border border-green-100">🐄</div>
                </div>

                <!-- Counter Card 6: Live Fundraising Central Ledger Vault -->
                <div class="bg-white border border-gray-200 rounded-xl p-4 md:p-5 shadow-sm flex items-center justify-between transform hover:scale-[1.01] transition-all col-span-2 lg:col-span-1 border-b-4 border-b-amber-500">
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Dharma Seva Capital Ledger</span>
                        <span class="text-xl md:text-3xl font-black font-mono text-amber-600 mt-0.5 block">₹{{ number_format($stats['total_funds_raised'] ?? 0, 2) }}</span>
                        <span class="text-[9px] font-bold text-amber-600 block mt-1">💰 Consolidated Campaign Funds</span>
                    </div>
                    <div class="text-2xl md:text-3xl p-3 bg-amber-50 rounded-xl border border-amber-100">🪘</div>
                </div>
            </div>

            <!-- SECTION 2: CENTRAL ADMINISTRATIVE CONTROL NOTICE -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden p-6 text-center">
                <span class="text-3xl block mb-2">⚡</span>
                <h4 class="text-xs font-black text-brandGray uppercase tracking-widest text-brandOrange">System Master Core Alignment Mode</h4>
                <p class="text-[11px] text-gray-500 mt-1 max-w-md mx-auto font-medium">All 15 management sub-systems are structured into the central configuration panel dashboard. Select nodes on the left sidebar to execute individual system modules.</p>
            </div>
        </main> <!-- END WORKSPACE CONTAINER -->
    </div> <!-- END MAIN WORKSPACE VIEWPORT DESK -->
</div> <!-- END MIN-H-SCREEN CONTAINER -->
@endsection
