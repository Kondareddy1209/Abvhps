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
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
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
            <a href="{{ route('admin.rudrasena.index') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Rudrasena Dal Roster</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- Page Header with Title & Breadcrumb -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <div>
                    <h2 class="text-xl font-black text-brandGray tracking-tight">Rudrasena Member Roster</h2>
                    <p class="text-xs text-gray-400 font-semibold mt-0.5">Home - Rudrasena</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-gray-200 text-gray-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                        Total Enrolled: {{ $members->total() }}
                    </span>
                </div>
            </div>

            <!-- Flash Status Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-xs font-bold shadow-sm flex items-center gap-2">
                    <span class="text-base">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-xs font-bold shadow-sm flex items-center gap-2">
                    <span class="text-base">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Search Toolbar Matrix -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <form action="{{ route('admin.rudrasena.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange" placeholder="Search Rudrasena (Name, Member ID, Rudrasena ID, Mobile, Volunteer Type, Cadre)..." value="{{ $searchQuery ?? '' }}">
                    <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[11px] px-6 py-2 rounded-lg shadow-sm uppercase tracking-wide transition">
                        Search Rudrasena
                    </button>
                    @if(!empty($searchQuery))
                        <a href="{{ route('admin.rudrasena.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-black text-[11px] px-4 py-2 rounded-lg uppercase tracking-wide transition border border-gray-300 flex items-center">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Central Rudrasena Table Grid -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-xs font-semibold text-gray-700">
                        <thead class="bg-gray-100 text-[11px] font-black uppercase text-gray-600 tracking-wider text-center">
                            <tr>
                                <th class="px-4 py-3.5">S.NO</th>
                                <th class="px-6 py-3.5 text-left">MEMBER NAME</th>
                                <th class="px-5 py-3.5 text-left">CONTACT INFO</th>
                                <th class="px-4 py-3.5">VOLUNTEER TYPE</th>
                                <th class="px-4 py-3.5">STATUS</th>
                                <th class="px-4 py-3.5">CADRE & LOCALITY</th>
                                <th class="px-3 py-3.5">VIEW</th>
                                <th class="px-3 py-3.5">CADDER</th>
                                <th class="px-3 py-3.5">ID CODE</th>
                                <th class="px-3 py-3.5">DELETE</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white text-center">
                            @forelse($members as $index => $member)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    
                                    <!-- 1. S.NO -->
                                    <td class="px-4 py-4 text-gray-500 font-mono">
                                        {{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}
                                    </td>

                                    <!-- 2. NAME -->
                                    <td class="px-6 py-4 text-left">
                                        <div class="font-black text-gray-900 uppercase text-xs">
                                            {{ $member->full_name }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 font-mono mt-0.5">
                                            @if($member->rudrasena_id)
                                                <span class="text-brandOrange font-bold">RUDRASENA ID: {{ $member->rudrasena_id }}</span> | 
                                            @endif
                                            <span>MEMBER: {{ implode(' ', str_split($member->membership_id, 4)) }}</span>
                                        </div>
                                    </td>

                                    <!-- 3. CONTACT -->
                                    <td class="px-5 py-4 text-left">
                                        <div class="font-mono text-gray-900 font-bold text-xs">
                                            {{ $member->mobile }}
                                        </div>
                                        <div class="text-[10px] text-gray-500 font-mono truncate max-w-[140px]" title="{{ $member->email }}">
                                            {{ $member->email }}
                                        </div>
                                    </td>

                                    <!-- 4. VOLUNTEER TYPE -->
                                    <td class="px-4 py-4">
                                        <span class="bg-blue-50 text-blue-700 text-[10px] font-black px-2.5 py-1 rounded border border-blue-200 uppercase tracking-wide">
                                            {{ $member->volunteer_type ?? 'Standard' }}
                                        </span>
                                    </td>

                                    <!-- 5. STATUS -->
                                    <td class="px-4 py-4">
                                        @if($member->status === 'verified')
                                            <span class="bg-emerald-100 text-emerald-800 text-[9px] font-black px-2.5 py-1 rounded border border-emerald-200 uppercase tracking-wider">
                                                ✓ VERIFIED
                                            </span>
                                        @elseif($member->status === 'rejected')
                                            <span class="bg-rose-100 text-rose-800 text-[9px] font-black px-2.5 py-1 rounded border border-rose-200 uppercase tracking-wider">
                                                ✕ REJECTED
                                            </span>
                                        @else
                                            <span class="bg-amber-100 text-amber-800 text-[9px] font-black px-2.5 py-1 rounded border border-amber-200 uppercase tracking-wider">
                                                ⏳ PENDING
                                            </span>
                                        @endif
                                    </td>

                                    <!-- 6. CADRE & LOCALITY -->
                                    <td class="px-4 py-4 text-left">
                                        <div class="text-[11px] font-bold text-gray-800">
                                            {{ $member->assigned_cadder ?: 'Not Assigned' }}
                                        </div>
                                        <div class="text-[10px] text-gray-500 font-semibold">
                                            📍 {{ $member->assigned_locality ?: 'HQ' }}
                                        </div>
                                    </td>

                                    <!-- 7. VIEW -->
                                    <td class="px-2 py-4">
                                        <a href="{{ route('admin.rudrasena.view', $member->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-black text-[9px] px-3 py-1.5 rounded shadow-sm uppercase transition inline-block text-center">
                                            View
                                        </a>
                                    </td>

                                    <!-- 8. CADDER (Update) -->
                                    <td class="px-2 py-4">
                                        <a href="{{ route('admin.rudrasena.edit', $member->id) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-black text-[9px] px-3 py-1.5 rounded shadow-sm uppercase transition inline-block text-center">
                                            Update
                                        </a>
                                    </td>

                                    <!-- 9. ID CODE & CARD -->
                                    <td class="px-2 py-4">
                                        <a href="{{ route('admin.rudrasena.view_card', $member->id) }}" target="_blank" class="{{ $member->status === 'verified' ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-amber-500 hover:bg-amber-600' }} text-white font-black text-[9px] px-3 py-1.5 rounded shadow-sm uppercase transition inline-block text-center whitespace-nowrap" title="View / Print Rudrasena ID Card">
                                            @if($member->status === 'verified' && !empty($member->rudrasena_id))
                                                {{ $member->rudrasena_id }}
                                            @else
                                                ID Card
                                            @endif
                                        </a>
                                    </td>

                                    <!-- 10. DELETE -->
                                    <td class="px-2 py-4">
                                        <form action="{{ route('admin.rudrasena.delete', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Rudrasena registration permanently?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-black text-[9px] px-3 py-1.5 rounded shadow-sm uppercase transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-12 text-center font-bold text-gray-400 uppercase tracking-wider">
                                        <span class="text-2xl block mb-1">🔱</span>
                                        No Rudrasena Dal application records found in the roster.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Grid Node -->
            @if($members->hasPages())
                <div class="p-4 bg-white rounded-xl border border-gray-200 flex justify-center shadow-sm">
                    {{ $members->appends(['search' => $searchQuery])->links() }}
                </div>
            @endif

        </main>
    </div>
</div>
@endsection
