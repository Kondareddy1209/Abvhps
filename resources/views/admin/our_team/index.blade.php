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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Leaders Roster</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- Header Title Node -->
            <div class="flex justify-between items-center">
                <h3 class="text-xs font-black text-brandGray uppercase tracking-wider flex items-center gap-1.5">
                    👥 Global Cadre Hierarchy Leadership Matrix
                </h3>
                <a href="{{ route('admin.team.create') }}" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[10px] px-4 py-2 rounded-lg shadow-sm uppercase tracking-wide transition">
                    + Add New Leader
                </a>

            </div>

            <!-- Dynamic Search and Multi-Level Filter Channels Desk -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <form action="{{ route('admin.team.index') }}" method="GET" class="row g-3 flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <input type="text" name="search" class="w-100 border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange" placeholder="Search by Name, Designation, Locality, or ID..." value="{{ $searchToken ?? '' }}">
                    </div>
                    <div class="w-full md:w-64">
                        <select name="cadre_level" class="w-100 border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange bg-white">
                            <option value="">-- All Hierarchy Levels --</option>
                            <option value="grama_panchayat" {{ ($cadreFilter ?? '') == 'grama_panchayat' ? 'selected' : '' }}>Grama Panchayat Level</option>
                            <option value="mandal_level" {{ ($cadreFilter ?? '') == 'mandal_level' ? 'selected' : '' }}>Mandal Level Committee</option>
                            <option value="assembly_segment" {{ ($cadreFilter ?? '') == 'assembly_segment' ? 'selected' : '' }}>Assembly Segment Team</option>
                            <option value="district_level" {{ ($cadreFilter ?? '') == 'district_level' ? 'selected' : '' }}>District Level Committee</option>
                            <option value="state_level" {{ ($cadreFilter ?? '') == 'state_level' ? 'selected' : '' }}>State Level Committee</option>
                            <option value="national_level" {{ ($cadreFilter ?? '') == 'national_level' ? 'selected' : '' }}>National Level Committee</option>
                            <option value="international_level" {{ ($cadreFilter ?? '') == 'international_level' ? 'selected' : '' }}>International Level Wing</option>
                        </select>
                    </div>
                    <div class="w-full md:w-32">
                        <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[11px] w-full py-2 rounded-lg shadow-sm uppercase tracking-wide transition">
                            Filter Grid
                        </button>
                    </div>
                </form>
            </div>
            <!-- Central Leadership Ledger Table Grid -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-xs font-semibold text-gray-700">
                        <thead class="bg-gray-100 text-[10px] font-black uppercase text-gray-600 tracking-wider text-center">
                            <tr>
                                <th class="px-4 py-3">S.No</th>
                                <th class="px-6 py-3 text-left">Leader Account Profile</th>
                                <th class="px-6 py-3 text-left">Designation & Rank</th>
                                <th class="px-6 py-3">Hierarchy Cadre</th>
                                <th class="px-6 py-3">Jurisdiction Locality</th>
                                <th class="px-4 py-3">QR Link</th>
                                <th class="px-4 py-3">Edit</th>
                                <th class="px-4 py-3">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white text-center">
                            @forelse($teamMembers as $index => $member)
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="px-4 py-3.5 text-gray-500 font-mono">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-3.5 text-left font-bold text-gray-900 uppercase tracking-wide flex items-center gap-3">
                                        @if($member->image_path)
                                            <img src="{{ asset('storage/' . $member->image_path) }}" class="w-8 h-10 rounded border object-cover" alt="Leader Photo">
                                        @else
                                            <div class="w-8 h-10 rounded bg-gray-100 border flex items-center justify-content-center text-gray-400 text-[10px]">No Img</div>
                                        @endif
                                        <div>
                                            <span>{{ $member->name }}</span>
                                            @if($member->membership_id)
                                                <span class="block text-[10px] font-mono font-bold text-brandOrange tracking-normal uppercase">ID: {{ implode(' ', str_split($member->membership_id, 4)) }}</span>
                                            @else
                                                <span class="block text-[9px] font-normal text-gray-400 normal-case tracking-normal">No Linked Smart Card</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5 text-left text-dark font-bold uppercase">
                                        {{ $member->designation }}
                                    </td>
                                    <td class="px-6 py-3.5 text-center">
                                        <span class="bg-orange-50 text-brandOrange text-[9px] font-black px-2 py-0.5 rounded border border-orange-100 uppercase tracking-wider">
                                            {{ str_replace('_', ' ', $member->cadre_level) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 font-bold text-gray-600 uppercase">
                                        {{ $member->locality }}
                                    </td>
                                    <td class="px-2 py-3.5">
                                        @if($member->membership_id)
                                            <a href="{{ url('/verification/' . $member->membership_id) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[9px] px-2.5 py-1 rounded shadow-sm uppercase transition">
                                                🔍 Lookup
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-[10px] font-bold">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-3.5">
                                        <a href="#" class="bg-orange-500 hover:bg-orange-600 text-white font-black text-[9px] px-3 py-1 rounded shadow-sm uppercase transition">
                                            Edit
                                        </a>
                                    </td>
                                    <td class="px-2 py-3.5">
                                        <button type="button" class="bg-rose-500 hover:bg-rose-600 text-white font-black text-[9px] px-3 py-1 rounded shadow-sm uppercase transition">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center font-bold text-gray-400 uppercase tracking-wider">
                                        No committee leader records discovered matching the matrix parameters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main> <!-- END WORKSPACE CONTAINER -->
    </div> <!-- END MAIN WORKSPACE VIEWPORT DESK -->
</div> <!-- END MIN-H-SCREEN CONTAINER -->
@endsection
