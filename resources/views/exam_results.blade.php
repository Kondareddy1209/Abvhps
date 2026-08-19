@extends('layouts.app')

@section('title', 'Official Examination Results | ABVHPS')
@section('meta_description', 'Official portal to check and download published ABVHPS Dharma Vignana Pariksha exam results and scores.')

@section('content')
<div class="bg-slate-50 min-h-[75vh] pb-16">

    {{-- ============================================================ --}}
    {{-- 1. COMPACT INSTITUTIONAL PAGE HERO                           --}}
    {{-- ============================================================ --}}
    <div class="bg-gradient-to-r from-orange-900 via-orange-800 to-amber-900 text-white py-10 px-4 shadow-md border-b-4 border-yellow-500 text-center">
        <div class="max-w-4xl mx-auto space-y-2">
            <span class="bg-yellow-400 text-orange-950 text-[10px] font-black px-3.5 py-1 rounded-full uppercase tracking-widest inline-block shadow">
                Official Examination Portal
            </span>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold uppercase tracking-wide text-white">
                Examination Results
            </h1>
            <p class="text-xs sm:text-sm text-yellow-200/90 max-w-xl mx-auto font-medium">
                Enter your 11-digit Hall Ticket Number to view your official published examination result.
            </p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-8">

        {{-- ============================================================ --}}
        {{-- 2. WINNERS WALL OF FAME (IF PUBLISHED WINNERS EXIST)         --}}
        {{-- ============================================================ --}}
        @if(isset($winners) && $winners->isNotEmpty())
        <div class="bg-white border border-gray-200 rounded-2xl p-6 sm:p-8 shadow-xs">
            <div class="text-center mb-6">
                <span class="text-xs font-bold text-orange-600 uppercase tracking-wider block">🏆 Top Achievers</span>
                <h2 class="text-xl sm:text-2xl font-black text-gray-900 uppercase tracking-tight mt-0.5">
                    Prize Winners &amp; Rank Holders
                </h2>
                <p class="text-xs text-gray-500 mt-1">Honoring top-ranked performers in Sanathana Dharma Examinations</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($winners as $winner)
                    <div class="bg-orange-50/50 border border-orange-200/80 rounded-xl p-4 text-center flex flex-col justify-between space-y-3">
                        <div class="space-y-2">
                            <span class="inline-block bg-orange-600 text-white text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                Rank #{{ $winner->winner_rank ?? '—' }}
                            </span>
                            
                            <div class="w-16 h-16 rounded-full overflow-hidden bg-white border-2 border-orange-400 mx-auto shadow-xs">
                                @if($winner->photo_path)
                                    <img src="{{ asset('storage/' . $winner->photo_path) }}" class="w-full h-full object-cover" alt="Winner Photo">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs font-bold text-gray-400">
                                        PHOTO
                                    </div>
                                @endif
                            </div>

                            <div>
                                <h3 class="font-black text-gray-900 text-xs sm:text-sm uppercase truncate">
                                    {{ $winner->full_name }}
                                </h3>
                                <p class="text-[10px] font-mono text-gray-500 mt-0.5">
                                    HT: {{ $winner->hall_ticket_number ?? '—' }}
                                </p>
                            </div>
                        </div>

                        @if(!empty($winner->prize_title_won))
                            <div class="bg-white border border-orange-200 rounded-lg py-1 px-2 text-[11px] font-bold text-orange-800 truncate shadow-xs">
                                🎁 {{ $winner->prize_title_won }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ============================================================ --}}
        {{-- 3. RESULT SEARCH CARD (CENTERED & CLEAN)                     --}}
        {{-- ============================================================ --}}
        <div class="max-w-xl mx-auto bg-white border border-gray-200 rounded-2xl shadow-xs overflow-hidden">
            
            {{-- Card Header --}}
            <div class="p-6 sm:p-7 border-b border-gray-100 text-center bg-gray-50/50">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-white border border-brandOrange shadow-xs mx-auto mb-2 flex items-center justify-center p-0.5">
                    <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
                </div>
                <h2 class="text-lg font-black text-gray-900 uppercase tracking-tight">Check Your Result</h2>
                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">
                    Enter your 11-digit Hall Ticket Number to view your official published examination result.
                </p>
            </div>

            {{-- Form Body --}}
            <div class="p-6 sm:p-8">
                <form id="result_search_form" onsubmit="executeResultSearch(event)" class="space-y-4">
                    
                    <div>
                        <label for="search_hall_ticket" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                            Hall Ticket Number <span class="text-orange-600">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                id="search_hall_ticket"
                                maxlength="11"
                                minlength="11"
                                pattern="[0-9]{11}"
                                inputmode="numeric"
                                required
                                autocomplete="off"
                                class="w-full bg-white border border-gray-300 focus:border-brandOrange focus:ring-2 focus:ring-orange-100 rounded-xl px-4 py-3 text-center font-mono text-xl tracking-[0.2em] font-bold text-gray-900 outline-none transition placeholder:text-gray-300 placeholder:text-sm placeholder:tracking-normal"
                                placeholder="Enter 11-digit Hall Ticket Number"
                            >
                        </div>
                        <p class="text-[11px] text-gray-400 text-center mt-1.5 font-medium">
                            Enter exactly 11 numeric digits (e.g., 20261234567)
                        </p>
                    </div>

                    <button
                        type="submit"
                        id="btn_search_submit"
                        class="w-full bg-brandOrange hover:bg-opacity-90 text-white font-bold text-xs py-3.5 px-6 rounded-xl shadow-xs transition duration-150 uppercase tracking-wider flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <span id="btn_icon">🔍</span>
                        <span id="btn_text">View My Result</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- 4. RESULT MEMO DISPLAY (DYNAMIC INJECTION)                   --}}
        {{-- ============================================================ --}}
        <div id="result_display_desk" class="max-w-xl mx-auto hidden">
            <!-- Injected by JavaScript -->
        </div>

        {{-- NOT FOUND PANEL --}}
        <div id="result_not_found" class="max-w-xl mx-auto hidden">
            <div class="bg-white rounded-2xl border border-red-200 p-6 text-center shadow-xs">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-50 text-red-600 text-xl font-bold mb-2">✕</div>
                <h3 class="font-bold text-gray-900 text-sm uppercase mb-1">Result Not Found</h3>
                <p id="not_found_msg" class="text-xs text-gray-500 max-w-sm mx-auto">
                    We could not find an examination result matching the information provided. Please verify your Hall Ticket Number and try again.
                </p>
                <button
                    onclick="resetSearch()"
                    class="mt-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs px-4 py-2 rounded-lg uppercase tracking-wider transition cursor-pointer"
                >
                    ← Try Again
                </button>
            </div>
        </div>

        {{-- ERROR PANEL --}}
        <div id="result_error" class="max-w-xl mx-auto hidden">
            <div class="bg-white rounded-2xl border border-amber-200 p-6 text-center shadow-xs">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-50 text-amber-600 text-xl font-bold mb-2">⚠️</div>
                <h3 class="font-bold text-gray-900 text-sm uppercase mb-1">Connection Error</h3>
                <p class="text-xs text-gray-500 max-w-sm mx-auto">
                    Unable to reach the results database. Please check your network connection and try again.
                </p>
                <button
                    onclick="resetSearch()"
                    class="mt-4 bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold text-xs px-4 py-2 rounded-lg uppercase tracking-wider transition cursor-pointer"
                >
                    ← Try Again
                </button>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- 5. INSTITUTIONAL RESULT SEARCH INFORMATION CARD              --}}
        {{-- ============================================================ --}}
        <div class="max-w-xl mx-auto bg-blue-50/70 border border-blue-200/80 rounded-2xl p-5 text-xs text-blue-900 space-y-2 shadow-xs">
            <div class="font-bold uppercase tracking-wider flex items-center gap-1.5 text-blue-950">
                <span>ℹ️</span>
                <span>Result Search Information</span>
            </div>
            <ul class="list-disc pl-4 space-y-1 text-[11px] text-blue-900">
                <li>Use your official 11-digit Hall Ticket Number to access your published examination result.</li>
                <li>Your result will be displayed only after it has been officially approved and published by ABVHPS.</li>
                <li>For any examination or result queries, please contact the central examination control room at info@abvhps.org.</li>
            </ul>
        </div>

    </div>
