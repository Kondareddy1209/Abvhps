@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100/60 flex flex-col md:flex-row select-none">
    
    <!-- BLOCK 1: MASTER ADMINISTRATIVE LEFT SIDEBAR -->
    @include('admin.partials.sidebar')

    <!-- BLOCK 2: MASTER MAIN WORKSPACE VIEWPORT DESK -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Workspace Top Status Banner Navbar -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                @include('admin.partials.header_button')
                <span class="text-sm font-black text-brandGray uppercase tracking-wider">System View:</span>
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Volunteer Desk</span>
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
                    <h2 class="text-xl font-black text-brandGray tracking-tight">Volunteer List</h2>
                    <p class="text-xs text-gray-400 font-semibold mt-0.5">Home - Volunteer</p>
                </div>
                <div class="flex items-center gap-2">
                    <span id="volunteer_sync_indicator" class="flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-200 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span id="volunteer_sync_text">Live Sync</span>
                    </span>
                    <span class="bg-gray-200 text-gray-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                        Total Records: <span id="volunteer_total_count">{{ $volunteers->total() }}</span>
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
                <form action="{{ route('admin.volunteers.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange" placeholder="Search Volunteer (Name, Member ID, Volunteer ID, Phone, Email)..." value="{{ $searchQuery ?? '' }}">
                    <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[11px] px-6 py-2 rounded-lg shadow-sm uppercase tracking-wide transition">
                        Search Volunteer
                    </button>
                    @if(!empty($searchQuery))
                        <a href="{{ route('admin.volunteers.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-black text-[11px] px-4 py-2 rounded-lg uppercase tracking-wide transition border border-gray-300 flex items-center">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Central Volunteer Table Grid -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-xs font-semibold text-gray-700">
                        <thead class="bg-gray-100 text-[11px] font-black uppercase text-gray-600 tracking-wider text-center">
                            <tr>
                                <th class="px-4 py-3.5">S.NO</th>
                                <th class="px-6 py-3.5 text-left">NAME</th>
                                <th class="px-6 py-3.5 text-left">CONTACT</th>
                                <th class="px-3 py-3.5">VIEW</th>
                                <th class="px-3 py-3.5">EDIT</th>
                                <th class="px-3 py-3.5">CADDER</th>
                                <th class="px-3 py-3.5">ID</th>
                                <th class="px-3 py-3.5">DELETE</th>
                            </tr>
                        </thead>
                        <tbody id="volunteer_table_body" class="divide-y divide-gray-200 bg-white text-center">
                            @include('admin.partials.volunteer_table_rows')
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Grid Node -->
            <div id="volunteer_pagination_container" class="{{ $volunteers->hasPages() ? '' : 'hidden' }} p-4 bg-white rounded-xl border border-gray-200 flex justify-center shadow-sm">
                @if($volunteers->hasPages())
                    {{ $volunteers->appends(['search' => $searchQuery])->links() }}
                @endif
            </div>

        </main>
    </div>
</div>

<!-- Dynamic Live Synchronization Engine -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('volunteer_table_body');
    const totalCountEl = document.getElementById('volunteer_total_count');
    const syncIndicator = document.getElementById('volunteer_sync_indicator');
    const syncText = document.getElementById('volunteer_sync_text');
    const paginationContainer = document.getElementById('volunteer_pagination_container');

    if (!tableBody) return;

    let currentSignature = "{{ $initialSignature ?? '' }}";
    let isFetching = false;
    const pollInterval = 6000; // 6 seconds
    let timer = null;
    let consecutiveFailures = 0;

    function getQueryParams() {
        const params = new URLSearchParams(window.location.search);
        return params.toString();
    }

    async function checkLiveUpdates() {
        if (isFetching || document.hidden) return;

        isFetching = true;
        const query = getQueryParams();
        const url = `{{ route('admin.volunteers.live') }}${query ? '?' + query : ''}`;

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.status === 401 || response.status === 419) {
                if (syncIndicator && syncText) {
                    syncIndicator.className = 'flex items-center gap-1.5 bg-amber-50 text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-amber-200 shadow-sm';
                    syncText.textContent = 'Session Expired';
                }
                if (timer) clearInterval(timer);
                return;
            }

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const data = await response.json();
            consecutiveFailures = 0;

            if (data && data.success) {
                if (totalCountEl && data.total !== undefined) {
                    totalCountEl.textContent = data.total;
                }

                // If dataset signature changed, update rows and pagination smoothly
                if (data.signature && data.signature !== currentSignature) {
                    currentSignature = data.signature;
                    tableBody.innerHTML = data.html;

                    if (paginationContainer) {
                        if (data.has_pages && data.pagination_html) {
                            paginationContainer.innerHTML = data.pagination_html;
                            paginationContainer.classList.remove('hidden');
                        } else {
                            paginationContainer.innerHTML = '';
                            paginationContainer.classList.add('hidden');
                        }
                    }
                }

                if (syncIndicator && syncText) {
                    syncIndicator.className = 'flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-200 shadow-sm';
                    syncText.textContent = `Live (${data.synced_at})`;
                }
            }
        } catch (error) {
            consecutiveFailures++;
            if (syncIndicator && syncText) {
                if (consecutiveFailures > 2) {
                    syncIndicator.className = 'flex items-center gap-1.5 bg-rose-50 text-rose-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-rose-200 shadow-sm';
                    syncText.textContent = 'Sync Retrying...';
                }
            }
        } finally {
            isFetching = false;
        }
    }

    timer = setInterval(checkLiveUpdates, pollInterval);

    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            checkLiveUpdates();
        }
    });
});
</script>
@endsection
