@extends('layouts.app')

@section('content')
<section class="min-h-[500px] flex flex-col items-center justify-center bg-gray-100 py-12 px-4">
    
    <!-- 1. Automated Email Dispatch Notification Alert Box Component -->
    @if(session('last_email_log'))
        <div class="mb-6 max-w-[600px] w-full bg-orange-50 border-l-4 border-brandOrange p-4 rounded-r shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="text-brandOrange text-lg">🪷</span>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-bold text-brandGray uppercase tracking-wide">Divine Welcome Email Dispatched</p>
                    <p class="mt-1 text-xs text-gray-600 leading-relaxed">
                        A beautiful heart touching welcome message along with this Digital PVC ID Card attachment has been successfully sent to <strong class="text-brandOrange">{{ session('last_email_log')['recipient_email'] }}</strong> in your state language layout (<strong class="uppercase text-brandGray">{{ session('last_email_log')['assigned_language'] }}</strong>).
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- 2. PVC Card Container Area -->
    <div class="relative w-[600px] h-[338px] bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-300" id="membership_pvc_card">
        
        <!-- Background Template Image inside public assets folder -->
        <img src="{{ asset('images/membership_card_bg.png') }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="ABVHPS Card Template">

                <!-- 3. Dynamic Photo Frame Layer -->
        <div class="absolute top-[148px] left-[20px] w-[156px] h-[166px] z-10 overflow-hidden rounded-md border-2 border-brandOrange">
            @if(isset($memberData['photo_path']))
                <!-- Fixed White Sides Issue: Changed object-contain to object-fill -->
                <img src="{{ asset('storage/' . $memberData['photo_path']) }}" class="w-full h-full object-fill" alt="Member Photo">
            @else
                <div class="w-full h-full bg-gray-300 flex items-center justify-center text-xs text-gray-500 font-bold">No Photo</div>
            @endif
        </div>


        <!-- 4. Member Text Records Grid Components -->
        <div class="absolute top-[130px] left-[216px] z-10 font-sans text-brandGray font-bold text-sm space-y-[7px] leading-tight">
            
            <!-- Full Name Row Block -->
            <div class="flex items-start">
                <span class="w-[110px] text-xs uppercase tracking-wide pt-[2px]">Name</span>
                <span class="text-brandDarkGray font-black uppercase text-sm max-w-[240px] whitespace-normal break-words leading-none">: {{ $memberData['full_name'] ?? 'N/A' }}</span>
            </div>
            
            <!-- 12-Digit Membership ID Row Block -->
            <div class="flex items-center">
                <span class="w-[110px] text-xs uppercase tracking-wide">Membership Id</span>
                <span class="text-brandOrange font-black tracking-widest text-sm">: {{ $memberData['formatted_id'] ?? 'N/A' }}</span>
            </div>

            <!-- Phone Block Row -->
            <div class="flex items-center">
                <span class="w-[110px] text-xs uppercase tracking-wide">Phone</span>
                <span class="text-brandDarkGray font-extrabold">: {{ $memberData['phone'] ?? 'N/A' }}</span>
            </div>

            <!-- Date Of Birth Block Row -->
            <div class="flex items-center">
                <span class="w-[110px] text-xs uppercase tracking-wide">Date Of Birth</span>
                <span class="text-brandDarkGray font-extrabold">: {{ $memberData['dob'] ?? 'N/A' }}</span>
            </div>

            <!-- Selected Blood Group Row -->
            <div class="flex items-center">
                <span class="w-[110px] text-xs uppercase tracking-wide">Blood Group</span>
                <span class="text-red-600 font-black text-sm">: {{ $memberData['blood_group'] ?? 'N/A' }}</span>
            </div>

            <!-- S-Aligned Address Layout Structure Grid Components -->
            <div class="flex items-start">
                <span class="w-[110px] text-xs uppercase tracking-wide pt-[1px]">Address</span>
                <div class="text-brandDarkGray font-black text-[10.5px] max-w-[270px] whitespace-normal break-words leading-normal uppercase flex flex-col">
                    <span>: {{ $memberData['grama_panchayat'] ?? 'SHANMUKHAPURAM' }}, {{ $memberData['mandal'] ?? 'PORUMAMILLA' }},</span>
                    <span class="pl-1.5">{{ $memberData['assembly_segment'] ?? 'BADVEL' }}, {{ $memberData['district'] ?? 'KADAPA' }}, {{ $memberData['state'] ?? 'ANDHRA PRADESH' }},</span>
                    <span class="pl-1.5 text-brandDarkGray font-black">{{ $memberData['country'] ?? 'INDIA' }} - {{ $memberData['pincode'] ?? '516193' }}</span>
                </div>
            </div>
        </div>

        <!-- 5. Official Secure Online Verification QR Code Engine Component -->
        <div class="absolute top-[182px] left-[505px] w-[68px] h-[68px] bg-white border border-gray-200 p-1 z-10 flex items-center justify-center rounded shadow-sm overflow-hidden">
            @php
                $cleanMemberTrackingId = isset($memberData['formatted_id']) ? str_replace(' ', '', $memberData['formatted_id']) : '000000000000';
                $secureVerificationUrl = "https://abvhps.org" . $cleanMemberTrackingId;
            @endphp
            {!! QrCode::size(60)->margin(0)->generate($secureVerificationUrl) !!}
        </div>

    </div>

    <!-- 6. Action Buttons Block Component -->
    <div class="mt-8 flex gap-4">
        <button onclick="window.print()" class="bg-brandOrange text-white font-bold text-xs py-2 px-6 rounded shadow uppercase tracking-wide hover:bg-opacity-90 transition">
            Print ID Card
        </button>
        <a href="/membership" class="bg-brandGray text-white font-bold text-xs py-2 px-6 rounded shadow uppercase tracking-wide hover:bg-black transition">
            Back to Home
        </a>
    </div>

</section>
@endsection
