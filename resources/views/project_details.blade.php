@extends('layouts.app')

@section('content')
<!-- Public Website Single Project Header Banner -->
<div class="bg-gray-900 text-white py-12 text-center" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/assets/images/banner.jpg') no-repeat center center; background-size: cover;">
    <div class="container mx-auto px-4">
        <div class="w-14 h-14 rounded-full overflow-hidden bg-white border-2 border-orange-500 shadow mx-auto mb-2 flex items-center justify-center p-0.5">
            <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
        </div>
        <h1 class="text-2xl md:text-4xl font-bold uppercase tracking-wide text-orange-500">{{ $project->name }}</h1>
        <p class="text-xs md:text-sm text-gray-300 mt-2 uppercase tracking-widest">Core Service Mission Project Details</p>
    </div>
</div>

<!-- Main Content Details Block -->
<div class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden p-6 md:p-8 space-y-6">
            
            <!-- Project Big Image Frame -->
            @if($project->image_path)
                <div class="w-full max-h-96 rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                    <img src="{{ asset('storage/' . $project->image_path) }}" class="w-full h-full object-cover" alt="{{ $project->name }}">
                </div>
            @endif

            <!-- Project Details Text Content Info -->
            <div class="prose max-w-none">
                <h2 class="text-xl font-bold text-gray-900 uppercase tracking-wide border-b pb-2 text-orange-600 mb-4">
                    About This Mission
                </h2>
                
                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line font-medium">
                    {{ $project->short_info }}
                </p>
            </div>

            <!-- Back to Home Action Desk Button -->
            <div class="pt-6 border-t border-gray-100 flex justify-start">
                <a href="{{ route('public.home') }}" class="bg-gray-800 hover:bg-gray-950 text-white font-bold text-xs uppercase tracking-wider px-5 py-2.5 rounded-lg shadow transition">
                    ← Back To Home
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
