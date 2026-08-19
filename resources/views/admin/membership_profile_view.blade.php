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
            
            <a href="{{ route('admin.membership.ledger') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Member Profile Detail</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- Header Title and Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-sm font-black text-brandGray uppercase tracking-wider flex items-center gap-2">
                        <span>👤</span> Member Dossier: {{ $member->full_name }}
                    </h3>
                    <p class="text-[11px] text-gray-500 font-semibold mt-0.5">Numeric ID: <span class="font-mono text-brandOrange font-bold">{{ $formattedId }}</span></p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.membership.ledger') }}" class="bg-gray-800 hover:bg-gray-900 text-white font-black text-[10px] px-4 py-2 rounded-lg shadow-sm uppercase tracking-wide transition flex items-center gap-1.5">
                        <span>←</span> Back To List
                    </a>
                    <a href="{{ route('admin.membership.idcard', $member->id) }}" target="_blank" class="bg-yellow-500 hover:bg-yellow-600 text-white font-black text-[10px] px-4 py-2 rounded-lg shadow-sm uppercase tracking-wide transition flex items-center gap-1.5">
                        <span>🖨️</span> View / Print ID Card
                    </a>
                    <a href="{{ route('admin.membership.edit', $member->id) }}" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[10px] px-4 py-2 rounded-lg shadow-sm uppercase tracking-wide transition flex items-center gap-1.5">
                        <span>✏️</span> Edit Profile
                    </a>
                </div>
            </div>

            <!-- Profile Summary Hero Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Member Photo Frame -->
                    <div class="relative shrink-0">
                        @if($member->photo_path)
                            <img src="{{ asset('storage/' . $member->photo_path) }}" class="w-32 h-36 object-cover rounded-xl border-4 border-brandOrange shadow-md" alt="Member Photo">
                        @else
                            <div class="w-32 h-36 bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400">
                                <span class="text-3xl mb-1">👤</span>
                                <span class="text-[10px] font-bold uppercase">No Photo</span>
                            </div>
                        @endif
                        <span class="absolute -bottom-2.5 left-1/2 -translate-x-1/2 bg-green-600 text-white text-[8px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow">
                            APPROVED
                        </span>
                    </div>

                    <!-- Member Core Overview -->
                    <div class="flex-1 text-center md:text-left space-y-2">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                            <div>
                                <h2 class="text-xl font-black text-gray-900 uppercase tracking-wide">{{ $member->full_name }}</h2>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Father / Husband: <span class="text-gray-800">{{ $member->father_or_husband_name ?? 'N/A' }}</span></p>
                            </div>
                            <div class="flex flex-wrap gap-1.5 justify-center md:justify-end">
                                <span class="bg-orange-50 text-brandOrange border border-orange-200 text-[10px] font-black px-3 py-1 rounded-md tracking-wider uppercase">
                                    {{ $formattedId }}
                                </span>
                                @if($member->blood_group)
                                    <span class="bg-red-50 text-red-600 border border-red-200 text-[10px] font-black px-2.5 py-1 rounded-md uppercase">
                                        🩸 {{ $member->blood_group }}
                                    </span>
                                @endif
                                <span class="bg-green-50 text-green-700 border border-green-200 text-[10px] font-black px-2.5 py-1 rounded-md uppercase">
                                    LIFETIME MEMBER
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-gray-100 text-xs">
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider">Contact Phone</span>
                                <span class="font-mono font-black text-gray-800">{{ $member->phone }}</span>
                            </div>
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider">Email Address</span>
                                <span class="font-mono font-semibold text-gray-800 truncate block">{{ $member->email ?? 'Not Provided' }}</span>
                            </div>
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider">Aadhaar Number</span>
                                <span class="font-mono font-bold text-gray-800">
                                    @if($member->aadhaar_number)
                                        {{ substr($member->aadhaar_number, 0, 4) }} {{ substr($member->aadhaar_number, 4, 4) }} {{ substr($member->aadhaar_number, 8, 4) }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Information Dossier Sections -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Section 1: Personal & Cultural Dossier -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                        <span class="text-lg">🪷</span>
                        <h4 class="text-xs font-black text-brandGray uppercase tracking-wider">Personal & Cultural Details</h4>
                    </div>

                    <div class="space-y-2.5 text-xs">
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Full Name:</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $member->full_name }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Father / Husband Name:</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $member->father_or_husband_name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Gender:</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $member->gender ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Date of Birth:</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $member->dob ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Gotram:</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $member->gotram ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Occupation:</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $member->occupation ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Blood Group:</span>
                            <span class="font-bold text-red-600">{{ $member->blood_group ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Aadhaar Card:</span>
                            <span class="font-mono font-bold text-gray-900">{{ $member->aadhaar_number ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Primary Mobile:</span>
                            <span class="font-mono font-bold text-gray-900">{{ $member->phone }}</span>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Administrative Jurisdiction & Address -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                        <span class="text-lg">🏡</span>
                        <h4 class="text-xs font-black text-brandGray uppercase tracking-wider">Jurisdiction & Location Hierarchy</h4>
                    </div>

                    <div class="space-y-2.5 text-xs">
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Grama Panchayat:</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $member->grama_panchayat ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Mandal / Taluk:</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $member->mandal ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Assembly Segment:</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $member->assembly_segment ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">District:</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $member->district ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">State & Country:</span>
                            <span class="font-bold text-gray-900 uppercase">{{ $member->state ?? 'N/A' }}, {{ $member->country ?? 'India' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-semibold uppercase text-[10px]">Postal Pincode:</span>
                            <span class="font-mono font-bold text-brandOrange">{{ $member->pincode ?? 'N/A' }}</span>
                        </div>
                        <div class="py-1">
                            <span class="block text-gray-500 font-semibold uppercase text-[10px] mb-0.5">Permanent / Present Address:</span>
                            <p class="text-gray-800 font-semibold text-[11px] leading-relaxed">
                                {{ $member->permanent_address ?? ($member->present_address ?? ($member->grama_panchayat . ', ' . $member->mandal . ', ' . $member->district . ', ' . $member->state . ' - ' . $member->pincode)) }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Section 3: Verification & Security Audit Trail -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                    <span class="text-lg">🛡️</span>
                    <h4 class="text-xs font-black text-brandGray uppercase tracking-wider">Payment & Security Audit Matrix</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-xs">
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider">Payment Status</span>
                        <span class="inline-block mt-1 bg-green-100 text-green-800 text-[10px] font-black px-2.5 py-0.5 rounded border border-green-200 uppercase">
                            ✓ {{ strtoupper($member->payment_status ?? 'SUCCESS') }}
                        </span>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider">Payment Transaction ID</span>
                        <span class="font-mono font-bold text-gray-900 block mt-1 truncate">{{ $member->payment_id ?? 'TXN-SYSTEM' }}</span>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider">Registered Timestamp</span>
                        <span class="font-mono text-gray-700 block mt-1 text-[11px]">
                            {{ $member->created_at ? \Carbon\Carbon::parse($member->created_at)->format('d-M-Y h:i A') : 'N/A' }}
                        </span>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider">Last Profile Update</span>
                        <span class="font-mono text-gray-700 block mt-1 text-[11px]">
                            {{ $member->updated_at ? \Carbon\Carbon::parse($member->updated_at)->format('d-M-Y h:i A') : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>
@endsection
