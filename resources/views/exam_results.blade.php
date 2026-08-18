<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABVHPS - Exam Results & Winners Wall</title>
    <!-- Tailwind CSS Engine Grid -->
    <link href="https://jsdelivr.net" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-yellow-50 min-h-screen font-sans antialiased text-gray-900">

    <div class="max-w-5xl mx-auto py-10 px-4">
        
        <!-- Central Portal Header -->
        <div class="text-center bg-orange-600 text-white p-6 rounded-t-xl shadow-md border-b-4 border-yellow-400">
            <h1 class="text-xl md:text-2xl font-extrabold tracking-wide uppercase">AKHANDA BHARATA VISWA HINDU PARIRAKSHANA SAMITI</h1>
            <h2 class="text-lg font-bold text-yellow-200 mt-1">Sanathana Dharma Examination Results Portal</h2>
        </div>

        <!-- --- TOP 6 WINNERS SHOWCASE (WALL OF FAME) --- -->
        <div class="bg-gradient-to-b from-orange-100 to-yellow-50 p-6 border-x border-gray-200 shadow-sm space-y-6">
            <div class="text-center">
                <span class="text-4xl">🏆</span>
                <h3 class="text-xl font-black text-orange-950 uppercase tracking-wider mt-1">Sanathana Dharma Exam - Wall of Fame</h3>
                <p class="text-xs text-orange-800 font-semibold">Honoring our Top 6 Divine Rank Winners</p>
            </div>

            <!-- ROW 1: THE APEX CHAMPION (1st Rank - Tablet Winner) -->
            <div class="flex justify-center">
                @php $rank1 = $winners->where('winner_rank', 1)->first(); @endphp
                <div class="w-full max-w-sm bg-white p-4 rounded-xl border-2 border-yellow-500 shadow-xl text-center transform hover:scale-105 transition">
                    <div class="bg-yellow-400 text-yellow-950 font-black px-4 py-1 rounded-full text-xs inline-block uppercase tracking-widest mb-3 shadow">🥇 1st Rank Champion</div>
                    <div class="flex justify-center mb-2">
                        <img src="{{ $rank1 && $rank1->photo_path ? asset('storage/' . $rank1->photo_path) : 'https://placeholder.com' }}" class="w-24 h-24 object-cover rounded-full border-4 border-yellow-400 shadow-md bg-gray-100">
                    </div>
                    <h4 class="font-extrabold text-gray-800 text-base">{{ $rank1->full_name ?? 'Announcing Soon' }}</h4>
                    <p class="text-xxs font-mono text-gray-400 mt-0.5">HT ID: {{ $rank1->hall_ticket_number ?? 'XXXXX' }}</p>
                    <div class="mt-2 bg-orange-100 text-orange-900 font-bold text-xs py-1 px-3 rounded-lg border border-orange-200">🎁 Prize: {{ $rank1->prize_title_won ?? 'Tablet (1-Member)' }}</div>
                </div>
            </div>

            <!-- ROW 2: THE CORE CONTENDERS (2nd & 3rd Ranks - LED TV Winners) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl mx-auto">
                @foreach([2, 3] as $r)
                    @php $rankData = $winners->where('winner_rank', $r)->first(); @endphp
                    <div class="bg-white p-4 rounded-xl border border-gray-300 shadow-lg text-center transform hover:scale-102 transition">
                        <div class="bg-gray-200 text-gray-800 font-bold px-3 py-0.5 rounded-full text-xxs inline-block uppercase tracking-wider mb-2">
                            {{ $r == 2 ? '🥈 2nd Rank' : '🥉 3rd Rank' }}
                        </div>
                        <div class="flex justify-center mb-2">
                            <img src="{{ $rankData && $rankData->photo_path ? asset('storage/' . $rankData->photo_path) : 'https://placeholder.com' }}" class="w-20 h-20 object-cover rounded-full border-2 border-gray-300 shadow bg-gray-100">
                        </div>
                        <h5 class="font-bold text-gray-800 text-sm">{{ $rankData->full_name ?? 'Announcing Soon' }}</h5>
                        <p class="text-xxs font-mono text-gray-400">{{ $rankData->hall_ticket_number ?? 'XXXXX' }}</p>
                        <div class="mt-1.5 bg-yellow-100 text-yellow-950 font-semibold text-xxs py-1 px-2 rounded border border-yellow-200">🎁 {{ $rankData->prize_title_won ?? '32" LED TV' }}</div>
                    </div>
                @endforeach
            </div>
            <!-- ROW 3: THE ACHIEVERS (4th, 5th & 6th Ranks - Steel Dinner Set Winners) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-3xl mx-auto pt-2">
                @foreach([4, 5, 6] as $r)
                    @php $rankData = $winners->where('winner_rank', $r)->first(); @endphp
                    <div class="bg-white p-3 rounded-lg border border-gray-200 shadow shadow-sm text-center transform hover:scale-102 transition">
                        <div class="bg-amber-100 text-amber-900 font-medium px-2 py-0.5 rounded-full text-xxs inline-block uppercase tracking-wider mb-2">🏅 {{ $r }}th Rank</div>
                        <div class="flex justify-center mb-1.5">
                            <img src="{{ $rankData && $rankData->photo_path ? asset('storage/' . $rankData->photo_path) : 'https://placeholder.com' }}" class="w-16 h-16 object-cover rounded-full border border-gray-200 shadow-xs bg-gray-100">
                        </div>
                        <h6 class="font-bold text-gray-800 text-xs truncate">{{ $rankData->full_name ?? 'Announcing Soon' }}</h6>
                        <p class="text-xxs font-mono text-gray-400">{{ $rankData->hall_ticket_number ?? 'XXXXX' }}</p>
                        <div class="mt-1 bg-gray-50 text-gray-700 font-medium text-xxs py-0.5 px-2 rounded border border-gray-100 truncate">🎁 {{ $rankData->prize_title_won ?? 'Steel Dinner Set' }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- --- CENTRAL RESULTS LOOKUP WORKSPACE --- -->
        <div class="bg-white p-6 md:p-8 rounded-b-xl shadow-lg border-x border-b border-gray-200">
            <div class="border-b border-gray-200 pb-3 mb-6 text-center">
                <h3 class="text-lg font-black text-gray-800">Check Individual Examination Result Matrix</h3>
                <p class="text-xs text-gray-500 mt-0.5">Please provide your unique 11-digit credential string to fetch scores.</p>
            </div>

            <!-- Inbound Search Input Module -->
            <form id="result_search_form" onsubmit="executeResultSearch(event)" class="max-w-md mx-auto space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 text-center">Enter 11-Digit Hall Ticket Number *</label>
                    <input type="text" id="search_hall_ticket" maxlength="11" required class="w-full border border-gray-300 rounded-lg px-4 py-3 text-center font-mono text-xl tracking-widest focus:ring-2 focus:ring-orange-500 outline-none shadow-inner" placeholder="20260000000">
                </div>
                <div class="text-center">
                    <button type="submit" id="btn_search_submit" class="bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-base py-2.5 px-8 rounded-lg shadow-md transition transform hover:scale-102 w-full">
                        Fetch Secured Result Logs
                    </button>
                </div>
            </form>

            <!-- DYNAMIC TARGET CONTAINER FOR RESULTS MEMO BOARD -->
            <div id="result_display_desk" class="mt-8 max-w-xl mx-auto hidden">
                <!-- Result data structure injected here dynamically -->
            </div>
        </div>
    </div>
    <!-- CORE JAVASCRIPT PIPELINES -->
    <script>
        async function executeResultSearch(event) {
            event.preventDefault();
            
            const htNumber = document.getElementById('search_hall_ticket').value;
            const displayDesk = document.getElementById('result_display_desk');
            const submitBtn = document.getElementById('btn_search_submit');

            if (!htNumber || htNumber.length !== 11) {
                alert('Please enter a valid 11-digit hall ticket credential.');
                return;
            }

            // Lock submission interface during transmission
            submitBtn.disabled = true;
            submitBtn.innerText = "Querying Database Vault...";
            displayDesk.classList.add('hidden');

            try {
                let response = await fetch("{{ route('exam.results_search') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ hall_ticket_number: htNumber })
                });
                
                let result = await response.json();
                submitBtn.disabled = false;
                submitBtn.innerText = "Fetch Secured Result Logs";

                if (result.success) {
                    // Generate dynamic safe template for official memo showcase
                    let prizeSection = result.prize 
                        ? `<div class="mt-3 bg-yellow-100 text-yellow-950 font-bold text-center border-2 border-dashed border-yellow-400 p-2 rounded animate-pulse text-sm">🎉 Winners Desk: Awarded ${result.prize}</div>`
                        : '';

                    let statusBadge = result.status === 'Passed'
                        ? `<span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full uppercase">Passed</span>`
                        : `<span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full uppercase">${result.status}</span>`;

                    displayDesk.innerHTML = `
                        <div class="bg-gray-50 border-2 border-orange-400 p-6 rounded-xl shadow-md space-y-4">
                            <div class="text-center border-b border-gray-200 pb-2">
                                <h4 class="text-base font-black text-orange-900 uppercase">Official Examination Marks Memo</h4>
                                <p class="text-xxs text-gray-400 mt-0.5">ABVHPS Evaluation Registry Node</p>
                            </div>
                            <div class="space-y-2 text-xs md:text-sm">
                                <div class="flex justify-between border-b border-dashed border-gray-100 pb-1">
                                    <span class="text-gray-400 font-medium">Candidate Name:</span>
                                    <span class="font-bold text-gray-800">${result.full_name}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-gray-100 pb-1">
                                    <span class="text-gray-400 font-medium">Hall Ticket No:</span>
                                    <span class="font-mono font-bold text-orange-600">${result.hall_ticket}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-gray-100 pb-1">
                                    <span class="text-gray-400 font-medium">Institution:</span>
                                    <span class="font-medium text-gray-700 truncate max-w-xs block">${result.school_name}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-gray-100 pb-1 pt-1">
                                    <span class="text-gray-400 font-black">Marks Obtained:</span>
                                    <span class="font-black text-gray-900 text-base">${result.marks}</span>
                                </div>
                                <div class="flex justify-between items-center pt-2">
                                    <span class="text-gray-400 font-medium">Grading Result:</span>
                                    <span>${statusBadge}</span>
                                </div>
                            </div>
                            ${prizeSection}
                        </div>
                    `;
                    displayDesk.classList.remove('hidden');
                } else {
                    alert(result.message || 'No examination record found for the provided Hall Ticket number.');
                }
            } catch (error) {
                submitBtn.disabled = false;
                submitBtn.innerText = "Fetch Result";
                console.error("Exam results retrieval error:", error);
                alert('Unable to load examination results. Please verify your connection and try again.');
            }
        }
    </script>
</body>
</html>
