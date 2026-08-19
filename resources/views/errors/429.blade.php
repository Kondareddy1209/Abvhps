@extends('layouts.app')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center space-y-6 bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
        <div class="w-16 h-16 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mx-auto text-3xl font-black">
            🛡️
        </div>
        <div>
            <span class="text-xs font-black text-purple-600 uppercase tracking-widest block">Traffic Throttled &bull; Error 429</span>
            <h1 class="text-2xl font-extrabold text-gray-900 mt-1 uppercase">Too Many Requests</h1>
            <p class="text-xs text-gray-500 mt-2 font-medium">
                Our defense gateways detected excessive request volume from your network. Please wait a brief moment before attempting again.
            </p>
        </div>
        <div class="pt-4 flex flex-col gap-2">
            <a href="{{ url('/') }}" class="w-full bg-[#FF6600] hover:bg-[#e05a00] text-white font-black text-xs py-3 px-4 rounded-lg uppercase tracking-wider transition">
                Return to Home
            </a>
        </div>
    </div>
</section>
@endsection
