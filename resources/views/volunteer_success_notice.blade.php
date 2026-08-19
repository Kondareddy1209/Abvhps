@extends('layouts.app')

@section('content')
<section class="min-h-[500px] flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow border border-gray-100 text-center">
        <div class="w-16 h-16 rounded-full overflow-hidden bg-white border-2 border-brandOrange shadow-sm mx-auto mb-3 flex items-center justify-center p-0.5 shrink-0">
            <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
        </div>
        <h2 class="mt-3 text-xl font-black text-brandGray">Application Submitted Successfully!</h2>
        <p class="text-xs text-gray-500 mt-1">Akhanda Bharatha Viswa Hindu Parirakshana Samiti</p>
        
        <div class="my-6 p-5 bg-brandLightOrange rounded-lg border border-orange-100 text-left">
            <span class="text-xs font-bold text-brandOrange uppercase block mb-1">Status: Verification Pending</span>
            <p class="text-xs text-gray-700 leading-relaxed">
                Your volunteer credentials, bank info, and physical document attachments have been securely saved into our central desk server records. 
            </p>
            <p class="text-xs text-gray-700 leading-relaxed mt-2">
                The central administrative committee will verify your identity. Your Volunteer ID will be assigned after your application is approved, and your official Volunteer ID Card will be sent to your email.
            </p>
        </div>

        <a href="/membership" class="w-full inline-block text-center py-2.5 px-4 text-xs font-bold rounded-md text-white bg-brandOrange hover:bg-opacity-90 transition shadow">
            Back to Dashboard
        </a>
    </div>
</section>
@endsection
