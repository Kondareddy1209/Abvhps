@extends('layouts.app')

@section('content')
<section class="max-w-2xl mx-auto my-12 p-8 bg-white rounded-xl shadow border border-gray-100">
    <div class="border-b border-gray-100 pb-4 mb-6 text-center">
        <span class="text-xs font-bold text-brandOrange uppercase tracking-widest block">ABVHPS Membership Form</span>
        <h2 class="text-2xl font-black text-brandGray mt-1">Registration Application</h2>
    </div>

    <!-- Displaying the 12-Digit code exactly in 4-4-4 spaced format above Aadhaar input row -->
    <div class="mb-6 p-4 bg-brandLightOrange rounded-lg border border-orange-100 flex justify-between items-center">
        <div>
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wide block">Generated Membership ID</span>
            <span class="text-2xl font-black text-brandOrange tracking-widest">{{ $formattedId }}</span>
        </div>
        <div class="text-right">
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wide block">Mobile Number</span>
            <span class="text-sm font-bold text-brandGray">{{ $phone }}</span>
        </div>
    </div>

    <!-- Temporary row representation for Aadhaar input -->
    <div class="p-6 bg-gray-50 rounded-lg border border-dashed border-gray-200 text-center">
        <p class="text-sm font-semibold text-brandGray mb-2">Aadhaar Number Input Row & Verification (Coming in next step)</p>
        <div class="max-w-xs mx-auto h-10 bg-white border border-gray-300 rounded shadow-sm"></div>
    </div>
</section>
@endsection
