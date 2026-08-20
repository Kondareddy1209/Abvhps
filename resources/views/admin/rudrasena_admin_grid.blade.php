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
                                        <div class="w-10 h-10 rounded-full overflow-hidden bg-white border border-gray-300 mx-auto flex items-center justify-center p-0.5 mb-1">
                                            <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
                                        </div>
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
