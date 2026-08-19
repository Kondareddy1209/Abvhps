@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100/60 flex flex-col md:flex-row select-none">
    
    <!-- BLOCK 1: MASTER ADMINISTRATIVE LEFT SIDEBAR CONTROLLER -->
    <div class="w-full md:w-64 bg-brandDarkGray text-white flex flex-col border-r-4 border-brandOrange shrink-0 shadow-xl">
        <div class="p-5 text-center bg-gray-900 border-b border-gray-800">
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-brandOrange shadow mx-auto mb-2 flex items-center justify-center bg-white p-0.5">
                <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS">
            </div>
            <h2 class="text-xs font-black tracking-widest text-brandOrange uppercase">ABVHPS CENTRAL BOARD</h2>
            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Master Control Panel Desk</p>
        </div>
        
        <!-- 15 Core Navigation Matrix Link Nodes -->
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
            <a href="{{ route('admin.volunteers.index') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
                <span>🤝</span> 8. VOLUNTEER DESK
            </a>
            <a href="{{ route('admin.rudrasena.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🔱</span> 9. RUDRASENA
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
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition">
                <span>⚙️</span> 15. SITE GLOBAL SETTINGS
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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Full Volunteer Profile Edit</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- Breadcrumb Navigation Bar -->
            <div class="flex items-center gap-2 text-xs font-bold text-gray-500 border-b border-gray-200 pb-3">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-brandOrange transition">Home</a>
                <span>-</span>
                <a href="{{ route('admin.volunteers.index') }}" class="text-gray-600 hover:text-brandOrange transition">Volunteer</a>
                <span>-</span>
                <span class="bg-brandOrange text-white text-[11px] font-black px-3 py-1 rounded shadow-sm uppercase tracking-wide">
                    Edit Profile #{{ $volunteer->id }}
                </span>
            </div>

            <!-- Page Title & Header -->
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-black text-brandGray tracking-tight">Edit Volunteer Application Profile</h2>
                    <p class="text-xs text-gray-400 font-semibold mt-0.5">Volunteer: <span class="text-gray-800 font-bold uppercase">{{ $volunteer->member_full_name ?? 'Volunteer' }}</span> (Member ID: {{ implode(' ', str_split($volunteer->membership_id, 4)) }})</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.volunteers.cadreEdit', $volunteer->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-black text-[10px] px-4 py-2 rounded-lg shadow-sm uppercase tracking-wide transition flex items-center gap-1">
                        <span>🎖️</span> Update Cadre / Status
                    </a>
                    <a href="{{ route('admin.volunteers.index') }}" class="bg-gray-800 hover:bg-gray-900 text-white font-black text-[10px] px-4 py-2 rounded-lg shadow-sm uppercase tracking-wide transition">
                        ← Back to List
                    </a>
                </div>
            </div>

            <!-- Error Alerts Block -->
            @if(isset($errors) && $errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs font-semibold shadow-sm">
                    <div class="font-black mb-1">Please correct the following errors:</div>
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Input Form Card -->
            <form action="{{ route('admin.volunteers.update', $volunteer->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-4xl">
                @csrf

                <!-- Section A: Identity & Contact Fields -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                        <span class="text-lg">👤</span>
                        <h3 class="text-xs font-black text-brandGray uppercase tracking-wider">Identity & Qualification</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Full Name (from Membership)</label>
                            <input type="text" readonly class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-bold text-gray-700 uppercase cursor-not-allowed" value="{{ $volunteer->member_full_name ?? 'Volunteer' }}">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Educational Qualification *</label>
                            <input type="text" name="qualification" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-semibold text-gray-900 focus:outline-none focus:border-brandOrange" placeholder="e.g. B.Tech, Graduate, PG" value="{{ old('qualification', $volunteer->qualification) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Voter ID Number *</label>
                            <input type="text" name="voter_id_number" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-mono font-bold text-gray-900 uppercase focus:outline-none focus:border-brandOrange" placeholder="e.g. ABC1234567" value="{{ old('voter_id_number', $volunteer->voter_id_number) }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Email Address *</label>
                            <input type="email" name="email" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-mono font-semibold text-gray-900 focus:outline-none focus:border-brandOrange" placeholder="volunteer@domain.com" value="{{ old('email', $volunteer->email) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Phone Number (Membership Verified)</label>
                            <input type="text" readonly class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-mono font-bold text-gray-700 cursor-not-allowed" value="{{ $volunteer->phone }}">
                        </div>
                    </div>
                </div>

                <!-- Section B: Bank Account Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                        <span class="text-lg">🏦</span>
                        <h3 class="text-xs font-black text-brandGray uppercase tracking-wider">Bank Account Information</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Bank Name *</label>
                            <input type="text" name="bank_name" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-semibold text-gray-900 focus:outline-none focus:border-brandOrange" placeholder="e.g. State Bank of India" value="{{ old('bank_name', $volunteer->bank_name) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Account Holder Name *</label>
                            <input type="text" name="account_holder_name" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-semibold text-gray-900 focus:outline-none focus:border-brandOrange" placeholder="e.g. Kasi Swamireddy" value="{{ old('account_holder_name', $volunteer->account_holder_name) }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Account Number *</label>
                            <input type="text" name="account_number" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-mono font-bold text-gray-900 focus:outline-none focus:border-brandOrange" placeholder="e.g. 123456789012" value="{{ old('account_number', $volunteer->account_number) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">IFSC Code *</label>
                            <input type="text" name="ifsc_code" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-mono font-bold text-gray-900 uppercase focus:outline-none focus:border-brandOrange" placeholder="e.g. SBIN0001234" value="{{ old('ifsc_code', $volunteer->ifsc_code) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Branch Name *</label>
                            <input type="text" name="branch_name" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-semibold text-gray-900 focus:outline-none focus:border-brandOrange" placeholder="e.g. Porumamilla" value="{{ old('branch_name', $volunteer->branch_name) }}">
                        </div>
                    </div>
                </div>

                <!-- Section C: Nominee Emergency Contact Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                        <span class="text-lg">👨‍👩‍👧</span>
                        <h3 class="text-xs font-black text-brandGray uppercase tracking-wider">Nominee Emergency Details</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Nominee Name *</label>
                            <input type="text" name="nominee_name" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-semibold text-gray-900 focus:outline-none focus:border-brandOrange" placeholder="e.g. Lakshmi" value="{{ old('nominee_name', $volunteer->nominee_name) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Nominee Relation *</label>
                            <input type="text" name="nominee_relation" required class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-semibold text-gray-900 focus:outline-none focus:border-brandOrange" placeholder="e.g. Mother, Spouse, Brother" value="{{ old('nominee_relation', $volunteer->nominee_relation) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Nominee Phone Number *</label>
                            <input type="text" name="nominee_phone" required maxlength="10" class="w-full border border-gray-300 rounded-lg px-3.5 py-2 text-xs font-mono font-bold text-gray-900 focus:outline-none focus:border-brandOrange" placeholder="e.g. 9876543210" value="{{ old('nominee_phone', $volunteer->nominee_phone) }}">
                        </div>
                    </div>
                </div>

                <!-- Section D: Uploaded Document Proofs (With Replace Option) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                        <span class="text-lg">📁</span>
                        <h3 class="text-xs font-black text-brandGray uppercase tracking-wider">Uploaded Documents & Proof Replacements</h3>
                    </div>

                    <div class="space-y-4 text-xs">
                        <!-- Doc 1: Declaration -->
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div>
                                <span class="font-black text-gray-800 block text-xs">1. Self Declaration Document</span>
                                @if($volunteer->document_declaration_path)
                                    <a href="{{ asset('storage/' . $volunteer->document_declaration_path) }}" target="_blank" class="text-brandOrange font-bold text-[10px] hover:underline mt-0.5 inline-block">
                                        📄 View Current File &rarr;
                                    </a>
                                @endif
                            </div>
                            <div class="w-full sm:w-auto">
                                <label class="block text-[9px] font-black uppercase text-gray-500 mb-1">Replace Document File</label>
                                <input type="file" name="doc_declaration" class="text-[10px] text-gray-600 file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-[10px] file:font-black file:bg-orange-100 file:text-brandOrange hover:file:bg-orange-200">
                            </div>
                        </div>

                        <!-- Doc 2: Voter ID -->
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div>
                                <span class="font-black text-gray-800 block text-xs">2. Voter ID Card Copy</span>
                                @if($volunteer->document_voter_path)
                                    <a href="{{ asset('storage/' . $volunteer->document_voter_path) }}" target="_blank" class="text-brandOrange font-bold text-[10px] hover:underline mt-0.5 inline-block">
                                        📄 View Current File &rarr;
                                    </a>
                                @endif
                            </div>
                            <div class="w-full sm:w-auto">
                                <label class="block text-[9px] font-black uppercase text-gray-500 mb-1">Replace Document File</label>
                                <input type="file" name="doc_voter" class="text-[10px] text-gray-600 file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-[10px] file:font-black file:bg-orange-100 file:text-brandOrange hover:file:bg-orange-200">
                            </div>
                        </div>

                        <!-- Doc 3: Bank Passbook -->
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div>
                                <span class="font-black text-gray-800 block text-xs">3. Bank Passbook / Cheque Copy</span>
                                @if($volunteer->document_bank_path)
                                    <a href="{{ asset('storage/' . $volunteer->document_bank_path) }}" target="_blank" class="text-brandOrange font-bold text-[10px] hover:underline mt-0.5 inline-block">
                                        📄 View Current File &rarr;
                                    </a>
                                @endif
                            </div>
                            <div class="w-full sm:w-auto">
                                <label class="block text-[9px] font-black uppercase text-gray-500 mb-1">Replace Document File</label>
                                <input type="file" name="doc_bank" class="text-[10px] text-gray-600 file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-[10px] file:font-black file:bg-orange-100 file:text-brandOrange hover:file:bg-orange-200">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Component -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.volunteers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-black text-xs px-6 py-2.5 rounded-lg uppercase tracking-wider transition">
                        Cancel
                    </a>
                    <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-xs px-8 py-2.5 rounded-lg shadow-sm uppercase tracking-wider transition flex items-center gap-1.5">
                        <span>💾</span> Save Changes
                    </button>
                </div>

            </form>

        </main>
    </div>
</div>
@endsection
