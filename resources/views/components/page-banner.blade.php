@props([
    'page'            => 'home',
    'defaultTitle'    => null,
    'defaultSubtitle' => null,
    'defaultBg'       => null,
    'badge'           => null,
    'minHeight'       => '320px',
])

@php
    $banner = \App\Models\Banner::getBannerForPage($page);
    $resolvedTitle    = ($banner && !empty($banner->title)) ? $banner->title : $defaultTitle;
    $resolvedSubtitle = ($banner && !empty($banner->subtitle)) ? $banner->subtitle : $defaultSubtitle;
    $resolvedBadge    = $badge ?? ($banner ? $banner->page_name : null);
@endphp

@if($banner && !empty($banner->desktop_banner))
    {{-- Dynamic Admin-Configured Page Banner with Mobile & Desktop Responsive Support --}}
    <div class="relative text-white border-b-4 border-brandOrange shadow-md overflow-hidden flex items-center justify-center"
         style="min-height: {{ $minHeight }};"
         data-banner-page="{{ $page }}">
        
        {{-- Responsive Picture Tag for Desktop and Mobile Banners --}}
        <picture class="absolute inset-0 w-full h-full">
            @if(!empty($banner->mobile_banner))
                <source media="(max-width: 640px)" srcset="{{ asset('storage/' . $banner->mobile_banner) }}">
            @endif
            <source media="(min-width: 641px)" srcset="{{ asset('storage/' . $banner->desktop_banner) }}">
            <img src="{{ asset('storage/' . $banner->desktop_banner) }}"
                 alt="{{ $resolvedTitle ?? 'ABVHPS Banner' }}"
                 class="w-full h-full object-cover object-center"
                 style="z-index: 0;">
        </picture>

        {{-- Dark Protective Overlay for Crisp Typography Contrast --}}
        <div class="absolute inset-0 pointer-events-none" style="background: rgba(5, 15, 30, 0.45); z-index: 1;"></div>

        {{-- Dynamic Overlay Content Layer --}}
        <div class="relative z-10 py-12 sm:py-16 px-4 text-center w-full max-w-4xl mx-auto space-y-3">
            <div class="w-16 h-16 rounded-full overflow-hidden bg-white border-2 border-brandOrange shadow mx-auto flex items-center justify-center p-0.5 shrink-0">
                <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
            </div>

            @if($resolvedBadge)
                <span class="bg-orange-500/80 text-white text-[10px] sm:text-[11px] font-black px-3.5 py-1 rounded-full uppercase tracking-widest inline-block border border-orange-300/40 shadow-sm">
                    {{ $resolvedBadge }}
                </span>
            @endif

            @if($resolvedTitle)
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold uppercase tracking-wide text-white drop-shadow-md">
                    {{ $resolvedTitle }}
                </h1>
            @endif

            @if($resolvedSubtitle)
                <p class="text-xs sm:text-sm text-gray-100 max-w-2xl mx-auto font-medium leading-relaxed drop-shadow-sm">
                    {{ $resolvedSubtitle }}
                </p>
            @endif
        </div>
    </div>
@else
    {{-- Default Page Hero Fallback when no custom dynamic banner is active --}}
    <div class="relative text-white border-b-4 border-brandOrange shadow-md overflow-hidden flex items-center justify-center"
         style="min-height: {{ $minHeight }}; @if($defaultBg) background-image: url('{{ asset($defaultBg) }}'); background-size: cover; background-repeat: no-repeat; background-position: center center; @else background: linear-gradient(135deg, #1A1A1A 0%, #2D2D2D 100%); @endif"
         data-banner-page="{{ $page }}">
        
        <div class="absolute inset-0 pointer-events-none" style="background: rgba(5, 15, 30, 0.42); z-index: 1;"></div>

        <div class="relative z-10 py-12 sm:py-16 px-4 text-center w-full max-w-4xl mx-auto space-y-3">
            <div class="w-16 h-16 rounded-full overflow-hidden bg-white border-2 border-brandOrange shadow mx-auto flex items-center justify-center p-0.5 shrink-0">
                <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
            </div>

            @if($resolvedBadge)
                <span class="bg-orange-500/80 text-white text-[10px] sm:text-[11px] font-black px-3.5 py-1 rounded-full uppercase tracking-widest inline-block border border-orange-400/40 shadow-sm">
                    {{ $resolvedBadge }}
                </span>
            @endif

            @if($resolvedTitle)
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold uppercase tracking-wide text-white drop-shadow-md">
                    {{ $resolvedTitle }}
                </h1>
            @endif

            @if($resolvedSubtitle)
                <p class="text-xs sm:text-sm text-gray-200 max-w-2xl mx-auto font-medium leading-relaxed drop-shadow-sm">
                    {{ $resolvedSubtitle }}
                </p>
            @endif
        </div>
    </div>
@endif
