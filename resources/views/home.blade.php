@extends('layouts.app')

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

<!-- 4. Dynamic Live Fundraising Section -->
@if(isset($fundraisingCampaigns) && $fundraisingCampaigns->isNotEmpty())
<section class="py-16 px-4 bg-white border-t border-gray-100">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div>
                <span class="text-xs font-bold text-brandOrange uppercase tracking-wider block">Dharma Seva Initiatives</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-brandGray uppercase tracking-tight mt-1">Current Dharma Seva Campaigns</h2>
            </div>
            <a href="{{ route('public.fundraising.index') }}" class="bg-brandOrange hover:bg-opacity-90 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow-sm transition uppercase tracking-wider inline-flex items-center gap-1 shrink-0 self-start sm:self-auto">
                View All Campaigns →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($fundraisingCampaigns as $cItem)
                @php
                    $cGoal = $cItem->goal_amount ?? 1;
                    $cRaised = $cItem->raised_amount ?? 0;
                    $cPercent = ($cRaised / max(1, $cGoal)) * 100;
                    $cPercent = min(100, max(0, $cPercent));
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="aspect-[16/10] w-full bg-gray-100 overflow-hidden relative">
                            @if(!empty($cItem->cover_image))
                                <img src="{{ asset('storage/' . $cItem->cover_image) }}" class="w-full h-full object-cover" alt="{{ $cItem->title }}">
                            @elseif(!empty($cItem->image_path))
                                <img src="{{ $cItem->image_path }}" class="w-full h-full object-cover" alt="{{ $cItem->title }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-3xl">🌾</div>
                            @endif
                            <span class="absolute top-2.5 left-2.5 bg-brandOrange text-white text-[9px] font-black px-2.5 py-0.5 rounded-full uppercase shadow-xs">
                                Active Cause
                            </span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-sm text-brandGray line-clamp-2 uppercase h-10 mb-2">
                                {{ $cItem->title }}
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-4">
                                {{ strip_tags($cItem->description ?? '') }}
                            </p>
                            
                            <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden mb-2">
                                <div class="bg-brandOrange h-full rounded-full transition-all duration-500" style="width: {{ $cPercent }}%"></div>
                            </div>
                            <div class="flex justify-between text-[11px] font-bold text-gray-600">
                                <span>Raised: <strong class="text-brandOrange font-mono">₹{{ number_format($cRaised) }}</strong></span>
                                <span>Goal: <strong class="text-gray-900 font-mono">₹{{ number_format($cGoal) }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 pt-0">
                        <a href="{{ route('public.fundraising.index') }}#campaign_{{ $cItem->id }}" class="block w-full bg-brandOrange hover:bg-opacity-90 text-white font-bold text-center py-2 px-4 rounded-xl text-xs uppercase tracking-wider transition">
                            Contribute Now
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 5. All Projects Grid Section (Controlled from Database) -->
<section class="py-16 px-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-brandGray mb-2">Our Core Service Projects</h2>
            <p class="text-xs text-gray-500">Every project can be customized, added, or modified using the secure Admin Login Panel</p>
            <div class="h-1 w-16 bg-brandOrange mx-auto mt-3"></div>
        </div>
        
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
                    </div>
                @endforeach
            </div>

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
