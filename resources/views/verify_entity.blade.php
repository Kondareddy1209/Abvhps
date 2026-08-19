@extends('layouts.app')

@section('title', 'Official Identity Verification | ABVHPS')
@section('meta_robots', 'noindex, nofollow')
@section('meta_description', 'Official public credential and document verification portal of ABVHPS.')

@section('content')
<section class="min-h-[70vh] bg-slate-50 py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        
        {{-- Institutional Header Banner --}}
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white p-6 text-center relative border-b-4 border-orange-600">
            <div class="w-14 h-14 rounded-full overflow-hidden bg-white border-2 border-orange-500 shadow-md mx-auto mb-2 flex items-center justify-center p-0.5">
                <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
            </div>
            <h1 class="text-sm sm:text-base font-black tracking-wider uppercase text-orange-400">
                AKHANDA BHARATHA VISWA HINDU PARIRAKSHANA SAMITI
            </h1>
            <p class="text-[11px] text-slate-300 font-semibold uppercase tracking-widest mt-0.5">
                Central Accreditation &amp; Public Identity Verification System
            </p>
        </div>

        {{-- Verification Result Box --}}
        <div class="p-6 sm:p-8 space-y-6">
            
            @if($isValid)
                {{-- Status Banner --}}
                <div class="text-center space-y-2">
                    <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full {{ $isApproved ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }} text-xs font-black uppercase tracking-wider shadow-xs">
                        <span class="w-2 h-2 rounded-full {{ $isApproved ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500' }}"></span>
                        {{ $status }}
                    </div>
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">
                        {{ $entityType }}
                    </h2>
                </div>

                {{-- Profile / Photo Frame (if available) --}}
                @if(!empty($photoPath) && \Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath))
                    <div class="flex justify-center">
                        <div class="w-24 h-28 rounded-2xl overflow-hidden border-2 border-orange-500 shadow-md bg-slate-100">
                            <img src="{{ asset('storage/' . $photoPath) }}" alt="{{ $name }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif

                {{-- Official Credential Dossier Table --}}
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 space-y-3 text-xs">
                    
                    {{-- Official ID --}}
                    <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                        <span class="font-bold text-slate-500 uppercase tracking-wider text-[11px]">{{ $officialIdLabel ?? 'Official ID' }}</span>
                        <span class="font-mono font-black text-orange-600 text-base tracking-wider">{{ $officialId }}</span>
                    </div>

                    {{-- Full Name / Group Name --}}
                    <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                        <span class="font-bold text-slate-500 uppercase tracking-wider text-[11px]">Full Name / Title</span>
                        <span class="font-black text-slate-900 uppercase text-right max-w-[60%]">{{ $name }}</span>
                    </div>

                    {{-- Cadre / Category --}}
                    @if(!empty($cadre))
                        <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                            <span class="font-bold text-slate-500 uppercase tracking-wider text-[11px]">Role / Cadre</span>
                            <span class="font-bold text-slate-800 uppercase text-right">{{ $cadre }}</span>
                        </div>
                    @endif

                    {{-- Geographic Jurisdiction / Center --}}
                    @if(!empty($location))
                        <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                            <span class="font-bold text-slate-500 uppercase tracking-wider text-[11px]">Jurisdiction</span>
                            <span class="font-bold text-slate-800 text-right max-w-[60%]">{{ $location }}</span>
                        </div>
                    @endif

                    {{-- Blood Group (if appropriate) --}}
                    @if(!empty($bloodGroup))
                        <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                            <span class="font-bold text-slate-500 uppercase tracking-wider text-[11px]">Blood Group</span>
                            <span class="font-black text-red-600 uppercase">{{ $bloodGroup }}</span>
                        </div>
                    @endif

                    {{-- Extra Detail (Exam Date, Farmers Crops, etc.) --}}
                    @if(!empty($examDate))
                        <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                            <span class="font-bold text-slate-500 uppercase tracking-wider text-[11px]">Exam Schedule</span>
                            <span class="font-bold text-slate-800 text-right">{{ $examDate }}</span>
                        </div>
                    @endif

                    @if(!empty($extraDetail))
                        <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                            <span class="font-bold text-slate-500 uppercase tracking-wider text-[11px]">Group Details</span>
                            <span class="font-bold text-slate-700 text-right text-[11px]">{{ $extraDetail }}</span>
                        </div>
                    @endif

                    {{-- Verification Record --}}
                    <div class="flex justify-between items-center pt-1">
                        <span class="font-bold text-slate-500 uppercase tracking-wider text-[10px]">Accreditation Date</span>
                        <span class="font-semibold text-slate-600 text-[11px]">{{ $verifiedSince ?? 'Official Registry' }}</span>
                    </div>

                </div>

                {{-- Anti-Fraud Assurance Notice --}}
                <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100 flex items-center gap-3">
                    <span class="text-xl">🛡️</span>
                    <p class="text-[11px] text-emerald-900 font-bold leading-tight">
                        Authenticity Verified: This credential has been cryptographically validated against the official ABVHPS Central Registry.
                    </p>
                </div>

            @else

                {{-- Failed / Invalid Record Screen --}}
                <div class="text-center space-y-3 py-4">
                    <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto text-2xl font-black shadow-inner">
                        ✕
                    </div>
                    <h2 class="text-lg font-black text-slate-900 uppercase">
                        Verification Failed
                    </h2>
                    <p class="text-xs text-rose-700 font-semibold bg-rose-50 p-4 rounded-xl border border-rose-200 leading-relaxed">
                        {{ $errorMessage ?? 'The scanned credential could not be authenticated against the ABVHPS central database.' }}
                    </p>
                    <p class="text-[11px] text-slate-400 font-medium">
                        If you believe this is an administrative discrepancy, please reach out to the ABVHPS Central Secretariat.
                    </p>
                </div>

            @endif

            {{-- Footer Action --}}
            <div class="text-center pt-2">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-black text-orange-600 hover:text-orange-700 uppercase tracking-wider">
                    <span>&larr; Return to ABVHPS Official Portal</span>
                </a>
            </div>

        </div>

        {{-- Legal Footer Strip --}}
        <div class="bg-slate-100 p-4 text-center border-t border-slate-200">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                &copy; {{ date('Y') }} Akhanda Bharatha Viswa Hindu Parirakshana Samiti. Survey No: 1826, Porumamilla, Kadapa, AP.
            </p>
        </div>

    </div>
</section>
@endsection
