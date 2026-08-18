<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundraising Matrices & Campaigns Desk | ABVHPS Central Board</title>
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
            <div class="w-10 h-10 rounded-full bg-brandOrange text-white flex items-center justify-center font-black text-xs shadow-md">
                👑
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
            <a href="{{ route('admin.fundraising.index') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
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

    <!-- BLOCK 2: WORKSPACE -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <span class="text-sm font-black text-brandGray uppercase tracking-wider">Module:</span>
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">12. Multi-Campaign Fundraising Matrices</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('donations.grid') }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-black px-3 py-1.5 rounded-lg border border-gray-300 uppercase transition flex items-center gap-1">
                    <span>🌐</span> Public Campaign Grid
                </a>
                <a href="{{ route('admin.fundraising.create') }}" class="bg-brandOrange hover:bg-orange-700 text-white text-xs font-black px-4 py-1.5 rounded-lg shadow-sm uppercase tracking-wide transition flex items-center gap-1">
                    <span>➕</span> Deploy New Campaign
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            @if(session('success'))
                <div class="p-3 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-bold flex items-center justify-between">
                    <span>✓ {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 font-black">×</button>
                </div>
            @endif

            <!-- KPI Counters Matrix (4 Cards) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Total Campaign Target</span>
                    <span class="text-xl font-black font-mono text-gray-900 mt-1 block">₹{{ number_format($stats['total_target'], 2) }}</span>
                </div>
                <div class="bg-white border border-emerald-200 rounded-xl p-4 shadow-sm bg-emerald-50/20">
                    <span class="text-[10px] font-black text-emerald-700 uppercase tracking-wider block">Total Amount Raised</span>
                    <span class="text-xl font-black font-mono text-emerald-700 mt-1 block">₹{{ number_format($stats['total_raised'], 2) }}</span>
                    <span class="text-[10px] font-bold text-gray-500 mt-0.5 block">{{ $stats['overall_progress'] }}% Overall Target Fulfilled</span>
                </div>
                <div class="bg-white border border-blue-200 rounded-xl p-4 shadow-sm bg-blue-50/20">
                    <span class="text-[10px] font-black text-blue-700 uppercase tracking-wider block">Active / Expired Campaigns</span>
                    <span class="text-xl font-black font-mono text-blue-800 mt-1 block">{{ $stats['active_campaigns'] }} / {{ $stats['expired_campaigns'] }}</span>
                </div>
                <div class="bg-white border border-amber-200 rounded-xl p-4 shadow-sm bg-amber-50/20">
                    <span class="text-[10px] font-black text-amber-700 uppercase tracking-wider block">Devotee Contributions Ledger</span>
                    <span class="text-xl font-black font-mono text-amber-800 mt-1 block">₹{{ number_format($stats['total_devotee_donations'], 2) }}</span>
                    <span class="text-[10px] font-bold text-gray-500 mt-0.5 block">{{ $stats['donor_count'] }} Devotee Receipts</span>
                </div>
            </div>

            <!-- Campaigns Table -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <h3 class="font-black text-xs text-gray-700 uppercase tracking-wider">
                        Campaign Matrices & Financial Progress Analytics
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-400 font-black uppercase text-[10px] tracking-wider">
                                <th class="p-3.5">Campaign Title</th>
                                <th class="p-3.5">Target Amount</th>
                                <th class="p-3.5">Amount Raised</th>
                                <th class="p-3.5" style="width: 180px;">Progress Fulfillment</th>
                                <th class="p-3.5">End Date</th>
                                <th class="p-3.5 text-center">Status</th>
                                <th class="p-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 font-medium">
                            @forelse($campaigns as $camp)
                                <tr class="hover:bg-orange-50/30 transition">
                                    <td class="p-3.5">
                                        <div class="font-bold text-gray-900 uppercase">{{ $camp->title }}</div>
                                        <div class="text-[10px] text-gray-400 truncate max-w-[220px]">{{ $camp->description }}</div>
                                    </td>
                                    <td class="p-3.5 font-mono font-bold text-gray-800">
                                        ₹{{ number_format($camp->target_amount, 2) }}
                                    </td>
                                    <td class="p-3.5 font-mono font-black text-emerald-700">
                                        ₹{{ number_format($camp->raised_amount, 2) }}
                                    </td>
                                    <td class="p-3.5">
                                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden mb-1">
                                            <div class="bg-brandOrange h-2 rounded-full" style="width: {{ $camp->progress_percent }}%;"></div>
                                        </div>
                                        <div class="text-[10px] font-mono font-bold text-gray-500">
                                            {{ $camp->progress_percent }}% Achieved
                                        </div>
                                    </td>
                                    <td class="p-3.5 font-mono text-gray-600">
                                        {{ \Carbon\Carbon::parse($camp->end_date)->format('d-M-Y') }}
                                    </td>
                                    <td class="p-3.5 text-center">
                                        @if($camp->status === 'active')
                                            <span class="bg-emerald-100 text-emerald-800 text-[9px] font-black px-2.5 py-1 rounded border border-emerald-200 uppercase">
                                                Active
                                            </span>
                                        @else
                                            <span class="bg-gray-200 text-gray-700 text-[9px] font-black px-2.5 py-1 rounded border border-gray-300 uppercase">
                                                Expired
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-right space-x-1.5 whitespace-nowrap">
                                        <form action="{{ route('admin.fundraising.toggle', $camp->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-[9px] font-black px-2.5 py-1.5 rounded border border-gray-300 uppercase transition">
                                                {{ $camp->status === 'active' ? 'Mark Expired' : 'Mark Active' }}
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.fundraising.edit', $camp->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-[9px] font-black px-2.5 py-1.5 rounded uppercase shadow-sm transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.fundraising.delete', $camp->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this campaign?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-[9px] font-black px-2 py-1.5 rounded uppercase shadow-sm transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-400">
                                        No fundraising campaigns deployed yet. Click "Deploy New Campaign" to launch one.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
