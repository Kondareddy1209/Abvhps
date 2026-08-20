@extends('layouts.app')

@section('title', 'Area-wise Member Data | ABVHPS Volunteer Portal')

@section('content')
<div class="bg-gray-50 min-h-screen pb-16">

    {{-- Official Header Banner --}}
    <div class="bg-gradient-to-r from-orange-900 via-orange-800 to-amber-900 text-white py-8 px-4 shadow-md border-b-4 border-yellow-500">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-yellow-400 text-orange-950 text-[10px] font-black px-3.5 py-1 rounded-full uppercase tracking-widest inline-block shadow">
                        Volunteer Operations Desk
                    </span>
                    <span class="bg-white/20 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        Vol ID: {{ $volunteer->volunteer_id }}
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-black uppercase tracking-wide text-white flex items-center gap-2.5">
                    <span>📋</span> Area-wise Member Data Directory
                </h1>
                <p class="text-xs text-yellow-200/90 font-medium mt-0.5">
                    Query, preview, and export official 12-digit membership records across any designated area.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                <a href="{{ route('volunteer.dashboard') }}"
                   class="bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-bold px-4 py-2 rounded-xl uppercase tracking-wider transition min-h-[44px] inline-flex items-center">
                    &larr; Dashboard
                </a>
                <form action="{{ route('volunteer.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-black px-4 py-2 rounded-xl shadow uppercase tracking-wider transition cursor-pointer min-h-[44px] inline-flex items-center">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Main Container --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-6">

        {{-- Flash Alerts --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl text-xs font-bold shadow-sm flex items-center justify-between">
                <span>✓ {{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 font-black">×</button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl text-xs font-bold shadow-sm flex items-center justify-between">
                <span>⚠️ {{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-rose-600 font-black">×</button>
            </div>
        @endif

        {{-- Compliance & Data Policy Notice --}}
        <div class="bg-amber-50/80 border border-amber-200 rounded-2xl p-4 text-xs text-amber-950 flex items-start gap-3 shadow-xs">
            <span class="text-xl shrink-0">🛡️</span>
            <div>
                <strong class="font-black uppercase tracking-wider text-amber-900 block mb-0.5">
                    ABVHPS Member Data &mdash; Authorized Organizational Use Only
                </strong>
                <p class="text-[11px] text-amber-800 leading-relaxed">
                    This directory is provided strictly for authorized voluntary seva and coordination. 
                    The dataset contains verified member full names, gender, photos, and official 12-digit Membership IDs. 
                    Personal identifiers (phone, email, bank, and Aadhaar) are protected and strictly excluded.
                </p>
            </div>
        </div>

        {{-- Area Filter & Export Control Form --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 space-y-6">
            
            <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                <h3 class="font-black text-gray-800 text-sm uppercase tracking-wide flex items-center gap-2">
                    <span>📍</span> Select Regional Scope &amp; Area Criteria
                </h3>
                <span class="text-[11px] text-gray-400 font-semibold">
                    You may select any configured area across Andhra Pradesh / India
                </span>
            </div>

            <form id="exportForm" method="POST" action="{{ route('volunteer.member_data.export_pdf') }}">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- District Filter --}}
                    <div>
                        <label for="districtSelect" class="block text-[11px] font-black text-gray-700 uppercase tracking-wider mb-1">
                            1. District
                        </label>
                        <select id="districtSelect" name="district" onchange="onDistrictChanged()"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-orange-500 outline-none">
                            <option value="">-- All Available Districts --</option>
                            @foreach($districts as $d)
                                <option value="{{ $d }}">{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Mandal Filter --}}
                    <div>
                        <label for="mandalSelect" class="block text-[11px] font-black text-gray-700 uppercase tracking-wider mb-1">
                            2. Mandal
                        </label>
                        <select id="mandalSelect" name="mandal" onchange="onMandalChanged()"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-orange-500 outline-none">
                            <option value="">-- All Mandals --</option>
                        </select>
                    </div>

                    {{-- Grama Panchayat / Village Filter --}}
                    <div>
                        <label for="panchayatSelect" class="block text-[11px] font-black text-gray-700 uppercase tracking-wider mb-1">
                            3. Grama Panchayat / Village
                        </label>
                        <select id="panchayatSelect" name="grama_panchayat"
                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-orange-500 outline-none">
                            <option value="">-- All Panchayats --</option>
                        </select>
                    </div>

                    {{-- Name Keyword Search --}}
                    <div>
                        <label for="nameSearch" class="block text-[11px] font-black text-gray-700 uppercase tracking-wider mb-1">
                            4. Member Name (Optional)
                        </label>
                        <input type="text" id="nameSearch" name="search" placeholder="Search by name..."
                               class="w-full bg-gray-50 border border-gray-300 rounded-xl px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-orange-500 outline-none">
                    </div>

                </div>

                {{-- Action Buttons Toolbar --}}
                <div class="mt-6 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
                    
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="performPreviewSearch()" id="btnPreview"
                                class="bg-brandOrange hover:bg-orange-600 text-white text-xs font-black px-5 py-2.5 rounded-xl shadow uppercase tracking-wider transition flex items-center gap-2 cursor-pointer">
                            <span>🔍</span> Preview Records
                        </button>

                        <button type="button" onclick="resetFilters()"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2.5 rounded-xl uppercase tracking-wider transition cursor-pointer">
                            ↺ Reset
                        </button>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" onclick="triggerDownload('pdf')"
                                class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-black px-4 py-2.5 rounded-xl shadow uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                            <span>📥</span> Download PDF
                        </button>

                        <button type="button" onclick="triggerDownload('csv')"
                                class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-black px-4 py-2.5 rounded-xl shadow uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                            <span>📊</span> Download CSV
                        </button>
                    </div>

                </div>
            </form>

        </div>

        {{-- Live Search Results Preview Desk --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 space-y-4">
            
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="font-black text-gray-800 text-sm uppercase tracking-wide flex items-center gap-2">
                    <span>👥</span> Member Records Preview
                </h3>
                <span id="resultsSummary" class="text-xs font-bold text-brandOrange bg-orange-50 px-3 py-1 rounded-full border border-orange-200">
                    Click "Preview Records" to search
                </span>
            </div>

            {{-- Loading Indicator --}}
            <div id="loadingBox" class="hidden py-10 text-center space-y-2">
                <div class="inline-block w-8 h-8 border-4 border-brandOrange border-t-transparent rounded-full animate-spin"></div>
                <p class="text-xs text-gray-500 font-bold">Querying verified member ledger...</p>
            </div>

            {{-- Results Table Frame --}}
            <div id="tableWrapper" class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 font-black uppercase text-[10px] tracking-wider">
                            <th class="py-3 px-3 text-center">#</th>
                            <th class="py-3 px-3 text-center">Photo</th>
                            <th class="py-3 px-3">Member Full Name</th>
                            <th class="py-3 px-3">Gender</th>
                            <th class="py-3 px-3">12-Digit Membership ID</th>
                            <th class="py-3 px-3">Grama Panchayat</th>
                            <th class="py-3 px-3">Mandal</th>
                            <th class="py-3 px-3">District</th>
                        </tr>
                    </thead>
                    <tbody id="memberTableBody" class="divide-y divide-gray-100 text-gray-700 font-medium">
                        <tr>
                            <td colspan="8" class="py-10 text-center text-gray-400 font-bold">
                                Select an area above and click "Preview Records" to inspect member records.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

{{-- Client JavaScript for Cascading Dropdowns & Asynchronous Preview --}}
<script>
    const areasUrl = "{{ route('volunteer.member_data.areas') }}";
    const searchUrl = "{{ route('volunteer.member_data.search') }}";
    const pdfExportUrl = "{{ route('volunteer.member_data.export_pdf') }}";
    const csvExportUrl = "{{ route('volunteer.member_data.export_csv') }}";
    const csrfToken = "{{ csrf_token() }}";

    async function onDistrictChanged() {
        const district = document.getElementById('districtSelect').value;
        const mandalSelect = document.getElementById('mandalSelect');
        const panchayatSelect = document.getElementById('panchayatSelect');

        mandalSelect.innerHTML = '<option value="">-- All Mandals --</option>';
        panchayatSelect.innerHTML = '<option value="">-- All Panchayats --</option>';

        if (!district) return;

        try {
            const res = await fetch(`${areasUrl}?district=${encodeURIComponent(district)}`);
            const data = await res.json();
            if (data.mandals) {
                data.mandals.forEach(m => {
                    const opt = document.createElement('option');
                    opt.value = m;
                    opt.textContent = m;
                    mandalSelect.appendChild(opt);
                });
            }
        } catch (e) {
            console.error('Failed to load mandals', e);
        }
    }

    async function onMandalChanged() {
        const district = document.getElementById('districtSelect').value;
        const mandal = document.getElementById('mandalSelect').value;
        const panchayatSelect = document.getElementById('panchayatSelect');

        panchayatSelect.innerHTML = '<option value="">-- All Panchayats --</option>';
        if (!mandal) return;

        try {
            const res = await fetch(`${areasUrl}?district=${encodeURIComponent(district)}&mandal=${encodeURIComponent(mandal)}`);
            const data = await res.json();
            if (data.panchayats) {
                data.panchayats.forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p;
                    opt.textContent = p;
                    panchayatSelect.appendChild(opt);
                });
            }
        } catch (e) {
            console.error('Failed to load panchayats', e);
        }
    }

    async function performPreviewSearch() {
        const district = document.getElementById('districtSelect').value;
        const mandal = document.getElementById('mandalSelect').value;
        const grama_panchayat = document.getElementById('panchayatSelect').value;
        const search = document.getElementById('nameSearch').value;

        const loadingBox = document.getElementById('loadingBox');
        const tbody = document.getElementById('memberTableBody');
        const summary = document.getElementById('resultsSummary');

        loadingBox.classList.remove('hidden');
        tbody.innerHTML = '';
        summary.textContent = 'Searching...';

        try {
            const res = await fetch(searchUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ district, mandal, grama_panchayat, search })
            });

            const result = await res.json();
            loadingBox.classList.add('hidden');

            if (!res.ok) {
                summary.textContent = 'Error occurred';
                tbody.innerHTML = `<tr><td colspan="8" class="py-8 text-center text-rose-600 font-bold">${result.error || 'Failed to fetch records.'}</td></tr>`;
                return;
            }

            summary.textContent = `Found ${result.total_count} records (Showing top ${result.displayed_count})`;

            if (result.members.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" class="py-10 text-center text-gray-400 font-bold">No verified member records found for the specified criteria.</td></tr>`;
                return;
            }

            result.members.forEach(m => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-orange-50/40 transition';

                const photoMarkup = m.photo_url 
                    ? `<img src="${m.photo_url}" class="w-8 h-8 rounded-full object-cover mx-auto border border-gray-200 shadow-xs" alt="Photo" />`
                    : `<div class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 text-[10px] flex items-center justify-center mx-auto border border-gray-200">👤</div>`;

                tr.innerHTML = `
                    <td class="py-2.5 px-3 text-center text-gray-400 font-mono font-bold">${m.serial_no}</td>
                    <td class="py-2.5 px-3 text-center">${photoMarkup}</td>
                    <td class="py-2.5 px-3 font-bold text-gray-900">${m.full_name}</td>
                    <td class="py-2.5 px-3 capitalize text-gray-600">${m.gender}</td>
                    <td class="py-2.5 px-3 font-mono font-black text-emerald-700 tracking-wider">${m.membership_id}</td>
                    <td class="py-2.5 px-3 text-gray-600">${m.grama_panchayat}</td>
                    <td class="py-2.5 px-3 text-gray-600">${m.mandal}</td>
                    <td class="py-2.5 px-3 text-gray-600">${m.district}</td>
                `;
                tbody.appendChild(tr);
            });

        } catch (e) {
            loadingBox.classList.add('hidden');
            summary.textContent = 'Connection Error';
            tbody.innerHTML = `<tr><td colspan="8" class="py-8 text-center text-rose-600 font-bold">An unexpected error occurred while communicating with the server.</td></tr>`;
        }
    }

    function triggerDownload(format) {
        const form = document.getElementById('exportForm');
        if (format === 'pdf') {
            form.action = pdfExportUrl;
        } else {
            form.action = csvExportUrl;
        }
        form.submit();
    }

    function resetFilters() {
        document.getElementById('districtSelect').value = '';
        document.getElementById('mandalSelect').innerHTML = '<option value="">-- All Mandals --</option>';
        document.getElementById('panchayatSelect').innerHTML = '<option value="">-- All Panchayats --</option>';
        document.getElementById('nameSearch').value = '';
        document.getElementById('resultsSummary').textContent = 'Click "Preview Records" to search';
        document.getElementById('memberTableBody').innerHTML = `
            <tr>
                <td colspan="8" class="py-10 text-center text-gray-400 font-bold">
                    Select an area above and click "Preview Records" to inspect member records.
                </td>
            </tr>
        `;
    }
</script>
@endsection
