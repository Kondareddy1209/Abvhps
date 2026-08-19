@extends('layouts.app')

@section('content')
<section class="min-h-[600px] flex flex-col items-center justify-center bg-gray-100 py-12 px-4 select-none">
    
    <!-- Flash Notification / Email Dispatch Banner -->
    @if(session('last_rudrasena_email_log'))
        <div class="mb-6 max-w-[360px] w-full bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl shadow-sm text-xs font-semibold">
            <div class="flex items-center gap-2 font-black text-emerald-900 mb-1">
                <span>✓</span>
                <span>Verification Email Dispatched!</span>
            </div>
            <p class="text-[11px] text-emerald-700">
                Notification sent to <strong class="font-mono">{{ session('last_rudrasena_email_log')['recipient_email'] }}</strong>.
            </p>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 max-w-[360px] w-full bg-green-50 border border-green-200 text-green-800 p-4 rounded-xl shadow-sm text-xs font-semibold">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 1. Vertical PVC Container matching Rudrasena Card specifications -->
    <div class="relative w-[338px] h-[570px] bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-300" id="rudrasena_pvc_card">
        
        <!-- Background Template Image saved in public/images folder -->
        <img src="{{ asset('images/rudrasena_card_bg.png') }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="Rudrasena Template">

        <!-- Status Watermark Ribbon if Pending -->
        @if(($cardData['status'] ?? 'pending') !== 'verified')
            <div class="absolute top-4 right-4 z-20 bg-amber-500/90 text-white text-[8px] font-black uppercase px-2 py-0.5 rounded shadow">
                Pending Approval
            </div>
        @endif

        <!-- 2. Dynamic Photo Frame Layer aligned into template frame -->
        <div class="absolute top-[138px] left-[91px] w-[156px] h-[166px] z-10 overflow-hidden rounded-md border-2 border-brandOrange bg-gray-50 shadow-sm">
            @if(!empty($cardData['photo_path']))
                <img src="{{ asset('storage/' . $cardData['photo_path']) }}" class="w-full h-full object-cover" alt="Rudrasena Member Photo">
            @else
                <div class="w-full h-full bg-gray-200 flex flex-col items-center justify-center text-xs text-gray-400 font-bold">
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-white border border-gray-300 flex items-center justify-center p-0.5 mb-1">
                        <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
                    </div>
                    <span>No Photo</span>
                </div>
            @endif
        </div>

        <!-- 3. Mapped Text Records Grid Layout -->
        <div class="absolute top-[324px] left-[24px] w-[290px] z-10 font-sans text-brandGray font-bold text-[12px] space-y-[7px] leading-tight">
            
            <!-- Full Name Row -->
            <div class="block w-full pb-1 text-center pr-[6px]">
                <span class="text-brandDarkGray font-black uppercase text-[14px] tracking-wide block text-center leading-tight truncate" title="{{ $cardData['full_name'] ?? 'N/A' }}">
                    {{ $cardData['full_name'] ?? 'N/A' }}
                </span>
            </div>

            <!-- Rudrasena ID Code -->
            <div class="flex items-center">
                <span class="w-[95px] text-[10.5px] uppercase tracking-wide shrink-0">Rudrasena Id</span>
                <span class="text-brandOrange font-black tracking-normal text-[13px] flex-1 font-mono">
                    : {{ $cardData['rudrasena_id'] ?: 'PENDING APPROVAL' }}
                </span>
            </div>

            <!-- Member ID -->
            <div class="flex items-center">
                <span class="w-[95px] text-[10.5px] uppercase tracking-wide shrink-0">Member Id</span>
                <span class="text-brandDarkGray font-bold text-[11px] flex-1 font-mono">
                    : {{ $cardData['membership_id'] ?? 'N/A' }}
                </span>
            </div>

            <!-- Cadder / Designation -->
            <div class="flex items-center">
                <span class="w-[95px] text-[10.5px] uppercase tracking-wide shrink-0">Cadder</span>
                <span class="text-brandDarkGray font-black uppercase text-[11px] flex-1 truncate" title="{{ $cardData['assigned_cadder'] ?? 'N/A' }}">
                    : {{ $cardData['assigned_cadder'] ?: 'Rudrasena Member' }}
                </span>
            </div>

            <!-- Locality -->
            <div class="flex items-center">
                <span class="w-[95px] text-[10.5px] uppercase tracking-wide shrink-0">Locality</span>
                <span class="text-brandDarkGray font-black uppercase text-[11px] flex-1 truncate" title="{{ $cardData['assigned_locality'] ?? 'N/A' }}">
                    : {{ $cardData['assigned_locality'] ?: 'HQ' }}
                </span>
            </div>

            <!-- Blood Group -->
            @if(!empty($cardData['blood_group']))
                <div class="flex items-center">
                    <span class="w-[95px] text-[10.5px] uppercase tracking-wide shrink-0">Blood Group</span>
                    <span class="text-red-600 font-black text-[11px] flex-1">
                        : {{ $cardData['blood_group'] }}
                    </span>
                </div>
            @endif
            
        </div>

        <!-- 4. Dynamic Anti-Fraud QR Code Engine -->
        <div class="absolute bottom-[28px] left-[135px] w-[68px] h-[68px] bg-white border border-gray-200 p-1 z-10 flex items-center justify-center rounded shadow-sm overflow-hidden">
            @php
                $rudraId = $cardData['rudrasena_id'] ?? 'RS0000';
                $secureVerificationUrl = url('/verify/rudrasena/' . $rudraId);
            @endphp
            {!! QrCode::size(60)->margin(0)->generate($secureVerificationUrl) !!}
        </div>

    </div>

    <!-- 5. Action Buttons Block -->
    <div class="mt-8 flex gap-4">
        <button onclick="window.print()" class="bg-brandOrange text-white font-bold text-xs py-2.5 px-6 rounded-lg shadow uppercase tracking-wide hover:bg-opacity-90 transition cursor-pointer">
            Print ID Card
        </button>
        <a href="{{ route('admin.rudrasena.index') }}" class="bg-brandGray text-white font-bold text-xs py-2.5 px-6 rounded-lg shadow uppercase tracking-wide hover:bg-black transition flex items-center">
            Back to Rudrasena Roster
        </a>
    </div>

</section>
@endsection
