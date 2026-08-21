@extends('layouts.app')

@section('title', 'ABVHPS | Akhanda Bharatha Viswa Hindu Parirakshana Samiti')
@section('meta_description', 'Akhanda Bharatha Viswa Hindu Parirakshana Samiti (ABVHPS) is dedicated to preserving Sanatana Dharma, constructing temples, protecting goshalas, Annapurna seva, and community empowerment across India.')

@section('content')
    @php
        $homeBanner = \App\Models\Banner::getBannerForPage('home');
    @endphp

    @if($homeBanner && !empty($homeBanner->desktop_banner))
        {{-- Dynamic Home Page Banner Configured via Admin --}}
        <div class="relative w-full overflow-hidden bg-gray-900 min-h-[420px] md:h-[450px] flex items-center justify-center border-b-4 border-brandOrange shadow-md"
             data-banner-page="home">
            <picture class="absolute inset-0 w-full h-full">
                @if(!empty($homeBanner->mobile_banner))
                    <source media="(max-width: 640px)" srcset="{{ asset('storage/' . $homeBanner->mobile_banner) }}">
                @endif
                <source media="(min-width: 641px)" srcset="{{ asset('storage/' . $homeBanner->desktop_banner) }}">
                <img src="{{ asset('storage/' . $homeBanner->desktop_banner) }}"
                     alt="{{ $homeBanner->title ?? 'ABVHPS Home' }}"
                     class="w-full h-full object-cover object-center"
                     style="z-index: 0;">
            </picture>

            {{-- Subtle dark overlay for text readability --}}
            <div class="absolute inset-0 pointer-events-none" style="background: rgba(5, 15, 30, 0.42); z-index: 1;"></div>

            {{-- Banner Text Content --}}
            <div class="relative z-10 flex flex-col justify-center items-center text-center px-4 max-w-4xl mx-auto py-12">
                @if($homeBanner->title)
                    <h2 class="text-white text-3xl md:text-5xl font-extrabold mb-4 drop-shadow-md uppercase tracking-wide">
                        {{ $homeBanner->title }}
                    </h2>
                @endif
                @if($homeBanner->subtitle)
                    <p class="text-brandLightOrange text-base md:text-xl max-w-2xl drop-shadow-sm font-medium">
                        {{ $homeBanner->subtitle }}
                    </p>
                @endif
            </div>
        </div>
    @else
        <!-- 1. Hero Section — Video Background with Dynamic Slider Content -->
        <div class="relative w-full overflow-hidden bg-gray-900 h-[450px]" data-banner-page="home">

            {{-- Background Video --}}
            <video
                class="absolute inset-0 w-full h-full object-cover object-center"
                style="z-index: 0;"
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
            >
                <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
            </video>

            {{-- Subtle dark overlay for text readability --}}
            <div class="absolute inset-0" style="background: rgba(5, 15, 30, 0.38); z-index: 1;"></div>

            {{-- Existing Slider Content — sits above video and overlay --}}
            @if(isset($sliders) && count($sliders) > 0)
                @foreach($sliders as $index => $slider)
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index == 0 ? 'opacity-100' : 'opacity-0' }}" id="slide-{{ $index }}" style="z-index: 2;">
                    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">
                        <h2 class="text-white text-3xl md:text-5xl font-extrabold mb-4 drop-shadow-md">{{ $slider->title }}</h2>
                        <p class="text-brandLightOrange text-base md:text-xl max-w-2xl drop-shadow-sm">{{ $slider->subtitle }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4" style="z-index: 2;">
                    <h2 class="text-white text-3xl md:text-5xl font-extrabold mb-4 drop-shadow-md">Akhanda Bharatha Viswa Hindu Parirakshana Samiti</h2>
                    <p class="text-brandLightOrange text-base md:text-xl max-w-2xl drop-shadow-sm">Preserving Sanathana Dharma and Empowering Communities</p>
                </div>
            @endif

        </div>
    @endif


{{-- Official Latest Announcements Desk --}}
@if(isset($publishedExams) && $publishedExams->isNotEmpty())
<section class="bg-amber-50 border-y border-amber-200 py-3 px-4">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-3 text-xs">
        <div class="flex items-center gap-2 text-amber-900 font-bold">
            <span class="bg-amber-600 text-white text-[10px] uppercase tracking-wider font-black px-2 py-0.5 rounded">Announcement</span>
            <span>📢 Examination Results Announced:</span>
            <span class="font-normal text-gray-800">
                @foreach($publishedExams as $pExam)
                    <strong class="font-bold">{{ $pExam->exam_title }}</strong>@if(!$loop->last), @endif
                @endforeach
                — results are now available.
            </span>
        </div>
        <a href="{{ route('exam.results_portal') }}"
           class="bg-amber-700 hover:bg-amber-800 text-white font-black text-[11px] px-3.5 py-1.5 rounded uppercase tracking-wider transition whitespace-nowrap">
            View Results →
        </a>
    </div>
</section>
@endif

<!-- 2. Organization Origin & Message From Guru Garu -->
<section class="py-16 px-4 bg-white">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
        <div class="md:col-span-2">
            <span class="text-brandOrange font-bold tracking-wider text-xs uppercase">Our Divine Origin</span>
            <h2 class="text-3xl font-extrabold text-brandGray mt-2 mb-4">Why and How ABVHPS Was Founded</h2>
            <p class="text-gray-600 leading-relaxed text-sm mb-4">
                The Akhanda Bharata Viswa Hindu Parirakshana Samithi was set up in the year of 2023 and having the Registration Number 20/2023 for the social process. It recognizes activities preserving Sanatana Dharma under the behest of Rajaguru <strong>Sri Sri Sri Subrahmanneswara Swamy Garu</strong>.
            </p>
            <p class="text-gray-600 leading-relaxed text-sm">
                This charitable trust is dedicated to uplift mankind mentally, morally, or physically. Trust is to beautify designated villages and focus on spiritual awareness, temple wellbeing, and deep patriotism.
            </p>
        </div>
        <div class="bg-brandLightOrange p-6 rounded-lg border-l-4 border-brandOrange">
            <h3 class="font-bold text-lg text-brandOrange mb-2">Divine Blessings</h3>
            <p class="text-xs italic text-gray-700 leading-relaxed">
                "Our main objective is to protect Hindu Sanathana Dharma, construct new temples, expand Goushalas, distribute daily meals under Annapurna, and support children's literacy across every Grama Panchayat."
            </p>
            <span class="block text-xs font-bold text-brandGray mt-4 text-right">- Sri Sri Sri Subrahmanneswara Swamy Garu</span>
        </div>
    </div>
</section>

<!-- 3. Vision, Mission & Goal Section -->
<section class="py-12 px-4 bg-gray-50 border-t border-b border-gray-200">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded shadow-sm text-center">
            <div class="text-2xl mb-2">👁️</div>
            <h3 class="font-bold text-brandGray text-lg mb-2">Our Vision</h3>
            <p class="text-xs text-gray-600 leading-relaxed">To develop Temples as a part of Sanathana Dharma, construct new worship spaces, and bring social equality to the underprivileged sections of society.</p>
        </div>
        <div class="bg-white p-6 rounded shadow-sm text-center">
            <div class="text-2xl mb-2">🚀</div>
            <h3 class="font-bold text-brandGray text-lg mb-2">Our Mission</h3>
            <p class="text-xs text-gray-600 leading-relaxed">Giving voluntary memberships to those ready to deliver services covering poor relief, education, food distribution, and medical aid maps.</p>
        </div>
        <div class="bg-white p-6 rounded shadow-sm text-center">
            <div class="text-2xl mb-2">🎯</div>
            <h3 class="font-bold text-brandGray text-lg mb-2">The Goal</h3>
            <p class="text-xs text-gray-600 leading-relaxed">Protect and promote Hindu traditions, rituals, and festivals for future generations, fostering brotherhood and collaboration globally.</p>
        </div>
    </div>
</section>

<!-- 4. Our Core Service Projects (Managed from Admin Panel / our_supports) -->
<section class="py-16 px-4 bg-gray-50 border-t border-gray-100">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <span class="text-xs font-bold text-brandOrange uppercase tracking-wider block">Comprehensive Seva Modules</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-brandGray uppercase tracking-tight mt-1">Our Core Service Projects</h2>
            <p class="text-xs text-gray-500 mt-1">Every project can be customized, added, or modified using the secure Admin Login Panel</p>
            <div class="h-1 w-16 bg-brandOrange mx-auto mt-3"></div>
        </div>

        @if(isset($projects) && count($projects) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition flex flex-col justify-between h-full">
                        <div>
                            <!-- Project Image Component Frame -->
                            <div class="mb-4 aspect-[16/10] w-full bg-gray-50 rounded-lg overflow-hidden border border-gray-100 flex items-center justify-center">
                                @if($project->image_path)
                                    <img src="{{ asset('storage/' . $project->image_path) }}" class="w-full h-full object-cover" alt="{{ $project->name }}">
                                @else
                                    <span class="text-3xl">🌱</span>
                                @endif
                            </div>
                            
                            <!-- Project Official Title Name -->
                            <h3 class="font-bold text-base text-brandGray uppercase tracking-wide mb-2">
                                {{ $project->name }}
                            </h3>
                            
                            <!-- Controlled 3-Line Text Description Fragment -->
                            <p class="text-xs text-gray-500 leading-relaxed mb-4 line-clamp-3 font-medium">
                                {{ strip_tags($project->short_info) }}
                            </p>
                        </div>
                        
                        <!-- Explore Single Core Detail Action Button Fixed Link -->
                        <div class="pt-2 border-t border-gray-50">
                            <a href="{{ route('public.project.show', $project->id) }}" class="text-xs font-black text-brandOrange hover:text-brandGray uppercase tracking-wider inline-flex items-center gap-1 transition">
                                Explore Project <span class="text-sm">→</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 bg-white rounded-xl border border-gray-200 p-8 max-w-md mx-auto">
                <span class="text-3xl block mb-2">🌱</span>
                <p class="text-xs text-gray-500 font-medium">Core service project records will appear here.</p>
            </div>
        @endif
    </div>
</section>

<!-- 5. Fundraising Campaigns (Dynamic Admin Fundraising Campaigns) -->
<section class="py-16 px-4 bg-white border-t border-gray-200">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-bold text-brandOrange uppercase tracking-wider block">Dharma Seva Initiatives</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-brandGray uppercase tracking-tight mt-1">Fundraising Campaigns</h2>
                <p class="text-xs text-gray-500 mt-1">Support meaningful initiatives and help us serve communities across India.</p>
                <div class="h-1 w-16 bg-brandOrange mt-3"></div>
            </div>
            @if(isset($fundraisingCampaigns) && $fundraisingCampaigns->isNotEmpty())
                <a href="{{ route('donations.grid') }}" class="bg-brandOrange hover:bg-opacity-90 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm transition uppercase tracking-wider inline-flex items-center gap-1 shrink-0 self-start sm:self-auto">
                    View All Campaigns →
                </a>
            @endif
        </div>

        @if(isset($fundraisingCampaigns) && $fundraisingCampaigns->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($fundraisingCampaigns as $campaign)
                    @php
                        $target = $campaign->target_amount ?? 1;
                        $raised = $campaign->raised_amount ?? 0;
                        $percent = $target > 0 ? min(round(($raised / $target) * 100, 2), 100) : 0;
                    @endphp
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <!-- Campaign Image & Badges -->
                            <div class="aspect-[16/10] w-full bg-gray-100 overflow-hidden relative">
                                @if(!empty($campaign->cover_image))
                                    <img src="{{ asset('storage/' . $campaign->cover_image) }}" class="w-full h-full object-cover" alt="{{ $campaign->title }}">
                                @elseif(!empty($campaign->image_path))
                                    <img src="{{ asset('storage/' . $campaign->image_path) }}" class="w-full h-full object-cover" alt="{{ $campaign->title }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-3xl">🌾</div>
                                @endif
                                <span class="absolute top-2.5 left-2.5 bg-brandOrange text-white text-[9px] font-black px-2.5 py-0.5 rounded-full uppercase shadow-xs">
                                    Active Cause
                                </span>
                                @if(!empty($campaign->end_date))
                                    <span class="absolute top-2.5 right-2.5 bg-black/60 backdrop-blur-xs text-white text-[9px] font-bold px-2 py-0.5 rounded uppercase">
                                        Ends: {{ \Carbon\Carbon::parse($campaign->end_date)->format('d-M-Y') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Campaign Details -->
                            <div class="p-5">
                                <h3 class="font-bold text-sm text-brandGray line-clamp-2 uppercase h-10 mb-2">
                                    {{ $campaign->title }}
                                </h3>
                                <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-4">
                                    {{ strip_tags($campaign->description ?? '') }}
                                </p>
                                
                                @if(!empty($campaign->video_path))
                                    <div class="mb-3">
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-brandOrange bg-orange-50 px-2 py-0.5 rounded border border-orange-200">
                                            🎥 Video Briefing Available
                                        </span>
                                    </div>
                                @endif

                                <!-- Progress Bar & Amounts -->
                                <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden mb-2">
                                    <div class="bg-brandOrange h-full rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                                </div>
                                <div class="flex justify-between text-[11px] font-bold text-gray-600">
                                    <span>Raised: <strong class="text-brandOrange font-mono">{{ \App\Models\FundraisingCampaign::formatIndianCurrency($raised) }}</strong> ({{ $percent }}%)</span>
                                    <span>Target: <strong class="text-gray-900 font-mono">{{ \App\Models\FundraisingCampaign::formatIndianCurrency($target) }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <!-- Action CTA Button & WhatsApp Share -->
                        <div class="p-5 pt-0 space-y-2">
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('donations.campaign', $campaign->id) }}" class="block w-full bg-brandOrange hover:bg-opacity-90 text-white font-bold text-center py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider transition">
                                    Contribute →
                                </a>
                                <a href="{{ $campaign->whatsapp_share_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-1.5 bg-[#25D366] hover:bg-[#20ba59] text-white font-bold text-center py-2.5 px-3 rounded-xl text-xs uppercase tracking-wider shadow-xs transition" aria-label="Share {{ $campaign->title }} on WhatsApp">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.072-2.176-.543-1.894-.787-3.111-2.724-3.206-2.85-.095-.125-.769-1.025-.769-1.954 0-.93.486-1.385.66-1.575.174-.189.38-.238.508-.238.127 0 .253.002.364.007.117.006.275-.044.429.327.16.386.547 1.332.595 1.43.048.098.08.213.016.338-.064.126-.096.205-.19.316-.095.111-.2.247-.286.332-.095.095-.194.198-.083.389.111.19.493.814 1.057 1.317.725.646 1.337.846 1.528.941.19.095.302.08.413-.048.111-.127.476-.556.603-.746.127-.19.254-.158.428-.095.175.063 1.111.524 1.301.62.19.095.317.143.365.222.048.079.048.46-.096.865z"/></svg>
                                    <span>Share</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Clean Empty State -->
            <div class="text-center py-12 bg-gray-50 rounded-2xl border border-gray-200 p-8 max-w-md mx-auto">
                <span class="text-3xl block mb-2">🕉️</span>
                <h3 class="text-sm font-bold text-gray-700 uppercase">Fundraising Campaigns</h3>
                <p class="text-xs text-gray-500 mt-1">No active fundraising campaigns at the moment.</p>
            </div>
        @endif
    </div>
</section>

<!-- 6. Live Counter Statistics Section -->
<section class="bg-brandOrange text-white py-12 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        <div>
            <span class="block text-4xl font-extrabold mb-1">{{ $liveCounts['donors'] }}+</span>
            <span class="text-xs uppercase font-medium tracking-wider">Active Donors</span>
        </div>
        <div>
            <span class="block text-4xl font-extrabold mb-1">{{ $liveCounts['members'] }}+</span>
            <span class="text-xs uppercase font-medium tracking-wider">Registered Members</span>
        </div>
        <div>
            <span class="block text-4xl font-extrabold mb-1">{{ $liveCounts['volunteers'] }}+</span>
            <span class="text-xs uppercase font-medium tracking-wider">Total Volunteers</span>
        </div>
        <div>
            <span class="block text-4xl font-extrabold mb-1">{{ $liveCounts['years'] }}</span>
            <span class="text-xs uppercase font-medium tracking-wider">Years of Service</span>
        </div>
    </div>
</section>

<!-- JavaScript logic to animate the slider images -->
<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('[id^="slide-"]');
    setInterval(() => {
        slides[currentSlide].classList.remove('opacity-100');
        slides[currentSlide].classList.add('opacity-0');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.remove('opacity-0');
        slides[currentSlide].classList.add('opacity-100');
    }, 4000);
</script>
@endsection
