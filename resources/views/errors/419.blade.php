@extends('layouts.app')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center space-y-6 bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
        <div class="w-16 h-16 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mx-auto text-3xl font-black">
            ⏳
        </div>
        <div>
            <span class="text-xs font-black text-orange-600 uppercase tracking-widest block">Session Timeout &bull; Error 419</span>
            <h1 class="text-2xl font-extrabold text-gray-900 mt-1 uppercase">Page Expired</h1>
            <p class="text-xs text-gray-500 mt-2 font-medium">
                Your form session security token expired due to inactivity. Please refresh and try submitting again.
            </p>
        </div>
        <div class="pt-4 flex flex-col gap-2">
            <button onclick="window.location.reload()" class="w-full bg-[#FF6600] hover:bg-[#e05a00] text-white font-black text-xs py-3 px-4 rounded-lg uppercase tracking-wider transition cursor-pointer">
                Refresh &amp; Try Again
            </button>
            <a href="{{ url('/') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs py-2.5 px-4 rounded-lg uppercase tracking-wider transition">
                Return to Home
            </a>
        </div>
    </div>
</section>
@endsection
