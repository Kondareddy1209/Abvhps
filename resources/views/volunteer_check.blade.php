@extends('layouts.app')

@section('title', 'Volunteer Registration & Cadre Application | ABVHPS')
@section('meta_description', 'Apply to become an active ABVHPS Seva Volunteer across village, mandal, assembly, and district levels.')

@section('content')
<section class="min-h-[500px] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow border border-gray-100">
        
        <!-- Header Block Layout -->
        <div class="text-center">
            <div class="w-16 h-16 rounded-full overflow-hidden bg-white border-2 border-brandOrange shadow-sm mx-auto mb-2 flex items-center justify-center p-0.5 shrink-0">
                <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
            </div>
            <h2 class="mt-2 text-2xl font-extrabold text-brandGray">Volunteer Identity Check</h2>
            <p class="mt-2 text-xs text-gray-500">Akhanda Bharatha Viswa Hindu Parirakshana Samiti</p>
        </div>

        <!-- Notification Response Alerts Tracking -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-3 text-xs text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-3 text-xs text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Step 1: Input Fields Form validating Membership Credentials -->
        <form class="mt-6 space-y-4" action="/volunteer/verify-membership" method="POST">
            @csrf
            
            <!-- Membership 12-Digit ID Input Row -->
            <div>
                <label for="membership_id" class="block text-xs font-bold text-brandGray uppercase tracking-wide mb-1">Membership ID</label>
                <input id="membership_id" name="membership_id" type="text" required maxlength="12"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-brandOrange focus:border-brandOrange text-brandGray font-semibold tracking-wider" 
                    placeholder="Enter 12 Digit Membership ID">
            </div>

            <!-- Mobile 10-Digit Registered Number Input Row -->
            <div>
                <label for="phone" class="block text-xs font-bold text-brandGray uppercase tracking-wide mb-1">Registered Mobile Number</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-sm font-medium">+91</span>
                    <input id="phone" name="phone" type="tel" required maxlength="10" pattern="[6-9][0-9]{9}" 
                        class="block w-full pl-12 pr-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-brandOrange focus:border-brandOrange text-brandGray font-semibold tracking-wider" 
                        placeholder="Enter 10 Digit Phone">
                </div>
            </div>

            <!-- Action Button Trigger Grid Component -->
            <button type="submit" 
                class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-brandOrange hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brandOrange shadow transition">
                Verify & Proceed
            </button>
        </form>

        <div class="text-center pt-2">
            <a href="/membership" class="text-xs font-bold text-brandGray hover:text-brandOrange uppercase tracking-wide">&larr; Join as a Member First</a>
        </div>

    </div>
</section>
@endsection
