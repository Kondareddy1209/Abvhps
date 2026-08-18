@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <!-- CENTRAL FUNDRAISING GRID HEADER HERO BANNER -->
    <div class="text-center bg-gradient-to-r from-brandDarkGray via-gray-800 to-brandDarkGray text-white p-8 rounded-2xl shadow-xl border-b-4 border-brandOrange mb-10">
        <span class="text-5xl block mb-2 drop-shadow-md">🔱</span>
        <h1 class="text-2xl md:text-4xl font-black tracking-widest uppercase text-brandOrange">DHARMA SEVA FUNDRAISING DESK</h1>
        <p class="text-gray-300 mt-2 font-semibold text-xs md:text-base max-w-2xl mx-auto leading-relaxed">
            Support our multi-parallel holy initiatives across various regions. Contribute transparently for Temple Constructions, Gosala Developments, and Sacred Idol Donations.
        </p>
    </div>

    <!-- MAIN INTERACTIVE MULTI-CAMPAIGN PARALLEL GRID MATRIX -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        @forelse($campaigns as $campaign)
            <!-- INDIVIDUAL CAMPAIGN SECURED CARD NODE -->
            <div id="campaign_{{ $campaign->id }}" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden flex flex-col justify-between transform hover:scale-[1.01] transition-all duration-300">
                
                <div>
                    <!-- Header Context Meta Badge Structure -->
                    <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                        <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                            Active Cause
                        </span>
                        <div class="flex items-center gap-1 text-[10px] font-bold text-gray-400">
                            <span>Ends:</span>
                            <span class="font-mono text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded">{{ \Carbon\Carbon::parse($campaign->end_date)->format('d-M-Y') }}</span>
                        </div>
                    </div>

                    <!-- Core Campaign Strategic Header Inscription Title -->
                    <div class="px-5 pt-4">
                        <h2 class="text-sm md:text-base font-black text-brandGray tracking-wide uppercase line-clamp-2 h-11 text-brandOrange">
                            {{ $campaign->title }}
                        </h2>
                    </div>
                    <!-- THE MASTER INTEGRATED MULTI-MEDIA VIEWPORT DESK -->
                    <div class="px-5 py-3 space-y-3">
                        
                        <!-- A. INTERACTIVE MULTI-PHOTO CAROUSEL DISPLAY (UP TO 4 IMAGES) -->
                        <div class="relative w-full h-48 bg-gray-100 rounded-xl overflow-hidden border border-gray-200 group/slider shadow-inner">
                            <div class="absolute inset-0 flex transition-transform duration-500 ease-in-out" id="carousel_track_{{ $campaign->id }}">
                                <div class="w-full h-full flex-shrink-0">
                                    <img src="{{ asset('storage/' . $campaign->cover_image) }}" class="w-full h-full object-cover">
                                </div>
                                @if($campaign->image_1)
                                    <div class="w-full h-full flex-shrink-0"><img src="{{ asset('storage/' . $campaign->image_1) }}" class="w-full h-full object-cover"></div>
                                @endif
                                @if($campaign->image_2)
                                    <div class="w-full h-full flex-shrink-0"><img src="{{ asset('storage/' . $campaign->image_2) }}" class="w-full h-full object-cover"></div>
                                @endif
                                @if($campaign->image_3)
                                    <div class="w-full h-full flex-shrink-0"><img src="{{ asset('storage/' . $campaign->image_3) }}" class="w-full h-full object-cover"></div>
                                @endif
                                @if($campaign->image_4)
                                    <div class="w-full h-full flex-shrink-0"><img src="{{ asset('storage/' . $campaign->image_4) }}" class="w-full h-full object-cover"></div>
                                @endif
                            </div>
                            <!-- Slider Arrow Anchors Desktop Indicators -->
                               <button type="button" onclick="moveCarouselSlider({{ $campaign->id }}, -1)" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-6 h-6 rounded-full text-xs font-black flex items-center justify-center opacity-0 group-hover/slider:opacity-100 transition cursor-pointer select-none">‹</button>
                               <button type="button" onclick="moveCarouselSlider({{ $campaign->id }}, 1)" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-6 h-6 rounded-full text-xs font-black flex items-center justify-center opacity-0 group-hover/slider:opacity-100 transition cursor-pointer select-none">›</button>

                            </div>

                        <!-- B. EMERGENCY CRISIS FIELD EXPLAINER VIDEO PLAYER ENGINE -->
                        @if($campaign->video_path)
                            <div class="space-y-1">
                                <span class="text-[9px] font-black text-brandOrange tracking-wider uppercase block flex items-center gap-1">🎥 Live Field Briefing Explainer Video:</span>
                                <div class="rounded-xl overflow-hidden border border-gray-200 bg-black shadow-md h-36 relative">
                                    <video class="w-full h-full object-contain" controls preload="metadata">
                                        <source src="{{ asset('storage/' . $campaign->video_path) }}" type="video/mp4">
                                        Your desktop browser does not support integrated video playback matrices.
                                    </video>
                                </div>
                            </div>
                        @endif

                        <!-- Detailed Description Message Matrix Block -->
                        <div class="pt-1">
                            <p class="text-xs font-medium text-gray-600 leading-relaxed line-clamp-3">
                                {{ $campaign->description }}
                            </p>
                        </div>
                    </div>
                    <!-- LIVE FINANCIAL LEDGER MATRIX & PROGRESS BAR DESK -->
                    <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50 space-y-3">
                        <div>
                            <div class="flex justify-between items-center text-[10px] font-black text-brandGray uppercase tracking-wide mb-1">
                                <span>Progress Secured</span>
                                <span class="text-brandOrange font-mono">{{ $campaign->progress_percent }}%</span>
                            </div>
                            <!-- Dynamic Orange Progress Bar Line Layout -->
                            <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden shadow-inner">
                                <div class="bg-brandOrange h-full rounded-full transition-all duration-500" style="width: {{ $campaign->progress_percent }}%"></div>
                            </div>
                        </div>

                        <!-- Numeric Currency Balanced Indicators -->
                        <div class="grid grid-cols-2 gap-2 text-left pt-1">
                            <div class="border-r border-gray-200/80 pr-2">
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-wider block">Raised Amount</span>
                                <span class="text-xs md:text-sm font-black font-mono text-emerald-600">₹{{ number_format($campaign->raised_amount, 2) }}</span>
                            </div>
                            <div class="pl-2">
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-wider block">Target Budget Target</span>
                                <span class="text-xs md:text-sm font-black font-mono text-brandGray">₹{{ number_format($campaign->target_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- CARD FOOTER DISPATCH: SECURED DISPATCH BUTTONS & SOCIAL PROMOTION DESK -->
                <div class="p-4 bg-gray-50 border-t border-gray-100 grid grid-cols-1 gap-3">
                    
                    <!-- 1. Central Native Social Share Linkage Channels Matrix (WhatsApp & Facebook Buttons) -->
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ $campaign->whatsapp_share }}" target="_blank" class="flex items-center justify-center gap-1.5 bg-[#25D366] hover:bg-opacity-90 text-white text-[11px] font-black py-2 px-3 rounded-lg shadow-sm uppercase tracking-wider transition">
                            <span class="text-xs">🟢</span> WhatsApp Share
                        </a>
                        <a href="{{ $campaign->facebook_share }}" target="_blank" class="flex items-center justify-center gap-1.5 bg-[#1877F2] hover:bg-opacity-90 text-white text-[11px] font-black py-2 px-3 rounded-lg shadow-sm uppercase tracking-wider transition">
                            <span class="text-xs">🔵</span> Facebook Share
                        </a>
                    </div>

                    <!-- 2. Primary Dispatch Transaction Anchor Trigger Button -->
                    <a href="#donate_secure_gateway" class="block w-full bg-brandOrange hover:bg-opacity-95 text-white font-black text-center py-2.5 px-4 rounded-xl text-xs md:text-sm shadow uppercase tracking-wider transition transform hover:scale-[1.01]">
                        Donate Now To This Cause
                    </a>
                </div>

            </div>
        @empty
    <!-- Master No Campaigns Active System Fallback Screen -->
    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center bg-white border border-gray-200 rounded-2xl p-12 shadow-md">
        <span class="text-5xl block mb-2">🌾</span>
        <h3 class="text-base font-black text-gray-400 uppercase tracking-wider">No Active Service Campaigns At Present</h3>
        <p class="text-xs font-semibold text-gray-400 mt-1">Check back later for newly dispatched dharma service campaign requirements.</p>
    </div>
@endforelse

    </div>
</div>

<!-- ====================================================================== -->
<!-- JAVASCRIPT IMAGE CAROUSEL MULTI-SLIDER ENGINE CONTROLLER -->
<!-- ====================================================================== -->
<script>
    // Local session map matrix memory to keep distinct index positioning tracking flags for each campaign slider block
    const activeCarouselIndicesMap = {};

    function moveCarouselSlider(campaignId, direction) {
        const track = document.getElementById(`carousel_track_${campaignId}`);
        if (!track) return;

        const totalSlidesCount = track.children.length;
        if (totalSlidesCount <= 1) return;

        // Initialize configuration states fallback loop nodes if tracking maps variables are absent
        if (activeCarouselIndicesMap[campaignId] === undefined) {
            activeCarouselIndicesMap[campaignId] = 0;
        }

        let currentActiveIndex = activeCarouselIndicesMap[campaignId];
        currentActiveIndex += direction;

        // Strict Carousel infinite bounding constraints wrap-around loop architecture
        if (currentActiveIndex >= totalSlidesCount) {
            currentActiveIndex = 0;
        } else if (currentActiveIndex < 0) {
            currentActiveIndex = totalSlidesCount - 1;
        }

        activeCarouselIndicesMap[campaignId] = currentActiveIndex;
        
        // Execute dynamic transform vectors sliding shifts layout injection
        const translatedPercentageShift = currentActiveIndex * 100;
        track.style.transform = `translateX(-${translatedPercentageShift}%)`;
    }
</script>
@endsection
