@extends('layouts.app')

@section('title', 'Page-Wise Banner Management | ABVHPS Central Board')

@section('content')
<div class="min-h-screen bg-gray-100/60 flex flex-col md:flex-row select-none">
    
    <!-- BLOCK 1: MASTER ADMINISTRATIVE LEFT SIDEBAR CONTROLLER -->
    <div class="w-full md:w-64 bg-brandDarkGray text-white flex flex-col border-r-4 border-brandOrange shrink-0 shadow-xl">
        <div class="p-5 text-center bg-gray-900 border-b border-gray-800">
            <span class="text-3xl block mb-1 drop-shadow-md">👑</span>
            <h2 class="text-xs font-black tracking-widest text-brandOrange uppercase">ABVHPS CENTRAL BOARD</h2>
            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Master Control Panel Desk</p>
        </div>
        
        <!-- 16 Core Navigation Matrix Link Nodes -->
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
            <a href="{{ route('admin.rudrasena.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🔱</span> 9. RUDRASENA MATRIX
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
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>⚙️</span> 15. SITE GLOBAL SETTINGS
            </a>
            <a href="{{ route('admin.banner.index') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
                <span>🚩</span> 16. BANNER MANAGEMENT
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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">16. Page-Wise Banner Management</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- Header Title and Add Button Node -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h3 class="text-xs font-black text-brandGray uppercase tracking-wider flex items-center gap-1.5">
                        🚩 Section 16: Page-Specific Website Banners Desk
                    </h3>
                    <p class="text-[10px] text-gray-500 mt-0.5">Assign desktop & mobile responsive banners to specific website pages.</p>
                </div>
                <a href="{{ route('admin.banner.create') }}" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[10px] px-4 py-2 rounded-lg shadow-sm uppercase tracking-wide transition flex items-center gap-1.5 shrink-0">
                    <span>+</span> Add Banner
                </a>
            </div>

            <!-- Success / Alert Block -->
            @if(session('success'))
                <div class="p-3 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl text-xs font-bold flex items-center justify-between shadow-sm">
                    <span>✓ {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 font-black text-sm hover:text-emerald-800">&times;</button>
                </div>
            @endif

            <!-- KPI Metric Summary Tiles -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block">Total Banners</span>
                    <span class="text-2xl font-black font-mono text-gray-900 mt-1 block">{{ $stats['total_banners'] ?? 0 }}</span>
                </div>
                <div class="bg-white border border-emerald-200 rounded-xl p-4 shadow-sm bg-emerald-50/20">
                    <span class="text-[9px] font-black text-emerald-700 uppercase tracking-widest block">Active / Visible</span>
                    <span class="text-2xl font-black font-mono text-emerald-800 mt-1 block">{{ $stats['active_banners'] ?? 0 }}</span>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block">Hidden / Inactive</span>
                    <span class="text-2xl font-black font-mono text-gray-500 mt-1 block">{{ $stats['hidden_banners'] ?? 0 }}</span>
                </div>
                <div class="bg-white border border-orange-200 rounded-xl p-4 shadow-sm bg-orange-50/20">
                    <span class="text-[9px] font-black text-brandOrange uppercase tracking-widest block">Pages Configured</span>
                    <span class="text-2xl font-black font-mono text-orange-700 mt-1 block">{{ $stats['pages_covered'] ?? 0 }}</span>
                </div>
            </div>

            <!-- Search & Page Filter Controls -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <form action="{{ route('admin.banner.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                    
                    <!-- Page Selector Filter -->
                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-[9px] font-black uppercase text-gray-500 mb-1 tracking-wider">Filter By Page</label>
                        <select name="page" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange bg-white" onchange="this.form.submit()">
                            <option value="all" {{ empty($selectedPage) || $selectedPage === 'all' ? 'selected' : '' }}>-- All Pages ({{ count($pages) }} Available) --</option>
                            @foreach($pages as $pKey => $pLabel)
                                <option value="{{ $pKey }}" {{ ($selectedPage ?? '') === $pKey ? 'selected' : '' }}>
                                    {{ $pLabel }} ({{ $pKey }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="w-36">
                        <label class="block text-[9px] font-black uppercase text-gray-500 mb-1 tracking-wider">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange bg-white" onchange="this.form.submit()">
                            <option value="all" {{ empty($statusFilter) || $statusFilter === 'all' ? 'selected' : '' }}>All Statuses</option>
                            <option value="show" {{ ($statusFilter ?? '') === 'show' ? 'selected' : '' }}>Show (Active)</option>
                            <option value="hide" {{ ($statusFilter ?? '') === 'hide' ? 'selected' : '' }}>Hide (Inactive)</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[9px] font-black uppercase text-gray-500 mb-1 tracking-wider">Search Banner</label>
                        <input type="text" name="search" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange" placeholder="Search by page, title, or ID..." value="{{ $searchToken ?? '' }}">
                    </div>

                    <!-- Search & Reset Buttons -->
                    <div class="flex items-end gap-2 pt-4">
                        <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[10px] px-4 py-2.5 rounded-lg shadow-sm uppercase tracking-wide transition">
                            Search
                        </button>
                        @if(!empty($selectedPage) || !empty($searchToken) || !empty($statusFilter))
                            <a href="{{ route('admin.banner.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-[10px] px-3 py-2.5 rounded-lg uppercase tracking-wide transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Central Banner Ledger Table Grid -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-xs font-semibold text-gray-700">
                        <thead class="bg-gray-100 text-[10px] font-black uppercase text-gray-600 tracking-wider text-center">
                            <tr>
                                <th class="px-4 py-3">S.NO</th>
                                <th class="px-6 py-3 text-left">PAGE</th>
                                <th class="px-6 py-3">MOBILE BANNER</th>
                                <th class="px-6 py-3">DESKTOP BANNER</th>
                                <th class="px-6 py-3">STATUS</th>
                                <th class="px-4 py-3">EDIT</th>
                                <th class="px-4 py-3">DESTROY</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white text-center">
                            @forelse($banners as $index => $banner)
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    
                                    <!-- S.NO -->
                                    <td class="px-4 py-3.5 text-gray-500 font-mono">
                                        {{ $banners->firstItem() ? $banners->firstItem() + $index : $index + 1 }}
                                    </td>

                                    <!-- PAGE -->
                                    <td class="px-6 py-3.5 text-left">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-brandOrange shrink-0"></span>
                                            <div>
                                                <div class="font-black text-gray-900 uppercase tracking-wide">
                                                    {{ $banner->page_name ?? \App\Models\Banner::resolvePageName($banner->page_key) }}
                                                </div>
                                                <div class="text-[10px] font-mono text-gray-400">
                                                    slug: <span class="text-brandOrange font-bold">{{ $banner->page_key }}</span>
                                                    @if($banner->title)
                                                        &middot; {{ Str::limit($banner->title, 25) }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- MOBILE BANNER -->
                                    <td class="px-6 py-3.5">
                                        @if(!empty($banner->mobile_banner))
                                            <div class="inline-block relative group">
                                                <img src="{{ asset('storage/' . $banner->mobile_banner) }}" class="w-16 h-12 rounded-lg border border-gray-200 object-cover mx-auto shadow-sm group-hover:scale-105 transition" alt="Mobile Banner">
                                                <span class="block text-[8px] text-gray-400 font-mono mt-0.5">Mobile File</span>
                                            </div>
                                        @else
                                            <div class="inline-block">
                                                <div class="w-16 h-12 rounded-lg bg-gray-100 border border-dashed border-gray-300 flex items-center justify-center text-gray-400 text-[8px] font-bold mx-auto">
                                                    Auto-Fallback
                                                </div>
                                                <span class="block text-[8px] text-gray-400 mt-0.5">Uses Desktop</span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- DESKTOP BANNER -->
                                    <td class="px-6 py-3.5">
                                        @if(!empty($banner->desktop_banner))
                                            <div class="inline-block relative group">
                                                <img src="{{ asset('storage/' . $banner->desktop_banner) }}" class="w-24 h-12 rounded-lg border border-gray-200 object-cover mx-auto shadow-sm group-hover:scale-105 transition" alt="Desktop Banner">
                                                <span class="block text-[8px] text-gray-400 font-mono mt-0.5">Desktop File</span>
                                            </div>
                                        @else
                                            <div class="w-24 h-12 rounded-lg bg-gray-100 border flex items-center justify-center text-gray-400 text-[9px] mx-auto">
                                                No Image
                                            </div>
                                        @endif
                                    </td>

                                    <!-- STATUS -->
                                    <td class="px-6 py-3.5">
                                        <form action="{{ route('admin.banner.toggle', $banner->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @if($banner->status === 'show' || $banner->status === 'Show' || $banner->status === 'active')
                                                <button type="submit" title="Click to toggle status" class="bg-green-50 hover:bg-green-100 text-green-700 text-[9px] font-black px-3 py-1 rounded-full border border-green-200 uppercase tracking-wider transition cursor-pointer flex items-center gap-1 mx-auto">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Show
                                                </button>
                                            @else
                                                <button type="submit" title="Click to toggle status" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-[9px] font-black px-3 py-1 rounded-full border border-gray-300 uppercase tracking-wider transition cursor-pointer flex items-center gap-1 mx-auto">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Hide
                                                </button>
                                            @endif
                                        </form>
                                    </td>

                                    <!-- EDIT -->
                                    <td class="px-4 py-3.5">
                                        <a href="{{ route('admin.banner.edit', $banner->id) }}" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[9px] px-3 py-1.5 rounded-lg shadow-sm uppercase tracking-wider transition inline-block">
                                            Edit
                                        </a>
                                    </td>

                                    <!-- DESTROY -->
                                    <td class="px-4 py-3.5">
                                        <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this banner for \'{{ $banner->page_name ?? $banner->page_key }}\'?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-black text-[9px] px-3 py-1.5 rounded-lg shadow-sm uppercase tracking-wider transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <span class="text-3xl block mb-2">🚩</span>
                                        <p class="font-bold text-gray-500 uppercase tracking-wider text-xs">No banners found matching the criteria.</p>
                                        <p class="text-[10px] text-gray-400 mt-1">Click "+ Add Banner" above to create and assign your first page banner.</p>
                                        <div class="mt-4">
                                            <a href="{{ route('admin.banner.create') }}" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[10px] px-4 py-2 rounded-lg uppercase tracking-wider transition inline-block">
                                                + Add New Page Banner
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($banners->hasPages())
                    <div class="p-4 bg-gray-50 border-t border-gray-200">
                        {{ $banners->links() }}
                    </div>
                @endif
            </div>

        </main> <!-- END WORKSPACE CONTAINER -->
    </div> <!-- END MAIN WORKSPACE VIEWPORT DESK -->
</div> <!-- END MIN-H-SCREEN CONTAINER -->
@endsection
