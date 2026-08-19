@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100/60 flex flex-col md:flex-row select-none">

    <!-- BLOCK 1: MASTER ADMINISTRATIVE LEFT SIDEBAR -->
    <div class="w-full md:w-64 bg-brandDarkGray text-white flex flex-col border-r-4 border-brandOrange shrink-0 shadow-xl">
        <div class="p-5 text-center bg-gray-900 border-b border-gray-800">
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-brandOrange shadow mx-auto mb-2 flex items-center justify-center bg-white p-0.5">
                <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS">
            </div>
            <h2 class="text-xs font-black tracking-widest text-brandOrange uppercase">ABVHPS CENTRAL BOARD</h2>
            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Master Control Panel Desk</p>
        </div>
        <nav class="flex-1 p-3 space-y-1 overflow-y-auto text-[10px] font-black tracking-wider uppercase text-gray-300">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
                <span>📊</span> DASHBOARD HOME
            </a>
            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">WINGS SUBSYSTEMS</div>
            <a href="{{ route('admin.team.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>👥</span> 1. OUR TEAM</a>
            <a href="{{ route('admin.donations.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>💰</span> 2. DONATIONS LEDGER</a>
            <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>📰</span> 3. BLOGS MANAGER</a>
            <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>🖼️</span> 4. MEDIA GALLERY</a>
            <a href="{{ route('admin.support.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>🌱</span> 5. OUR SUPPORT CORES</a>
            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">MEMBERSHIP &amp; CADRES</div>
            <a href="{{ route('admin.membership.ledger') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>💳</span> 6. APPROVED MEMBERSHIP</a>
            <a href="{{ route('admin.membership.pending') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>⏳</span> 7. PENDING MEMBERSHIP LIST</a>
            <a href="{{ route('admin.volunteers.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>🤝</span> 8. VOLUNTEER DESK</a>
            <a href="{{ route('admin.rudrasena.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>🔱</span> 9. RUDRASENA</a>
            <a href="{{ route('admin.local_gateways.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>🏡</span> 10. LOCAL GP GATEWAYS</a>
            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">SERVICES &amp; CORES</div>
            <a href="{{ route('admin.exams.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>📝</span> 11. EXAMS INFO BOARD</a>
            <a href="{{ route('admin.fundraising.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>📢</span> 12. FUNDRAISING MATRICES</a>
            <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>📩</span> 13. CONTACT FORMS AUDIT</a>
            <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>📜</span> 14. TAX CERTIFICATES</a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>⚙️</span> 15. SITE GLOBAL SETTINGS</a>
            <a href="{{ route('admin.banner.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>🚩</span> 16. BANNER MANAGEMENT</a>
            <a href="{{ \App\Models\SiteSetting::getWhatsAppUrl() }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-800/60 text-emerald-400 hover:text-white rounded-lg transition font-bold">
                <svg class="w-3.5 h-3.5 fill-current shrink-0 text-emerald-400" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.972.531 1.776.813 2.796.813 3.183 0 5.768-2.587 5.769-5.766.001-3.182-2.585-5.77-5.769-5.77zm3.377 8.239c-.144.405-.837.774-1.17.824-.312.045-.694.076-2.155-.529-1.803-.746-2.956-2.58-3.045-2.7-.091-.12-1.222-1.625-1.222-3.099 0-1.474.773-2.197 1.047-2.496.275-.299.598-.374.797-.374.199 0 .399.002.573.01.184.01.432-.07.674.512.25.599.852 2.079.927 2.23.075.15.125.326.025.525-.099.199-.15.324-.298.499-.15.175-.316.39-.45.524-.15.15-.306.314-.132.613.175.299.776 1.28 1.666 2.072 1.144 1.02 2.11 1.335 2.41 1.485.3.15.474.125.65-.075.174-.2.748-.873.948-1.173.199-.3.399-.25.674-.15.275.1 1.748.824 2.048.974.3.15.499.225.574.35.074.125.074.724-.07 1.129zM12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.436 5.178L2 22l4.958-1.3c1.47.839 3.167 1.3 4.978 1.3 5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.167c-1.637 0-3.17-.492-4.455-1.336l-.319-.208-2.946.772.786-2.871-.227-.361A8.125 8.125 0 013.833 12c0-4.503 3.664-8.167 8.167-8.167 4.503 0 8.167 3.664 8.167 8.167 0 4.503-3.664 8.167-8.167 8.167z"/></svg>
                <span>17. WHATSAPP ({{ substr(\App\Models\SiteSetting::getNormalizedWhatsAppNumber(), -10) }})</span>
            </a>
        </nav>
        <div class="p-3 bg-gray-900 border-t border-gray-800 text-center text-[8px] font-bold text-gray-500 tracking-wider">
            ABVHPS SECURITY CORE V2.0
        </div>
    </div>

    <!-- BLOCK 2: MAIN WORKSPACE VIEWPORT -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Top Admin Bar -->
        <header class="bg-white border-b border-gray-200 px-5 py-3 flex items-center justify-between shadow-sm shrink-0">
            <div class="flex items-center gap-2.5">
                <span class="text-sm font-black text-brandGray uppercase tracking-wider">System View:</span>
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Central Commander</span>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-1.5 text-[10px] font-bold text-emerald-600">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>SYSTEM ONLINE
                </div>
                <div class="text-[10px] font-mono font-black text-gray-400">
                    {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
                </div>
            </div>
        </header>

        <!-- Dashboard Workspace -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-5">

            <!-- ROW 1: EXECUTIVE SUMMARY -->
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="h-4 w-1 bg-brandOrange rounded-full"></div>
                    <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Executive Summary</h2>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border-t-4 border-t-brandOrange">
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Profiles</div>
                        <div class="text-2xl font-black font-mono text-brandGray">{{ number_format($stats['total_members'] ?? 0) }}</div>
                        <div class="text-[9px] text-gray-500 mt-1">Registered memberships</div>
                        <a href="{{ route('admin.membership.ledger') }}" class="text-[9px] font-black text-brandOrange mt-2 block hover:underline">View Ledger →</a>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border-t-4 border-t-blue-500">
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Volunteers</div>
                        <div class="text-2xl font-black font-mono text-blue-700">{{ number_format($stats['total_volunteers'] ?? 0) }}</div>
                        <div class="text-[9px] text-gray-500 mt-1">Approved cadre members</div>
                        <a href="{{ route('admin.volunteers.index') }}" class="text-[9px] font-black text-brandOrange mt-2 block hover:underline">View Volunteers →</a>
                    </div>
                    @php $totalPending = ($stats['pending_memberships'] ?? 0) + ($stats['pending_volunteers'] ?? 0); @endphp
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border-t-4 {{ $totalPending > 0 ? 'border-t-amber-500' : 'border-t-gray-300' }}">
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Pending Actions</div>
                        <div class="text-2xl font-black font-mono {{ $totalPending > 0 ? 'text-amber-600' : 'text-gray-400' }}">{{ number_format($totalPending) }}</div>
                        <div class="text-[9px] text-gray-500 mt-1">Require admin review</div>
                        <a href="{{ route('admin.membership.pending') }}" class="text-[9px] font-black text-brandOrange mt-2 block hover:underline">Review Pending →</a>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border-t-4 border-t-amber-400">
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Funds Raised</div>
                        <div class="text-2xl font-black font-mono text-amber-600">&#8377;{{ number_format($stats['total_funds_raised'] ?? 0) }}</div>
                        <div class="text-[9px] text-gray-500 mt-1">Consolidated campaigns</div>
                        <a href="{{ route('admin.fundraising.index') }}" class="text-[9px] font-black text-brandOrange mt-2 block hover:underline">View Fundraising →</a>
                    </div>
                </div>
            </div>

            <!-- ROW 2: ORGANIZATIONAL WING OVERVIEW -->
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="h-4 w-1 bg-brandOrange rounded-full"></div>
                    <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Organizational Wing Overview</h2>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-3">
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow text-center">
                        <div class="text-2xl mb-1">👥</div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-tight mb-1">Central Base</div>
                        <div class="text-xl font-black font-mono text-brandGray">{{ number_format($stats['total_members'] ?? 0) }}</div>
                        <div class="text-[8px] text-gray-400 mt-1">Verified Profiles</div>
                        <a href="{{ route('admin.membership.ledger') }}" class="text-[8px] font-black text-brandOrange mt-2 block hover:underline">View →</a>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow text-center">
                        <div class="text-2xl mb-1">🛡️</div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-tight mb-1">Rudra Sena</div>
                        <div class="text-xl font-black font-mono text-brandOrange">{{ number_format($stats['rudrasena_count'] ?? 0) }}</div>
                        <div class="text-[8px] text-gray-400 mt-1">Active Command Force</div>
                        <a href="{{ route('admin.rudrasena.index') }}" class="text-[8px] font-black text-brandOrange mt-2 block hover:underline">View →</a>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow text-center">
                        <div class="text-2xl mb-1">🪘</div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-tight mb-1">Kala Brundham</div>
                        <div class="text-xl font-black font-mono text-indigo-700">{{ number_format($stats['kala_brundam_count'] ?? 0) }}</div>
                        <div class="text-[8px] text-gray-400 mt-1">Cultural Artists</div>
                        <a href="{{ route('admin.local_gateways.index') }}" class="text-[8px] font-black text-brandOrange mt-2 block hover:underline">View →</a>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow text-center">
                        <div class="text-2xl mb-1">🌿</div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-tight mb-1">Grama Seva Dal</div>
                        <div class="text-xl font-black font-mono text-emerald-700">{{ number_format($stats['grama_seva_dal_count'] ?? 0) }}</div>
                        <div class="text-[8px] text-gray-400 mt-1">Village Charters</div>
                        <a href="{{ route('admin.local_gateways.index') }}" class="text-[8px] font-black text-brandOrange mt-2 block hover:underline">View →</a>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow text-center">
                        <div class="text-2xl mb-1">🌾</div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-tight mb-1">Organic Farmers</div>
                        <div class="text-xl font-black font-mono text-green-700">{{ number_format($stats['organic_farmers_count'] ?? 0) }}</div>
                        <div class="text-[8px] text-gray-400 mt-1">Nature Certified</div>
                        <a href="{{ route('admin.local_gateways.index') }}" class="text-[8px] font-black text-brandOrange mt-2 block hover:underline">View →</a>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow text-center">
                        <div class="text-2xl mb-1">🪔</div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-tight mb-1">Dharma Seva</div>
                        <div class="text-xl font-black font-mono text-amber-600">{{ $stats['active_campaigns'] ?? 0 }}</div>
                        <div class="text-[8px] text-gray-400 mt-1">Active Campaigns</div>
                        <a href="{{ route('admin.fundraising.index') }}" class="text-[8px] font-black text-brandOrange mt-2 block hover:underline">View →</a>
                    </div>
                </div>
            </div>

            <!-- ROW 3: PENDING ACTIONS + SYSTEM STATUS -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2">
                        <div class="h-4 w-1 bg-amber-500 rounded-full"></div>
                        <h3 class="text-[10px] font-black text-brandGray uppercase tracking-widest">Admin Attention — Pending Actions</h3>
                    </div>
                    <div class="divide-y divide-gray-50">
                        <div class="px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="text-xs text-gray-700 font-semibold">Volunteers awaiting approval</span>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-sm font-black font-mono {{ ($stats['pending_volunteers'] ?? 0) > 0 ? 'text-amber-600' : 'text-gray-400' }} min-w-[24px] text-right">{{ $stats['pending_volunteers'] ?? 0 }}</span>
                                <a href="{{ route('admin.volunteers.index') }}" class="text-[9px] font-black text-brandOrange border border-orange-200 bg-orange-50 hover:bg-brandOrange hover:text-white px-2 py-0.5 rounded transition uppercase">Review →</a>
                            </div>
                        </div>
                        <div class="px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="text-xs text-gray-700 font-semibold">Memberships awaiting review</span>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-sm font-black font-mono {{ ($stats['pending_memberships'] ?? 0) > 0 ? 'text-amber-600' : 'text-gray-400' }} min-w-[24px] text-right">{{ $stats['pending_memberships'] ?? 0 }}</span>
                                <a href="{{ route('admin.membership.pending') }}" class="text-[9px] font-black text-brandOrange border border-orange-200 bg-orange-50 hover:bg-brandOrange hover:text-white px-2 py-0.5 rounded transition uppercase">Review →</a>
                            </div>
                        </div>
                        <div class="px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="text-xs text-gray-700 font-semibold">Exam applications received</span>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-sm font-black font-mono text-blue-600 min-w-[24px] text-right">{{ $stats['total_exam_applications'] ?? 0 }}</span>
                                <a href="{{ route('admin.exams.index') }}" class="text-[9px] font-black text-brandOrange border border-orange-200 bg-orange-50 hover:bg-brandOrange hover:text-white px-2 py-0.5 rounded transition uppercase">Manage →</a>
                            </div>
                        </div>
                        <div class="px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="text-xs text-gray-700 font-semibold">Exam results published</span>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-sm font-black font-mono text-emerald-600 min-w-[24px] text-right">{{ $stats['published_results'] ?? 0 }}</span>
                                <a href="{{ route('admin.exams.index') }}" class="text-[9px] font-black text-brandOrange border border-orange-200 bg-orange-50 hover:bg-brandOrange hover:text-white px-2 py-0.5 rounded transition uppercase">View →</a>
                            </div>
                        </div>
                        <div class="px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition">
                            <span class="text-xs text-gray-700 font-semibold">Active fundraising campaigns</span>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-sm font-black font-mono text-amber-600 min-w-[24px] text-right">{{ $stats['active_campaigns'] ?? 0 }}</span>
                                <a href="{{ route('admin.fundraising.index') }}" class="text-[9px] font-black text-brandOrange border border-orange-200 bg-orange-50 hover:bg-brandOrange hover:text-white px-2 py-0.5 rounded transition uppercase">View →</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2">
                        <div class="h-4 w-1 bg-emerald-500 rounded-full"></div>
                        <h3 class="text-[10px] font-black text-brandGray uppercase tracking-widest">System Status</h3>
                    </div>
                    <div class="px-4 py-2 divide-y divide-gray-50">
                        @php
                            $dbOk = true;
                            try { \DB::connection()->getPdo(); } catch (\Exception $e) { $dbOk = false; }
                            $storageOk = is_writable(storage_path());
                        @endphp
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-xs font-semibold text-gray-600">Application</span>
                            <div class="flex items-center gap-2"><span class="text-[10px] font-bold text-gray-500">Running</span><span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span></div>
                        </div>
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-xs font-semibold text-gray-600">Database</span>
                            <div class="flex items-center gap-2"><span class="text-[10px] font-bold text-gray-500">{{ $dbOk ? 'Connected' : 'Error' }}</span><span class="w-2 h-2 rounded-full {{ $dbOk ? 'bg-emerald-500' : 'bg-red-500' }} shrink-0"></span></div>
                        </div>
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-xs font-semibold text-gray-600">Storage</span>
                            <div class="flex items-center gap-2"><span class="text-[10px] font-bold text-gray-500">{{ $storageOk ? 'Writable' : 'Check Permissions' }}</span><span class="w-2 h-2 rounded-full {{ $storageOk ? 'bg-emerald-500' : 'bg-amber-500' }} shrink-0"></span></div>
                        </div>
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-xs font-semibold text-gray-600">Total Records</span>
                            <div class="flex items-center gap-2"><span class="text-[10px] font-bold text-gray-500">{{ number_format(($stats['total_members'] ?? 0) + ($stats['total_volunteers'] ?? 0)) }} entries</span><span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span></div>
                        </div>
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-xs font-semibold text-gray-600">Total Exams</span>
                            <div class="flex items-center gap-2"><span class="text-[10px] font-bold text-gray-500">{{ $stats['total_exams'] ?? 0 }} configured</span><span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span></div>
                        </div>
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-xs font-semibold text-gray-600">Active Campaigns</span>
                            <div class="flex items-center gap-2"><span class="text-[10px] font-bold text-gray-500">{{ $stats['active_campaigns'] ?? 0 }} live</span><span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 4: EXAM + FUNDRAISING + CONTENT MINI PANELS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <span class="text-base">📝</span>
                        <h3 class="text-[10px] font-black text-brandGray uppercase tracking-widest">Examination Overview</h3>
                    </div>
                    <div class="px-4 py-2 space-y-1 text-xs">
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500 font-semibold">Total Exams</span><span class="font-black font-mono text-brandGray">{{ $stats['total_exams'] ?? 0 }}</span></div>
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500 font-semibold">Active Exams</span><span class="font-black font-mono text-emerald-600">{{ $stats['active_exams'] ?? 0 }}</span></div>
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500 font-semibold">Total Applications</span><span class="font-black font-mono text-blue-600">{{ $stats['total_exam_applications'] ?? 0 }}</span></div>
                        <div class="flex justify-between items-center py-1.5"><span class="text-gray-500 font-semibold">Results Published</span><span class="font-black font-mono text-brandOrange">{{ $stats['published_results'] ?? 0 }}</span></div>
                        <a href="{{ route('admin.exams.index') }}" class="block text-center bg-gray-900 hover:bg-brandOrange text-white text-[9px] font-black uppercase tracking-widest py-2 rounded-lg transition mt-2">Manage Exams →</a>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <span class="text-base">🪔</span>
                        <h3 class="text-[10px] font-black text-brandGray uppercase tracking-widest">Dharma Seva Fundraising</h3>
                    </div>
                    <div class="px-4 py-2 space-y-1 text-xs">
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500 font-semibold">Total Campaigns</span><span class="font-black font-mono text-brandGray">{{ $stats['total_campaigns'] ?? 0 }}</span></div>
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500 font-semibold">Active Campaigns</span><span class="font-black font-mono text-emerald-600">{{ $stats['active_campaigns'] ?? 0 }}</span></div>
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500 font-semibold">Total Donors</span><span class="font-black font-mono text-blue-600">{{ $stats['total_donors'] ?? 0 }}</span></div>
                        <div class="flex justify-between items-center py-1.5"><span class="text-gray-500 font-semibold">Amount Raised</span><span class="font-black font-mono text-amber-600">&#8377;{{ number_format($stats['total_funds_raised'] ?? 0) }}</span></div>
                        <a href="{{ route('admin.fundraising.index') }}" class="block text-center bg-gray-900 hover:bg-brandOrange text-white text-[9px] font-black uppercase tracking-widest py-2 rounded-lg transition mt-2">View Fundraising →</a>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                        <span class="text-base">📰</span>
                        <h3 class="text-[10px] font-black text-brandGray uppercase tracking-widest">Content Overview</h3>
                    </div>
                    <div class="px-4 py-2 space-y-1 text-xs">
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500 font-semibold">Total Blogs</span><span class="font-black font-mono text-brandGray">{{ $stats['total_blogs'] ?? 0 }}</span></div>
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500 font-semibold">Published Blogs</span><span class="font-black font-mono text-emerald-600">{{ $stats['published_blogs'] ?? 0 }}</span></div>
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-50"><span class="text-gray-500 font-semibold">Gallery Media</span><span class="font-black font-mono text-blue-600">{{ $stats['gallery_media'] ?? 0 }}</span></div>
                        @php try { $coreCount = \DB::table('our_supports')->count(); } catch (\Exception $e) { $coreCount = 0; } @endphp
                        <div class="flex justify-between items-center py-1.5"><span class="text-gray-500 font-semibold">Support Cores</span><span class="font-black font-mono text-brandOrange">{{ $coreCount }}</span></div>
                        <div class="flex gap-2 mt-2">
                            <a href="{{ route('admin.blogs.index') }}" class="flex-1 text-center bg-gray-900 hover:bg-brandOrange text-white text-[9px] font-black uppercase py-2 rounded-lg transition">Blogs →</a>
                            <a href="{{ route('admin.gallery.index') }}" class="flex-1 text-center bg-gray-900 hover:bg-brandOrange text-white text-[9px] font-black uppercase py-2 rounded-lg transition">Gallery →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 5: RECENT ACTIVITY + QUICK ACTIONS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2">
                        <div class="h-4 w-1 bg-blue-500 rounded-full"></div>
                        <h3 class="text-[10px] font-black text-brandGray uppercase tracking-widest">Recent System Activity</h3>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @if($recentActivity->isNotEmpty())
                            @foreach($recentActivity as $log)
                                <div class="px-4 py-2.5 flex items-start gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brandOrange mt-1.5 shrink-0"></span>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[10px] font-black text-gray-700 uppercase tracking-wide truncate">{{ str_replace('_', ' ', $log->action) }}</div>
                                        @if($log->actor_identifier || $log->target_type)
                                            <div class="text-[9px] text-gray-400 mt-0.5">
                                                @if($log->actor_identifier)
                                                    <span class="font-semibold">{{ $log->actor_identifier }}</span>
                                                @endif
                                                @if($log->target_type)
                                                    &middot; {{ $log->target_type }}
                                                    @if($log->target_id)
                                                        #{{ $log->target_id }}
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-[9px] text-gray-400 font-mono shrink-0">{{ \Carbon\Carbon::parse($log->created_at)->format('d-M H:i') }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="px-4 py-8 text-center">
                                <span class="text-2xl block mb-1">📋</span>
                                <p class="text-[11px] text-gray-400 font-semibold">No recent activity records found.</p>
                                <p class="text-[10px] text-gray-300">Activity will appear here as admin actions are performed.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2">
                        <div class="h-4 w-1 bg-brandOrange rounded-full"></div>
                        <h3 class="text-[10px] font-black text-brandGray uppercase tracking-widest">Quick Actions</h3>
                    </div>
                    <div class="p-3 space-y-2">
                        <a href="{{ route('admin.membership.pending') }}" class="flex items-center gap-2 w-full px-3 py-2.5 bg-gray-50 hover:bg-brandOrange hover:text-white border border-gray-200 rounded-lg transition text-[10px] font-black text-gray-700 uppercase tracking-wide"><span>⏳</span> Review Memberships</a>
                        <a href="{{ route('admin.volunteers.index') }}" class="flex items-center gap-2 w-full px-3 py-2.5 bg-gray-50 hover:bg-brandOrange hover:text-white border border-gray-200 rounded-lg transition text-[10px] font-black text-gray-700 uppercase tracking-wide"><span>🤝</span> Review Volunteers</a>
                        <a href="{{ route('admin.exams.create') }}" class="flex items-center gap-2 w-full px-3 py-2.5 bg-gray-50 hover:bg-brandOrange hover:text-white border border-gray-200 rounded-lg transition text-[10px] font-black text-gray-700 uppercase tracking-wide"><span>📝</span> Add New Exam</a>
                        <a href="{{ route('admin.fundraising.create') }}" class="flex items-center gap-2 w-full px-3 py-2.5 bg-gray-50 hover:bg-brandOrange hover:text-white border border-gray-200 rounded-lg transition text-[10px] font-black text-gray-700 uppercase tracking-wide"><span>🪔</span> New Campaign</a>
                        <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-2 w-full px-3 py-2.5 bg-gray-50 hover:bg-brandOrange hover:text-white border border-gray-200 rounded-lg transition text-[10px] font-black text-gray-700 uppercase tracking-wide"><span>🖼️</span> Upload Media</a>
                        <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-2 w-full px-3 py-2.5 bg-gray-50 hover:bg-brandOrange hover:text-white border border-gray-200 rounded-lg transition text-[10px] font-black text-gray-700 uppercase tracking-wide"><span>📰</span> Manage Blogs</a>
                        <a href="{{ route('admin.rudrasena.index') }}" class="flex items-center gap-2 w-full px-3 py-2.5 bg-gray-50 hover:bg-brandOrange hover:text-white border border-gray-200 rounded-lg transition text-[10px] font-black text-gray-700 uppercase tracking-wide"><span>🔱</span> Rudra Sena Roster</a>
                        <a href="{{ route('admin.banner.index') }}" class="flex items-center gap-2 w-full px-3 py-2.5 bg-gray-50 hover:bg-brandOrange hover:text-white border border-gray-200 rounded-lg transition text-[10px] font-black text-gray-700 uppercase tracking-wide"><span>🚩</span> Page Banners</a>
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 w-full px-3 py-2.5 bg-gray-900 hover:bg-brandOrange text-white border border-gray-800 rounded-lg transition text-[10px] font-black uppercase tracking-wide"><span>⚙️</span> Site Settings</a>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>
@endsection