@extends('layouts.app')

@section('content')
<section class="min-h-[600px] flex flex-col items-center justify-center bg-gray-100 py-12 px-4">
    
    <!-- 1. Vertical PVC Container matching the uploaded layout dimensions structure -->
    <div class="relative w-[338px] h-[570px] bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-300" id="volunteer_pvc_card">
        
        <!-- Background Vertical Template Image saved inside public/images folder -->
        <img src="{{ asset('images/volunteer_card_bg.png') }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="Volunteer Template">

        <!-- 2. Dynamic Photo Frame Layer aligned into the clean white center space -->
        <div class="absolute top-[138px] left-[91px] w-[156px] h-[166px] z-10 overflow-hidden rounded-md border-2 border-brandOrange bg-gray-50 shadow-sm">
            @if(isset($volunteerData['photo_path']))
                <img src="{{ asset('storage/' . $volunteerData['photo_path']) }}" class="w-full h-full object-cover" alt="Volunteer Photo">
            @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-xs text-gray-400 font-bold">No Photo</div>
            @endif
        </div>

        <!-- 3. Mapped Text Records Grid Layout - Stacked nicely with compact spacing downwards -->
        <div class="absolute top-[324px] left-[32px] w-[274px] z-10 font-sans text-brandGray font-bold text-[12.5px] space-y-[8px] leading-tight">
            
                        <!-- Expanded Full Name Row centered perfectly for clean visual symmetry -->
            <div class="block w-full pb-1 text-center pr-[12px]">
                <span class="text-brandDarkGray font-black uppercase text-[15px] tracking-wide block text-center leading-none">{{ $volunteerData['full_name'] ?? 'N/A' }}</span>
            </div>

            
            <!-- Dynamic 6-Digit Random Code space formatted as 66 24 24 -->
            <div class="flex items-center">
                <span class="w-[100px] text-[11px] uppercase tracking-wide">Volunteer Id</span>
                <span class="text-brandOrange font-black tracking-widest text-sm flex-1">: {{ $volunteerData['formatted_volunteer_id'] ?? 'N/A' }}</span>
            </div>

            <!-- Designation Set manually by Admin Entry -->
            <div class="flex items-center">
                <span class="w-[100px] text-[11px] uppercase tracking-wide">Designation</span>
                <span class="text-brandDarkGray font-black uppercase text-xs flex-1">: {{ $volunteerData['designation'] ?? 'N/A' }}</span>
            </div>

            <!-- Working Locality Set manually by Admin Entry -->
            <div class="flex items-center">
                <span class="w-[100px] text-[11px] uppercase tracking-wide">Locality</span>
                <span class="text-brandDarkGray font-black uppercase text-xs flex-1">: {{ $volunteerData['locality'] ?? 'N/A' }}</span>
            </div>

            <!-- Selected Blood Group Row Block -->
            <div class="flex items-center">
                <span class="w-[100px] text-[11px] uppercase tracking-wide">Blood Group</span>
                <span class="text-red-600 font-black flex-1">: {{ $volunteerData['blood_group'] ?? 'N/A' }}</span>
            </div>

            <!-- Verified Mobile Phone Number Block -->
            <div class="flex items-center">
                <span class="w-[100px] text-[11px] uppercase tracking-wide">Phone</span>
                <span class="text-brandDarkGray font-extrabold flex-1">: +91 {{ $volunteerData['phone'] ?? 'N/A' }}</span>
            </div>
            
        </div>

        <!-- 4. Native Vector QR Code Engine - Placed centrally at the lower base layout section -->
        <div class="absolute bottom-[28px] left-[135px] w-[68px] h-[68px] bg-white border border-gray-200 p-1 z-10 flex items-center justify-center rounded shadow-sm overflow-hidden">
            @php
                $cleanCodeId = isset($volunteerData['clean_volunteer_id']) ? $volunteerData['clean_volunteer_id'] : '000000';
                $secureVerificationUrl = "https://abvhps.org" . $cleanCodeId;
            @endphp
            <!-- Directly rendering the local scannable svg matrix grid blocks -->
            {!! QrCode::size(60)->margin(0)->generate($secureVerificationUrl) !!}
        </div>

    </div>

    <!-- 5. Action Buttons Component Block -->
    <div class="mt-8 flex gap-4">
        <button onclick="window.print()" class="bg-brandOrange text-white font-bold text-xs py-2 px-6 rounded shadow uppercase tracking-wide hover:bg-opacity-90 transition">
            Print Volunteer Card
        </button>
        <a href="{{ route('admin.volunteers.index') }}" class="bg-brandGray text-white font-bold text-xs py-2 px-6 rounded shadow uppercase tracking-wide hover:bg-black transition">
            Back to Volunteer Desk
        </a>
    </div>

</section>
@endsection
