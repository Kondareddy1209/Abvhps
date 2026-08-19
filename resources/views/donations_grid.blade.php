@extends('layouts.app')

@section('title', 'Dharma Seva Fundraising Campaigns | ABVHPS')
@section('meta_description', 'Support active ABVHPS fundraising initiatives for temple construction, goshala developments, and sacred deity consecration across India.')

@section('content')
<div class="bg-gray-50 min-h-screen pb-16">

    @php
        $fundraiseBanner = \App\Models\Banner::getBannerForPage('fundraise');
    @endphp

    {{-- Official Header Banner with Dynamic Admin Management and Fallback --}}
    <div class="text-white border-b-4 border-brandOrange shadow-md relative overflow-hidden flex items-center justify-center"
         style="min-height: 360px; @if(!$fundraiseBanner) background-image: url('{{ asset('images/fundraise_bg.png') }}'); background-size: cover; background-repeat: no-repeat; background-position: center center; @endif"
         data-banner-page="fundraise">

        @if($fundraiseBanner && !empty($fundraiseBanner->desktop_banner))
            <picture class="absolute inset-0 w-full h-full">
                @if(!empty($fundraiseBanner->mobile_banner))
                    <source media="(max-width: 640px)" srcset="{{ asset('storage/' . $fundraiseBanner->mobile_banner) }}">
                @endif
                <source media="(min-width: 641px)" srcset="{{ asset('storage/' . $fundraiseBanner->desktop_banner) }}">
                <img src="{{ asset('storage/' . $fundraiseBanner->desktop_banner) }}"
                     alt="{{ $fundraiseBanner->title ?? 'Dharma Seva Fundraising Desk' }}"
                     class="w-full h-full object-cover object-center"
                     style="z-index: 0;">
            </picture>
        @endif

        {{-- Protective vignette / overlay --}}
        <div class="absolute inset-0 pointer-events-none"
             style="background: rgba(5, 15, 30, @if($fundraiseBanner) 0.42 @else 0.15 @endif); z-index: 1;"></div>

        {{-- Hero Content --}}
        <div class="relative z-10 flex items-center justify-center py-12 sm:py-16 px-4 w-full">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <div class="inline-block w-full rounded-2xl px-6 py-5"
                     style="background: rgba(255,255,255,0.08); backdrop-filter: blur(2px);">

                    <div class="w-16 h-16 rounded-full overflow-hidden bg-white border-2 border-brandOrange shadow mx-auto flex items-center justify-center p-0.5 shrink-0 mb-3">
                        <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
                    </div>

                    <span class="bg-orange-500/20 text-orange-200 text-[10px] sm:text-[11px] font-black px-3.5 py-1 rounded-full uppercase tracking-widest inline-block border border-orange-400/40 mb-1"
                          style="text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
                        {{ ($fundraiseBanner && $fundraiseBanner->page_name) ? $fundraiseBanner->page_name : 'ABVHPS Dharma Seva' }}
                    </span>

                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold uppercase tracking-wide text-white"
                        style="text-shadow: 0 2px 8px rgba(0,0,0,0.55), 0 1px 2px rgba(0,0,0,0.4);">
                        {{ ($fundraiseBanner && !empty($fundraiseBanner->title)) ? $fundraiseBanner->title : 'Dharma Seva Fundraising Desk' }}
                    </h1>

                    <p class="text-xs sm:text-sm max-w-xl mx-auto font-medium leading-relaxed mt-2 text-gray-100"
                       style="text-shadow: 0 1px 4px rgba(0,0,0,0.5);">
                        {{ ($fundraiseBanner && !empty($fundraiseBanner->subtitle)) ? $fundraiseBanner->subtitle : 'Support our multi-parallel holy initiatives across various regions. Contribute transparently for Temple Constructions, Gosala Developments, and Sacred Idol Donations.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Interactive Multi-Campaign Grid Container --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
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
                        <a href="{{ $campaign->whatsapp_share_url ?? $campaign->whatsapp_share }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-1.5 bg-[#25D366] hover:bg-[#20ba59] text-white text-[11px] font-black py-2 px-3 rounded-lg shadow-sm uppercase tracking-wider transition" aria-label="Share {{ $campaign->title }} on WhatsApp">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.072-2.176-.543-1.894-.787-3.111-2.724-3.206-2.85-.095-.125-.769-1.025-.769-1.954 0-.93.486-1.385.66-1.575.174-.189.38-.238.508-.238.127 0 .253.002.364.007.117.006.275-.044.429.327.16.386.547 1.332.595 1.43.048.098.08.213.016.338-.064.126-.096.205-.19.316-.095.111-.2.247-.286.332-.095.095-.194.198-.083.389.111.19.493.814 1.057 1.317.725.646 1.337.846 1.528.941.19.095.302.08.413-.048.111-.127.476-.556.603-.746.127-.19.254-.158.428-.095.175.063 1.111.524 1.301.62.19.095.317.143.365.222.048.079.048.46-.096.865z"/></svg>
                            <span>WhatsApp Share</span>
                        </a>
                        <a href="{{ $campaign->facebook_share_url ?? $campaign->facebook_share }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-1.5 bg-[#1877F2] hover:bg-opacity-90 text-white text-[11px] font-black py-2 px-3 rounded-lg shadow-sm uppercase tracking-wider transition" aria-label="Share {{ $campaign->title }} on Facebook">
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
