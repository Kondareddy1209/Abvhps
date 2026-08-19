<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams Management &amp; Candidate Roster | ABVHPS Central Board</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-brandOrange: #FF6600;
            --color-brandDark:   #1A1A1A;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 flex h-screen overflow-hidden">

    {{-- ===================== SIDEBAR ===================== --}}
    <div class="w-64 bg-brandDark flex flex-col justify-between shadow-xl flex-shrink-0">
        <div class="p-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-brandOrange text-white flex items-center justify-center font-black text-xs shadow-md">👑</div>
            <div>
                <h2 class="text-xs font-black tracking-widest text-brandOrange uppercase">ABVHPS CENTRAL BOARD</h2>
                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider block">Unified Management Console</span>
            </div>
        </div>

        <nav class="flex-1 p-3 space-y-1 overflow-y-auto text-[10px] font-black tracking-wider uppercase text-gray-300">
            <a href="{{ route('admin.dashboard') }}"        class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>📊</span> Dashboard Home</a>
            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">Wings Subsystems</div>
            <a href="{{ route('admin.team.index') }}"       class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>👥</span> 1. Our Team</a>
            <a href="{{ route('admin.donations.index') }}"  class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>💰</span> 2. Donations Ledger</a>
            <a href="{{ route('admin.blogs.index') }}"      class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>📰</span> 3. Blogs Manager</a>
            <a href="{{ route('admin.gallery.index') }}"    class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>🖼️</span> 4. Media Gallery</a>
            <a href="{{ route('admin.support.index') }}"    class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>🌱</span> 5. Our Support Cores</a>
            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">Membership &amp; Cadres</div>
            <a href="{{ route('admin.membership.ledger') }}"class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>💳</span> 6. Approved Membership</a>
            <a href="{{ route('admin.membership.pending') }}"class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>⏳</span> 7. Pending Membership</a>
            <a href="{{ route('admin.volunteers.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>🤝</span> 8. Volunteer Desk</a>
            <a href="{{ route('admin.rudrasena.index') }}"  class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>🔱</span> 9. Rudrasena</a>
            <a href="{{ route('admin.local_gateways.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>🏡</span> 10. Local GP Gateways</a>
            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">Services &amp; Cores</div>
            <a href="{{ route('admin.exams.index') }}"      class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition"><span>📝</span> 11. Exams Info Board</a>
            <a href="{{ route('admin.fundraising.index') }}"class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>📢</span> 12. Fundraising Matrices</a>
            <a href="{{ route('admin.contacts.index') }}"   class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>📩</span> 13. Contact Forms Audit</a>
            <a href="{{ route('admin.certificates.index') }}"class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40"><span>📜</span> 14. Tax Certificates</a>
            <a href="{{ route('admin.settings.index') }}"   class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition"><span>⚙️</span> 15. Site Global Settings</a>
        </nav>

        <div class="p-3 bg-gray-900 border-t border-gray-800 text-center text-[8px] font-bold text-gray-500 tracking-wider">
            ABVHPS SECURITY CORE V2.0
        </div>
    </div>

    {{-- ===================== MAIN WORKSPACE ===================== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top header --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <span class="text-sm font-black text-gray-600 uppercase tracking-wider">Module:</span>
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">
                    11. Exams Management &amp; Multi-Exam Roster
                </span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('public.exams_board') }}" target="_blank"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-black px-3 py-1.5 rounded-lg border border-gray-300 uppercase transition flex items-center gap-1">
                    <span>🌐</span> View Public Board
                </a>
                <a href="{{ route('exam.form') }}" target="_blank"
                   class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-black px-3 py-1.5 rounded-lg border border-emerald-300 uppercase transition flex items-center gap-1">
                    <span>📝</span> Live Application Form
                </a>
                <a href="{{ route('admin.exams.create') }}"
                   class="bg-brandOrange hover:bg-orange-700 text-white text-xs font-black px-4 py-1.5 rounded-lg shadow-sm uppercase tracking-wide transition flex items-center gap-1">
                    <span>➕</span> Create New Exam Cycle
                </a>
            </div>
        </header>

        {{-- Scrollable body --}}
        <main class="flex-1 overflow-y-auto p-6 space-y-6">

            {{-- Flash message --}}
            @if(session('success'))
                <div class="p-3 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-bold flex items-center justify-between shadow-sm">
                    <span>✓ {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 font-black ml-4">×</button>
                </div>
            @endif

            {{-- ==================== SUMMARY CARDS ==================== --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Total Exam Cycles</span>
                    <div class="text-2xl font-black text-gray-900 mt-1">{{ $exams->count() }}</div>
                    <span class="text-[10px] text-gray-500 mt-0.5 block">Independent testing cycles in database</span>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">
                        {{ (!empty($selectedExamId) && $selectedExamId !== 'all') ? 'Filtered Exam Applicants' : 'Total Registered Applicants' }}
                    </span>
                    <div class="text-2xl font-black text-brandOrange mt-1">{{ $totalApplications }}</div>
                    <span class="text-[10px] text-gray-500 mt-0.5 block">
                        {{ (!empty($selectedExamId) && $selectedExamId !== 'all') ? 'For selected exam' : 'Across all exam cycles' }}
                    </span>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Paid &amp; Secured</span>
                    <div class="text-2xl font-black text-emerald-700 mt-1">{{ $paidApplications }}</div>
                    <span class="text-[10px] text-emerald-600 mt-0.5 block">Payment confirmed (₹41.00)</span>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Email Authenticated</span>
                    <div class="text-2xl font-black text-blue-700 mt-1">{{ $verifiedApplications }}</div>
                    <span class="text-[10px] text-blue-600 mt-0.5 block">OTP authenticated candidates</span>
                </div>
            </div>

            {{-- ==================== EXAM CYCLES GRID ==================== --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-xs font-black uppercase tracking-wider text-gray-800 flex items-center gap-1.5">
                        <span>📋</span>
                        Configured Examination Cycles
                        <span class="ml-2 bg-orange-100 text-brandOrange text-[9px] font-black px-2 py-0.5 rounded border border-orange-200">
                            {{ $exams->count() }} total
                        </span>
                    </h2>
                    <p class="text-[10px] text-gray-500 font-semibold mt-0.5">
                        Each row below is one unique exam cycle from the database. Applicant counts are aggregated per exam.
                    </p>
                </div>

                @if($exams->isEmpty())
                    <div class="p-12 text-center text-gray-400">
                        <div class="text-4xl mb-3">📝</div>
                        <h4 class="font-black text-sm text-gray-700 uppercase mb-1">No Examinations Configured Yet</h4>
                        <p class="text-xs text-gray-500 mb-5">Create your first examination to begin.</p>
                        <a href="{{ route('admin.exams.create') }}"
                           class="inline-block bg-brandOrange hover:bg-orange-700 text-white text-xs font-black px-5 py-2.5 rounded-lg uppercase shadow transition">
                            + Create Examination
                        </a>
                    </div>
                @else
                    {{-- EXAM TABLE (one row per DB record — no duplicates possible) --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-[10px] font-black tracking-wider">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Exam Title</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Exam Date &amp; Time</th>
                                    <th class="px-4 py-3">Center</th>
                                    <th class="px-4 py-3">Fee</th>
                                    <th class="px-4 py-3 text-center">Applicants</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($exams as $exam)
                                    <tr class="hover:bg-orange-50/30 transition {{ (!empty($selectedExamId) && $selectedExamId == $exam->id) ? 'bg-orange-50 ring-inset ring-1 ring-orange-300' : '' }}">
                                        <td class="px-4 py-3">
                                            <span class="bg-brandOrange/10 text-brandOrange text-[9px] font-black px-2 py-0.5 rounded uppercase border border-orange-200">
                                                #{{ $exam->id }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="font-black text-gray-900 max-w-[220px]">{{ $exam->exam_title }}</div>
                                            <div class="text-[9px] text-gray-400 mt-0.5 font-mono">DB ID: {{ $exam->id }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($exam->exam_type === 'theory')
                                                <span class="bg-indigo-100 text-indigo-800 border border-indigo-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">📝 Theory</span>
                                            @elseif($exam->exam_type === 'mcq')
                                                <span class="bg-purple-100 text-purple-800 border border-purple-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">📊 MCQ</span>
                                            @elseif($exam->exam_type === 'both')
                                                <span class="bg-amber-100 text-amber-900 border border-amber-300 text-[9px] font-black px-2 py-0.5 rounded uppercase">📑 Both</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-600 border border-gray-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">— Not set</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($exam->status === 'active')
                                                <span class="bg-emerald-100 text-emerald-800 border border-emerald-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">● Active</span>
                                            @elseif($exam->status === 'upcoming')
                                                <span class="bg-blue-100 text-blue-800 border border-blue-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">⏳ Upcoming</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-700 border border-gray-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">✓ Completed</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-mono text-[11px] text-gray-700">
                                            {{ $exam->exam_date_time ? \Carbon\Carbon::parse($exam->exam_date_time)->format('d-M-Y h:i A') : 'TBA' }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600 max-w-[140px] truncate">
                                            📍 {{ $exam->exam_center_location ?? '—' }}
                                        </td>
                                        <td class="px-4 py-3 font-mono font-black text-brandOrange">
                                            ₹{{ number_format($exam->application_fee, 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('admin.exams.index', ['exam_id' => $exam->id]) }}"
                                               class="font-mono font-black text-emerald-700 hover:underline text-sm">
                                                {{ $exam->applications_count ?? 0 }} Applicants
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <a href="{{ route('admin.exams.results', $exam->id) }}"
                                                   class="bg-emerald-700 hover:bg-emerald-800 text-white text-[10px] font-black px-2.5 py-1 rounded uppercase transition">
                                                    Results
                                                </a>
                                                <a href="{{ route('admin.exams.index', ['exam_id' => $exam->id]) }}"
                                                   class="bg-orange-100 hover:bg-orange-200 text-brandOrange text-[10px] font-black px-2.5 py-1 rounded uppercase transition">
                                                    Filter
                                                </a>
                                                <a href="{{ route('admin.exams.edit', $exam->id) }}"
                                                   class="bg-gray-800 hover:bg-gray-900 text-white text-[10px] font-black px-2.5 py-1 rounded uppercase transition">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.exams.delete', $exam->id) }}" method="POST"
                                                      onsubmit="return confirm('Delete exam cycle #{{ $exam->id }}?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-rose-500 hover:bg-rose-600 text-white text-[10px] font-black px-2 py-1 rounded uppercase transition">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- ==================== CANDIDATE APPLICATION ROSTER ==================== --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-5 bg-gradient-to-r from-gray-50 to-orange-50/40 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-sm font-black uppercase tracking-wider text-gray-900 flex items-center gap-2">
                                <span>👥</span> Candidate Applications Registry
                            </h2>
                            <p class="text-xs text-gray-500 font-semibold mt-0.5">
                                Showing registered candidates partitioned by examination cycle.
                            </p>
                        </div>

                        {{-- Filter Form --}}
                        <form method="GET" action="{{ route('admin.exams.index') }}" class="flex flex-wrap items-center gap-2">
                            <select name="exam_id" onchange="this.form.submit()"
                                    class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none cursor-pointer">
                                <option value="all" {{ (empty($selectedExamId) || $selectedExamId === 'all') ? 'selected' : '' }}>
                                    🎯 All Exams
                                </option>
                                @foreach($exams as $exOption)
                                    <option value="{{ $exOption->id }}" {{ $selectedExamId == $exOption->id ? 'selected' : '' }}>
                                        #{{ $exOption->id }} — {{ Str::limit($exOption->exam_title, 35) }} ({{ $exOption->exam_type_label }})
                                    </option>
                                @endforeach
                            </select>

                            <input type="text" name="search" value="{{ $searchQuery ?? '' }}"
                                   placeholder="Search name, phone, ticket…"
                                   class="bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none w-52">

                            <button type="submit"
                                    class="bg-brandOrange hover:bg-orange-700 text-white text-xs font-black px-3 py-1.5 rounded-lg shadow-sm uppercase tracking-wide transition">
                                Filter
                            </button>

                            @if(!empty($selectedExamId) || !empty($searchQuery))
                                <a href="{{ route('admin.exams.index') }}"
                                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-black px-2.5 py-1.5 rounded-lg uppercase transition">
                                    Reset
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                {{-- Applications Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-100/80 text-gray-600 uppercase text-[10px] font-black tracking-wider border-b border-gray-200">
                            <tr>
                                <th class="p-3">Hall Ticket # / ID</th>
                                <th class="p-3">Candidate Full Name</th>
                                <th class="p-3">Exam Assigned</th>
                                <th class="p-3">Exam Type</th>
                                <th class="p-3">Parent / Guardian ID</th>
                                <th class="p-3">Contact Details</th>
                                <th class="p-3">Fee &amp; Status</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 font-medium">
                            @forelse($applications as $app)
                                <tr class="hover:bg-orange-50/30 transition">
                                    <td class="p-3">
                                        <span class="font-mono font-black text-brandOrange block">{{ $app->hall_ticket_number ?? 'N/A' }}</span>
                                        <span class="text-[9px] text-gray-400 uppercase block">App #{{ $app->id }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="font-black text-gray-900 text-xs">{{ $app->full_name }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $app->school_college_name ?? 'N/A' }} ({{ $app->class_section ?? 'N/A' }})</div>
                                        <div class="text-[9px] text-gray-400">DOB: {{ $app->dob ? date('d-M-Y', strtotime($app->dob)) : 'N/A' }}</div>
                                    </td>
                                    <td class="p-3">
                                        <div class="font-bold text-gray-800 max-w-xs truncate">
                                            {{ $app->examSetting->exam_title ?? 'Sanathana Dharma Exam' }}
                                        </div>
                                        <div class="text-[9px] text-gray-500">
                                            📍 {{ $app->examSetting->exam_center_location ?? 'Main Center' }}
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        @php $type = $app->examSetting->exam_type ?? null; @endphp
                                        @if($type === 'mcq')
                                            <span class="bg-purple-100 text-purple-800 border border-purple-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">MCQ Based</span>
                                        @elseif($type === 'theory')
                                            <span class="bg-indigo-100 text-indigo-800 border border-indigo-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">Theory Based</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-600 border border-gray-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">Not specified</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        @if($app->guardian_type === 'parents')
                                            <div class="text-[10px]"><span class="text-gray-400 font-bold">F:</span> <span class="font-mono font-semibold">{{ $app->father_membership_id ?? $app->father_name ?? 'N/A' }}</span></div>
                                            <div class="text-[10px]"><span class="text-gray-400 font-bold">M:</span> <span class="font-mono font-semibold">{{ $app->mother_membership_id ?? $app->mother_name ?? 'N/A' }}</span></div>
                                        @else
                                            <div class="text-[10px]"><span class="text-gray-400 font-bold">G:</span> <span class="font-mono font-semibold">{{ $app->guardian_mobile_or_id ?? $app->guardian_name ?? 'N/A' }}</span></div>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <div class="text-xs font-semibold text-gray-800">{{ $app->mobile }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $app->email }}</div>
                                    </td>
                                    <td class="p-3">
                                        <span class="bg-emerald-100 text-emerald-800 border border-emerald-200 text-[9px] font-black px-2 py-0.5 rounded uppercase block w-fit">
                                            ✓ {{ ucfirst($app->payment_status ?? 'success') }}
                                        </span>
                                        <span class="text-[9px] font-mono text-gray-400 mt-0.5 block">₹{{ number_format($app->amount_paid ?? 41.00, 2) }}</span>
                                    </td>
                                    <td class="p-3 text-right">
                                        <a href="{{ route('exam.success', ['id' => $app->id]) }}" target="_blank"
                                           class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-[10px] font-black px-2.5 py-1 rounded border border-gray-300 uppercase transition inline-flex items-center gap-1">
                                            <span>🖨️</span> Ticket
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-10 text-center text-gray-400 bg-white">
                                        <div class="text-3xl mb-2">🔍</div>
                                        <div class="font-bold text-xs text-gray-600 uppercase">No Candidate Applications Found</div>
                                        <div class="text-[10px] text-gray-400 mt-0.5">Try selecting "All Exams" or changing your search criteria.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($applications->hasPages())
                    <div class="p-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>

</body>
</html>
