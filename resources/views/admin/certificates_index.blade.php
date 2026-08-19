<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation & Tax Certificates Core | ABVHPS Central Board</title>
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
            <a href="{{ route('admin.exams.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📝</span> 11. EXAMS INFO BOARD
            </a>
            <a href="{{ route('admin.fundraising.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📢</span> 12. FUNDRAISING MATRICES
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📩</span> 13. CONTACT FORMS AUDIT
            </a>
            <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
                <span>📜</span> 14. TAX CERTIFICATES
            </a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>⚙️</span> 15. SITE GLOBAL SETTINGS
            </a>
            <a href="{{ route('admin.banner.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition">
                <span>🚩</span> 16. BANNER MANAGEMENT
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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">14. Donation & Tax Compliance Certificates</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('public.certificates') }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-black px-3 py-1.5 rounded-lg border border-gray-300 uppercase transition flex items-center gap-1">
                    <span>🌐</span> View Public Compliance Desk
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

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left: Upload Form (4 Cols) -->
                <div class="lg:col-span-4 bg-white p-5 rounded-xl border border-gray-200 shadow-sm space-y-4 text-xs">
                    <div class="border-b border-gray-100 pb-3">
                        <h3 class="font-black text-sm text-gray-900 uppercase">Upload Compliance PDF</h3>
                        <p class="text-[10px] text-gray-500">Official legal documents: 12A, 80G, CSR-1, NGO Darpan, Trust Deed.</p>
                    </div>

                    <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf

                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">Document Title *</label>
                            <input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="e.g. 12A Income Tax Exemption">
                        </div>

                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">Certificate Type *</label>
                            <select name="certificate_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                                <option value="Section 12A">Section 12A Tax Exemption</option>
                                <option value="Section 80G">Section 80G Tax Deduction</option>
                                <option value="CSR-1">CSR-1 MCA Registration</option>
                                <option value="NGO Darpan">NITI Aayog NGO Darpan</option>
                                <option value="Trust Registration">Trust Registration Deed</option>
                                <option value="PAN & TAN">Trust PAN & TAN Certificate</option>
                                <option value="Other Compliance">Other Statutory Certificate</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">Registration / Order Number</label>
                            <input type="text" name="document_number" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-mono font-bold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="e.g. AABTA1234F20231">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-black text-gray-700 uppercase mb-1">Valid From</label>
                                <input type="date" name="valid_from" class="w-full border border-gray-300 rounded-lg px-2.5 py-1.5 text-xs text-gray-700">
                            </div>
                            <div>
                                <label class="block font-black text-gray-700 uppercase mb-1">Valid To / Lifetime</label>
                                <input type="date" name="valid_to" class="w-full border border-gray-300 rounded-lg px-2.5 py-1.5 text-xs text-gray-700">
                            </div>
                        </div>

                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">Upload PDF File *</label>
                            <input type="file" name="certificate_pdf" accept="application/pdf" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-600">
                            <span class="text-[10px] text-gray-400">PDF document format (Max: 15MB)</span>
                        </div>

                        <div>
                            <label class="block font-black text-gray-700 uppercase mb-1">Description / Notes</label>
                            <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold text-gray-800" placeholder="Brief note on tax deduction eligibility or statutory validity..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-brandOrange hover:bg-orange-700 text-white font-black text-xs py-2.5 rounded-lg shadow uppercase transition">
                            Upload Official Certificate
                        </button>
                    </form>
                </div>

                <!-- Right: Active Certificates Table (8 Cols) -->
                <div class="lg:col-span-8 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col justify-between">
                    <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                        <h3 class="font-black text-xs text-gray-700 uppercase tracking-wider">
                            Active Statutory Compliance Repository
                        </h3>
                        <span class="text-xs font-black text-brandOrange">{{ $certificates->count() }} Certificates Registered</span>
                    </div>

                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200 text-gray-400 font-black uppercase text-[10px] tracking-wider">
                                    <th class="p-3.5">Certificate Title</th>
                                    <th class="p-3.5">Category</th>
                                    <th class="p-3.5">Order / Doc No.</th>
                                    <th class="p-3.5 text-center">Status</th>
                                    <th class="p-3.5 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 font-medium">
                                @forelse($certificates as $cert)
                                    <tr class="hover:bg-orange-50/30 transition">
                                        <td class="p-3.5">
                                            <div class="font-bold text-gray-900 uppercase">{{ $cert->title }}</div>
                                            <div class="text-[10px] text-gray-400 font-mono">
                                                Validity: {{ $cert->valid_from ? $cert->valid_from->format('d-M-Y') : 'Lifetime' }} {{ $cert->valid_to ? 'to '.$cert->valid_to->format('d-M-Y') : '' }}
                                            </div>
                                        </td>
                                        <td class="p-3.5">
                                            <span class="bg-blue-50 text-blue-700 border border-blue-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">
                                                {{ $cert->certificate_type }}
                                            </span>
                                        </td>
                                        <td class="p-3.5 font-mono text-gray-700 font-bold">
                                            {{ $cert->document_number ?? 'N/A' }}
                                        </td>
                                        <td class="p-3.5 text-center">
                                            @if($cert->is_active)
                                                <span class="bg-emerald-100 text-emerald-800 text-[9px] font-black px-2 py-0.5 rounded border border-emerald-200 uppercase">
                                                    ● Public
                                                </span>
                                            @else
                                                <span class="bg-gray-100 text-gray-600 text-[9px] font-black px-2 py-0.5 rounded uppercase">
                                                    Hidden
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-3.5 text-right space-x-1.5 whitespace-nowrap">
                                            <a href="{{ $cert->file_url }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white text-[9px] font-black px-2.5 py-1.5 rounded uppercase shadow-sm transition">
                                                View PDF
                                            </a>
                                            <form action="{{ route('admin.certificates.toggle', $cert->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-[9px] font-black px-2 py-1.5 rounded border border-gray-300 uppercase transition">
                                                    {{ $cert->is_active ? 'Hide' : 'Publish' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.certificates.delete', $cert->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this certificate?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-[9px] font-black px-2 py-1.5 rounded uppercase shadow-sm transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-8 text-center text-gray-400">
                                            No compliance certificates uploaded yet. Use the upload form on the left to add 12A, 80G, or CSR-1 documents.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
