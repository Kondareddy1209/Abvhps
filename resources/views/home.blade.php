@extends('layouts.app')

@section('content')
<!-- 1. Dynamic Image Slider Section -->
<div class="relative w-full overflow-hidden bg-gray-900 h-[450px]">
    @foreach($sliders as $index => $slider)
    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index == 0 ? 'opacity-100' : 'opacity-0' }}" id="slide-{{ $index }}">
        <img src="{{ $slider->image_path }}" class="w-full h-full object-cover opacity-60" alt="ABVHPS Slider">
        <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">
            <h2 class="text-white text-3xl md:text-5xl font-extrabold mb-4 drop-shadow-md">{{ $slider->title }}</h2>
            <p class="text-brandLightOrange text-base md:text-xl max-w-2xl drop-shadow-sm">{{ $slider->subtitle }}</p>
        </div>
    </div>
    @endforeach
</div>

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
@if($fundraising)
<section class="py-16 px-4 bg-white">
    <div class="max-w-5xl mx-auto bg-brandLightOrange rounded-xl shadow-md overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-6 items-center">
        <div>
            <img src="{{ $fundraising->image_path }}" class="w-full h-64 object-cover rounded-lg shadow" alt="Fundraising Image">
        </div>
        <div>
            <span class="bg-brandOrange text-white text-xs font-bold px-3 py-1 rounded-full uppercase">Active Campaign</span>
            <h2 class="text-2xl font-bold text-brandGray mt-3 mb-3">{{ $fundraising->title }}</h2>
            <p class="text-xs text-gray-600 leading-relaxed mb-6">{{ $fundraising->description }}</p>
            
            <!-- Progress Calculation Display -->
            @php 
                $percent = ($fundraising->raised_amount / $fundraising->goal_amount) * 100;
                $percent = $percent > 100 ? 100 : $percent;
            @endphp
            <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden mb-2">
                <div class="bg-brandOrange h-full transition-all duration-500" style="width: {{ $percent }}%"></div>
            </div>
            <div class="flex justify-between text-xs font-bold text-brandGray mb-6">
                <span>Raised: ₹{{ number_format($fundraising->raised_amount) }}</span>
                <span>Goal: ₹{{ number_format($fundraising->goal_amount) }}</span>
            </div>
            <a href="/donation" class="inline-block bg-brandOrange text-white font-bold text-sm px-6 py-3 rounded shadow hover:bg-opacity-90 transition">
                Contribute Now
            </a>
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