</div>

{{-- ============================================================ --}}
{{-- 6. JAVASCRIPT RESULT SEARCH ENGINE                           --}}
{{-- ============================================================ --}}
<script>
    function resetSearch() {
        document.getElementById('result_display_desk').classList.add('hidden');
        document.getElementById('result_not_found').classList.add('hidden');
        document.getElementById('result_error').classList.add('hidden');
        const input = document.getElementById('search_hall_ticket');
        input.value = '';
        input.focus();
    }

    function setButtonLoading(loading) {
        const btn = document.getElementById('btn_search_submit');
        const icon = document.getElementById('btn_icon');
        const text = document.getElementById('btn_text');
        if (loading) {
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            icon.innerText = '⏳';
            text.innerText = 'Searching Database...';
        } else {
            btn.disabled = false;
            btn.classList.remove('opacity-80', 'cursor-not-allowed');
            icon.innerText = '🔍';
            text.innerText = 'View My Result';
        }
    }

    async function executeResultSearch(event) {
        event.preventDefault();

        const htNumber = document.getElementById('search_hall_ticket').value.trim();
        const displayDesk = document.getElementById('result_display_desk');
        const notFoundPanel = document.getElementById('result_not_found');
        const errorPanel = document.getElementById('result_error');

        // Hide all panels first
        displayDesk.classList.add('hidden');
        notFoundPanel.classList.add('hidden');
        errorPanel.classList.add('hidden');

        if (!htNumber || htNumber.length !== 11 || !/^\d{11}$/.test(htNumber)) {
            const input = document.getElementById('search_hall_ticket');
            input.classList.add('border-red-400', 'bg-red-50');
            input.focus();
            setTimeout(() => input.classList.remove('border-red-400', 'bg-red-50'), 2000);
            return;
        }

        setButtonLoading(true);

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            const response = await fetch("{{ route('exam.results_search') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ hall_ticket_number: htNumber })
            });

            const result = await response.json();
            setButtonLoading(false);

            if (result.success) {
                renderResultCard(result);
                displayDesk.classList.remove('hidden');
                displayDesk.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                const msgEl = document.getElementById('not_found_msg');
                if (msgEl && result.message) {
                    msgEl.innerText = result.message;
                }
                notFoundPanel.classList.remove('hidden');
                notFoundPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

        } catch (error) {
            setButtonLoading(false);
            console.error('Result lookup error:', error);
            errorPanel.classList.remove('hidden');
        }
    }

    function renderResultCard(data) {
        const desk = document.getElementById('result_display_desk');

        // Status badge styling
        const statusStr = (data.status || 'pending').toLowerCase();
        let statusBadge = '';
        let statusColor = '';
        if (statusStr === 'pass' || statusStr === 'passed') {
            statusBadge = '✓ PASSED';
            statusColor = 'bg-emerald-50 text-emerald-700 border-emerald-200';
        } else if (statusStr === 'fail' || statusStr === 'failed') {
            statusBadge = '✕ FAILED';
            statusColor = 'bg-red-50 text-red-700 border-red-200';
        } else {
            statusBadge = (data.status || 'PENDING').toUpperCase();
            statusColor = 'bg-amber-50 text-amber-800 border-amber-200';
        }

        // Exam Pattern Label
        const typeLabel = data.exam_type === 'mcq' ? 'MCQ Based' : (data.exam_type === 'theory' ? 'Theory Based' : (data.exam_type === 'both' ? 'Theory + MCQ' : (data.exam_type ? data.exam_type.toUpperCase() : '')));

        // Marks display
        const marksDisplay = (data.marks !== null && data.marks !== undefined)
            ? `${data.marks}${data.total_marks ? ' / ' + data.total_marks : ''}`
            : 'Evaluated';

        // Prize Section
        const prizeHTML = data.prize
            ? `<div class="bg-amber-50 border border-amber-200 rounded-xl p-3.5 text-center mt-3">
                   <div class="text-[10px] font-bold text-amber-800 uppercase tracking-wider">🏆 Prize Awarded</div>
                   <div class="font-black text-amber-950 text-xs sm:text-sm mt-0.5">${data.prize}</div>
               </div>`
            : '';

        desk.innerHTML = `
            <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
                
                <!-- Result Memo Header -->
                <div class="bg-gray-900 text-white p-4 text-center">
                    <div class="text-xs sm:text-sm font-black uppercase tracking-wider">Official Examination Result Memo</div>
                    <div class="text-[10px] text-orange-400 font-semibold uppercase tracking-widest mt-0.5">${data.exam_title || 'Sanathana Dharma Examination'}</div>
                </div>

                <!-- Hall Ticket Showcase -->
                <div class="bg-orange-50/70 border-b border-orange-100 p-4 text-center">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Official Hall Ticket Number</span>
                    <span class="font-mono font-black text-orange-700 text-2xl tracking-widest block mt-0.5">${data.hall_ticket}</span>
                </div>

                <!-- Candidate & Marks Details Grid -->
                <div class="p-6 space-y-3 text-xs">
                    <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                        <span class="font-bold text-gray-500 uppercase">Candidate Name</span>
                        <span class="font-black text-gray-900 uppercase">${data.full_name}</span>
                    </div>

                    <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                        <span class="font-bold text-gray-500 uppercase">Examination</span>
                        <span class="font-bold text-gray-800 text-right truncate max-w-[60%]">${data.exam_title || '—'}</span>
                    </div>

                    ${typeLabel ? `
                    <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                        <span class="font-bold text-gray-500 uppercase">Exam Pattern</span>
                        <span class="font-semibold text-gray-700">${typeLabel}</span>
                    </div>` : ''}

                    <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                        <span class="font-bold text-gray-500 uppercase">School / Institution</span>
                        <span class="font-medium text-gray-700 text-right truncate max-w-[60%]">${data.school_name || '—'}</span>
                    </div>

                    <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                        <span class="font-bold text-gray-500 uppercase">Marks Obtained</span>
                        <span class="font-mono font-black text-orange-700 text-sm">${marksDisplay}</span>
                    </div>

                    ${data.percentage !== null && data.percentage !== undefined ? `
                    <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                        <span class="font-bold text-gray-500 uppercase">Percentage</span>
                        <span class="font-mono font-bold text-gray-800">${data.percentage}%</span>
                    </div>` : ''}

                    ${data.grade ? `
                    <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                        <span class="font-bold text-gray-500 uppercase">Grade</span>
                        <span class="font-bold bg-amber-50 text-amber-800 border border-amber-200 px-2 py-0.5 rounded text-[11px]">${data.grade}</span>
                    </div>` : ''}

                    <div class="flex justify-between items-center pt-2">
                        <span class="font-bold text-gray-500 uppercase">Result Outcome</span>
                        <span class="font-black text-xs border px-3 py-1 rounded-full ${statusColor}">${statusBadge}</span>
                    </div>

                    ${prizeHTML}
                </div>

                <!-- Footer Bar -->
                <div class="bg-gray-50 border-t border-gray-100 px-6 py-3 flex items-center justify-between text-[10px]">
                    <span class="text-gray-400 font-mono">ABVHPS CENTRAL EXAM DESK</span>
                    <button onclick="resetSearch()" class="font-bold text-orange-600 hover:text-orange-700 uppercase tracking-wider cursor-pointer">
                        Search Again →
                    </button>
                </div>

            </div>
        `;
    }

    // Auto-filter 11 digits numeric only
    document.getElementById('search_hall_ticket')?.addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '').slice(0, 11);
    });
</script>
@endsection
