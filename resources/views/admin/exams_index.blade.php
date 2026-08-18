<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams Info Board (Continuous Loop) | ABVHPS Central Board</title>
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
            <a href="{{ route('admin.exams.index') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
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

    <!-- BLOCK 2: WORKSPACE -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <span class="text-sm font-black text-brandGray uppercase tracking-wider">Module:</span>
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">11. Exams Info Board (Continuous Loop)</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('public.exams_board') }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-black px-3 py-1.5 rounded-lg border border-gray-300 uppercase transition flex items-center gap-1">
                    <span>🌐</span> View Public Board
                </a>
                <a href="{{ route('admin.exams.create') }}" class="bg-brandOrange hover:bg-orange-700 text-white text-xs font-black px-4 py-1.5 rounded-lg shadow-sm uppercase tracking-wide transition flex items-center gap-1">
                    <span>➕</span> Create New Exam Cycle
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

            <!-- Active Exam Cycles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($exams as $exam)
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col justify-between transform hover:scale-[1.01] transition-all">
                        <!-- Top Banner / Header -->
                        <div class="p-5 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="bg-brandOrange text-white text-[9px] font-black px-2.5 py-0.5 rounded uppercase">
                                    CYCLE #{{ $exam->id }}
                                </span>
                                @if($exam->status === 'active')
                                    <span class="bg-emerald-100 text-emerald-800 border border-emerald-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">
                                        ● Active Loop
                                    </span>
                                @elseif($exam->status === 'upcoming')
                                    <span class="bg-blue-100 text-blue-800 border border-blue-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">
                                        ⏳ Upcoming
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-700 border border-gray-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">
                                        ✓ Completed
                                    </span>
                                @endif
                            </div>
                            <h3 class="font-black text-sm text-gray-900 uppercase leading-tight">
                                {{ $exam->exam_title }}
                            </h3>
                            <p class="text-xs text-gray-500 font-bold mt-1">
                                📍 {{ $exam->exam_center_location }}
                            </p>
                        </div>

                        <!-- Details Section -->
                        <div class="p-5 space-y-3 text-xs flex-1">
                            <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-400 font-bold uppercase text-[10px]">Exam Date & Time</span>
                                <span class="font-mono font-bold text-gray-800">{{ $exam->exam_date_time ? \Carbon\Carbon::parse($exam->exam_date_time)->format('d-M-Y h:i A') : 'TBA' }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-400 font-bold uppercase text-[10px]">Fee per Candidate</span>
                                <span class="font-mono font-black text-brandOrange">₹{{ number_format($exam->application_fee, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-400 font-bold uppercase text-[10px]">Total Candidates Registered</span>
                                <span class="font-mono font-black text-emerald-700">{{ $exam->applications_count ?? 0 }} Applicants</span>
                            </div>

                            <!-- Prizes Breakdown -->
                            <div class="pt-1">
                                <span class="text-[10px] font-black uppercase tracking-wider text-gray-400 block mb-1">Prizes Matrix:</span>
                                <div class="bg-gray-50 p-2 rounded-lg border border-gray-200 text-[11px] text-gray-700 space-y-0.5">
                                    @php
                                        $prizes = is_array($exam->prize_details_json) ? $exam->prize_details_json : json_decode($exam->prize_details_json, true);
                                    @endphp
                                    @if(is_array($prizes) && count($prizes) > 0)
                                        @foreach($prizes as $prize)
                                            <div class="flex items-center gap-1.5">
                                                <span>🏆</span> <span>{{ $prize }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-gray-400 italic">Standard Merit Awards & Certificates</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Actions Footer -->
                        <div class="p-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between gap-2">
                            @if($exam->syllabus_pdf_path)
                                <a href="{{ asset('storage/'.$exam->syllabus_pdf_path) }}" target="_blank" class="text-[10px] font-black text-blue-600 hover:underline flex items-center gap-1">
                                    <span>📄</span> Syllabus PDF
                                </a>
                            @else
                                <span class="text-[10px] text-gray-400">No PDF</span>
                            @endif

                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.exams.edit', $exam->id) }}" class="bg-gray-800 hover:bg-gray-900 text-white text-[10px] font-black px-3 py-1.5 rounded uppercase transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.exams.delete', $exam->id) }}" method="POST" onsubmit="return confirm('Delete this exam cycle?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-[10px] font-black px-2.5 py-1.5 rounded uppercase transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-12 rounded-xl border border-gray-200 text-center text-gray-400">
                        <div class="text-3xl mb-2">📝</div>
                        <h4 class="font-black text-sm text-gray-700 uppercase">No Exam Cycles Created Yet</h4>
                        <p class="text-xs mt-1">Create your first examination notice cycle to start accepting student applications.</p>
                        <a href="{{ route('admin.exams.create') }}" class="inline-block mt-4 bg-brandOrange text-white text-xs font-black px-4 py-2 rounded-lg uppercase shadow">
                            Create First Exam Cycle
                        </a>
                    </div>
                @endforelse
            </div>
        </main>
    </div>

</body>
</html>
