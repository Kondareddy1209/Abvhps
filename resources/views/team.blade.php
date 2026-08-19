@extends('layouts.app')

@section('title', 'Our Team & Leadership Directory | ABVHPS')
@section('meta_description', 'Directory of approved and active ABVHPS volunteers, cadres, and leadership representatives serving nationwide.')

@section('content')
<div class="bg-gray-50 min-h-screen pb-16">

    @php
        $teamBanner = \App\Models\Banner::getBannerForPage('team');
    @endphp

    {{-- Official Header Banner with Dynamic Admin Management and Fallback --}}
    <div class="relative border-b-4 border-brandOrange shadow-md overflow-hidden"
         style="min-height: 420px; @if(!$teamBanner) background-image: url('{{ asset('images/ourteam_bg.png') }}'); background-size: cover; background-repeat: no-repeat; background-position: center center; @endif"
         data-banner-page="team">

        @if($teamBanner && !empty($teamBanner->desktop_banner))
            <picture class="absolute inset-0 w-full h-full">
                @if(!empty($teamBanner->mobile_banner))
                    <source media="(max-width: 640px)" srcset="{{ asset('storage/' . $teamBanner->mobile_banner) }}">
                @endif
                <source media="(min-width: 641px)" srcset="{{ asset('storage/' . $teamBanner->desktop_banner) }}">
                <img src="{{ asset('storage/' . $teamBanner->desktop_banner) }}"
                     alt="{{ $teamBanner->title ?? 'Our Leadership Team & Volunteer Directory' }}"
                     class="w-full h-full object-cover object-center"
                     style="z-index: 0;">
            </picture>
        @endif

        {{-- Protective tint --}}
        <div class="absolute inset-0 pointer-events-none" style="background: rgba(5, 15, 30, @if($teamBanner) 0.42 @else 0.08 @endif); z-index: 1;"></div>

        {{-- All hero content above the overlay --}}
        <div class="relative z-10 py-14 sm:py-16 px-4 text-center">
            <div class="max-w-4xl mx-auto space-y-3">

                {{-- Circular ABVHPS Logo --}}
                <div class="w-16 h-16 rounded-full overflow-hidden bg-white border-2 border-brandOrange shadow-lg mx-auto flex items-center justify-center p-0.5 shrink-0">
                    <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
                </div>

                {{-- Category Badge --}}
                <span class="bg-brandOrange/90 text-white text-[10px] sm:text-[11px] font-black px-3.5 py-1 rounded-full uppercase tracking-widest inline-block shadow-sm">
                    {{ ($teamBanner && $teamBanner->page_name) ? $teamBanner->page_name : 'Official Volunteer Directory' }}
                </span>

                {{-- Main Title --}}
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold uppercase tracking-wide @if($teamBanner) text-white @else text-gray-900 @endif"
                    style="text-shadow: @if($teamBanner) 0 2px 6px rgba(0,0,0,0.6) @else 0 1px 4px rgba(255,255,255,0.7), 0 0 2px rgba(255,255,255,0.5) @endif;">
                    {{ ($teamBanner && !empty($teamBanner->title)) ? $teamBanner->title : 'Our Leadership Team & Volunteer Directory' }}
                </h1>

                {{-- Subtitle --}}
                <p class="text-xs sm:text-sm @if($teamBanner) text-gray-100 @else text-gray-800 @endif max-w-2xl mx-auto font-semibold leading-relaxed"
                   style="text-shadow: @if($teamBanner) 0 1px 4px rgba(0,0,0,0.5) @else 0 1px 3px rgba(255,255,255,0.6) @endif;">
                    {{ ($teamBanner && !empty($teamBanner->subtitle)) ? $teamBanner->subtitle : 'Akhanda Bharatha Viswa Hindu Parirakshana Samiti — Central & Regional Cadre Directory' }}
                </p>

                {{-- Summary Stat Badge --}}
                <div class="pt-1">
                    <span class="bg-white/90 border border-brandOrange/40 text-gray-900 text-xs font-bold px-4 py-1.5 rounded-full inline-flex items-center gap-2 shadow-sm backdrop-blur-sm">
                        <span>👥 Total Approved Volunteers:</span>
                        <span class="font-mono font-black text-brandOrange">{{ $totalApprovedCount }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Directory Container --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-6">

        {{-- Active Hierarchy Breadcrumb --}}
        <div class="bg-white border border-gray-200 rounded-xl p-3 px-5 shadow-sm text-xs flex flex-wrap items-center gap-2 text-gray-600">
            <span class="font-bold text-gray-400 uppercase tracking-wider text-[10px]">Hierarchy:</span>
            <a href="{{ route('public.team') }}" class="font-bold text-brandOrange hover:underline">Global Directory</a>

            @if($selectedCountry)
                <span class="text-gray-300">›</span>
                <span class="font-bold text-gray-800">{{ $selectedCountry }}</span>
            @endif

            @if($selectedState)
                <span class="text-gray-300">›</span>
                <span class="font-bold text-gray-800">{{ $selectedState }}</span>
            @endif

            @if($selectedDistrict)
                <span class="text-gray-300">›</span>
                <span class="font-bold text-gray-800">{{ $selectedDistrict }} District</span>
            @endif

            @if($selectedAssembly)
                <span class="text-gray-300">›</span>
                <span class="font-bold text-gray-800">{{ $selectedAssembly }} Segment</span>
            @endif

            @if($selectedMandal)
                <span class="text-gray-300">›</span>
                <span class="font-bold text-gray-800">{{ $selectedMandal }} Mandal</span>
            @endif

            @if($selectedPanchayat)
                <span class="text-gray-300">›</span>
                <span class="font-bold text-gray-800">{{ $selectedPanchayat }} GP</span>
            @endif

            @if($selectedCadre)
                <span class="ml-auto bg-orange-100 text-brandOrange border border-orange-200 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase">
                    Cadre: {{ $selectedCadre }}
                </span>
            @endif
        </div>

        {{-- Cascading Filter & Search Desk --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <form method="GET" action="{{ route('public.team') }}" id="directory_filter_form" class="space-y-4">

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 border-b border-gray-100 pb-3">
                    <h3 class="text-xs font-black uppercase tracking-wider text-gray-700 flex items-center gap-1.5">
                        <span>🔍</span> Filter &amp; Search Volunteer Matrix
                    </h3>
                    @if($selectedCadre || $selectedCountry || $selectedState || $selectedDistrict || $selectedAssembly || $selectedMandal || $selectedPanchayat || $searchQuery)
                        <a href="{{ route('public.team') }}" class="text-xs text-rose-600 font-bold hover:underline">
                            ✕ Reset All Filters
                        </a>
                    @endif
                </div>

                {{-- Filter Controls Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 text-xs">

                    {{-- 1. Cadre --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Cadre Level</label>
                        <select name="cadre" onchange="document.getElementById('directory_filter_form').submit()"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-2.5 py-2 text-xs font-semibold text-gray-800 focus:bg-white focus:border-orange-500 focus:outline-none">
                            <option value="">All Cadres</option>
                            @foreach($cadres as $c)
                                <option value="{{ $c }}" {{ $selectedCadre === $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 2. Country --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Country</label>
                        <select name="country" onchange="document.getElementById('directory_filter_form').submit()"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-2.5 py-2 text-xs font-semibold text-gray-800 focus:bg-white focus:border-orange-500 focus:outline-none">
                            <option value="">All Countries</option>
                            @foreach($countries as $cntry)
                                <option value="{{ $cntry }}" {{ $selectedCountry === $cntry ? 'selected' : '' }}>{{ $cntry }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 3. State --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">State</label>
                        <select name="state" onchange="document.getElementById('directory_filter_form').submit()"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-2.5 py-2 text-xs font-semibold text-gray-800 focus:bg-white focus:border-orange-500 focus:outline-none">
                            <option value="">All States</option>
                            @foreach($states as $st)
                                <option value="{{ $st }}" {{ $selectedState === $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 4. District --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">District</label>
                        <select name="district" onchange="document.getElementById('directory_filter_form').submit()"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-2.5 py-2 text-xs font-semibold text-gray-800 focus:bg-white focus:border-orange-500 focus:outline-none">
                            <option value="">All Districts</option>
                            @foreach($districts as $dst)
                                <option value="{{ $dst }}" {{ $selectedDistrict === $dst ? 'selected' : '' }}>{{ $dst }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 5. Assembly / Taluk --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Taluk / Segment</label>
                        <select name="assembly_segment" onchange="document.getElementById('directory_filter_form').submit()"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-2.5 py-2 text-xs font-semibold text-gray-800 focus:bg-white focus:border-orange-500 focus:outline-none">
                            <option value="">All Segments</option>
                            @foreach($assemblies as $asmb)
                                <option value="{{ $asmb }}" {{ $selectedAssembly === $asmb ? 'selected' : '' }}>{{ $asmb }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 6. Mandal --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Mandal</label>
                        <select name="mandal" onchange="document.getElementById('directory_filter_form').submit()"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-2.5 py-2 text-xs font-semibold text-gray-800 focus:bg-white focus:border-orange-500 focus:outline-none">
                            <option value="">All Mandals</option>
                            @foreach($mandals as $mndl)
                                <option value="{{ $mndl }}" {{ $selectedMandal === $mndl ? 'selected' : '' }}>{{ $mndl }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 7. Panchayat --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Panchayat</label>
                        <select name="panchayat" onchange="document.getElementById('directory_filter_form').submit()"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-2.5 py-2 text-xs font-semibold text-gray-800 focus:bg-white focus:border-orange-500 focus:outline-none">
                            <option value="">All Panchayats</option>
                            @foreach($panchayats as $pnch)
                                <option value="{{ $pnch }}" {{ $selectedPanchayat === $pnch ? 'selected' : '' }}>{{ $pnch }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- Keyword Search Row --}}
                <div class="flex gap-2 pt-1">
                    <input type="text" name="search" value="{{ $searchQuery }}"
                           placeholder="Search by Volunteer Name, ID, Cadre, District, Mandal..."
                           class="flex-1 bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-800 focus:bg-white focus:border-orange-500 focus:outline-none">
                    <button type="submit"
                            class="bg-brandOrange hover:bg-orange-700 text-white font-black text-xs px-5 py-2 rounded-lg uppercase tracking-wider shadow transition">
                        Search
                    </button>
                </div>

            </form>
        </div>

        {{-- Volunteer Cards Grid --}}
        @if($volunteers->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center shadow-sm">
                <div class="text-4xl mb-3">👥</div>
                <h3 class="text-base font-black text-gray-800 uppercase tracking-wider">No Approved Volunteers Found</h3>
                <p class="text-xs text-gray-500 max-w-md mx-auto mt-1">
                    @if($selectedCadre || $selectedCountry || $selectedState || $selectedDistrict || $selectedAssembly || $selectedMandal || $selectedPanchayat || $searchQuery)
                        No approved volunteers matched your specific filter criteria. Try selecting broader locations or clearing filters.
                    @else
                        Approved organizational volunteers will be displayed here once verified through the administrative desk.
                    @endif
                </p>
                @if($selectedCadre || $selectedCountry || $selectedState || $selectedDistrict || $selectedAssembly || $selectedMandal || $selectedPanchayat || $searchQuery)
                    <div class="mt-4">
                        <a href="{{ route('public.team') }}" class="inline-block bg-gray-800 text-white text-xs font-bold px-4 py-2 rounded-lg uppercase">
                            View All Volunteers
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($volunteers as $vol)
                    @php
                        $fullName    = $vol->full_name;
                        $photoPath   = $vol->photo_path;
                        $volId       = $vol->volunteer_id;
                        $cadreLabel  = $vol->cadre_label;
                        $country     = $vol->resolved_country;
                        $state       = $vol->resolved_state;
                        $district    = $vol->resolved_district;
                        $mandal      = $vol->resolved_mandal;
                        $panchayat   = $vol->resolved_grama_panchayat;
                        $locality    = $vol->locality;
                    @endphp
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-gray-200 overflow-hidden flex flex-col justify-between transition duration-200">

                        {{-- Card Header & Photo Area --}}
                        <div class="p-5 text-center flex flex-col items-center bg-gradient-to-b from-orange-50/60 to-white border-b border-gray-100">

                            {{-- Volunteer Photo or Fallback Avatar --}}
                            <div class="w-24 h-28 rounded-xl border-2 border-orange-200 shadow-sm overflow-hidden bg-gray-100 mb-3 relative flex items-center justify-center">
                                @if($photoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath))
                                    <img src="{{ asset('storage/' . $photoPath) }}" alt="{{ $fullName }}" class="w-full h-full object-cover">
                                @elseif($photoPath && file_exists(public_path('storage/' . $photoPath)))
                                    <img src="{{ asset('storage/' . $photoPath) }}" alt="{{ $fullName }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-orange-100/60 text-brandOrange">
                                        <span class="text-3xl">👤</span>
                                        <span class="text-[9px] font-black uppercase mt-1">Volunteer</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Volunteer Name --}}
                            <h4 class="font-black text-gray-900 text-sm uppercase leading-tight line-clamp-1">
                                {{ $fullName }}
                            </h4>

                            {{-- Volunteer ID Tag --}}
                            <div class="mt-1">
                                @if($volId)
                                    <span class="font-mono text-[10px] font-black text-orange-950 bg-yellow-400 px-2 py-0.5 rounded uppercase tracking-wider border border-yellow-500 shadow-xs">
                                        VOLUNTEER ID: {{ $volId }}
                                    </span>
                                @else
                                    <span class="font-mono text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded uppercase">
                                        Active Volunteer
                                    </span>
                                @endif
                            </div>

                            {{-- Cadre / Designation Badge --}}
                            <div class="mt-2">
                                <span class="bg-orange-100 text-brandOrange border border-orange-200 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wide inline-block">
                                    {{ $cadreLabel }}
                                </span>
                            </div>
                        </div>

                        {{-- Card Body: Regional Details --}}
                        <div class="p-4 text-xs space-y-1.5 bg-white">
                            @if($district)
                                <div class="flex items-center justify-between text-gray-600 border-b border-gray-50 pb-1">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">District:</span>
                                    <span class="font-bold text-gray-800">{{ $district }}</span>
                                </div>
                            @endif

                            @if($mandal)
                                <div class="flex items-center justify-between text-gray-600 border-b border-gray-50 pb-1">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Mandal:</span>
                                    <span class="font-medium text-gray-800">{{ $mandal }}</span>
                                </div>
                            @endif

                            @if($panchayat)
                                <div class="flex items-center justify-between text-gray-600 border-b border-gray-50 pb-1">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Panchayat:</span>
                                    <span class="font-medium text-gray-800 truncate max-w-[60%] text-right">{{ $panchayat }}</span>
                                </div>
                            @endif

                            @if($state)
                                <div class="flex items-center justify-between text-gray-600">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">State:</span>
                                    <span class="font-semibold text-gray-700">{{ $state }}@if($country && $country !== 'India'), {{ $country }}@endif</span>
                                </div>
                            @endif
                        </div>

                        {{-- Card Footer --}}
                        <div class="px-4 py-2.5 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-[10px]">
                            <span class="text-emerald-700 font-black flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                                Verified Volunteer
                            </span>
                            <span class="text-gray-400 font-mono">ABVHPS</span>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- Pagination Links --}}
            @if($volunteers->hasPages())
                <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs shadow-sm">
                    <span class="text-gray-500 font-medium">
                        Showing {{ $volunteers->firstItem() }} to {{ $volunteers->lastItem() }} of {{ $volunteers->total() }} approved volunteers
                    </span>
                    <div>
                        {{ $volunteers->links() }}
                    </div>
                </div>
            @endif
        @endif

    </div>

</div>
@endsection
