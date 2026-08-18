@extends('layouts.app')

@section('content')
<section class="min-h-[500px] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow border border-gray-100">
        <div class="text-center">
            <span class="text-4xl text-brandOrange">🪷</span>
            <h2 class="mt-2 text-3xl font-extrabold text-brandGray">Membership Verification</h2>
            <p class="mt-2 text-xs text-gray-500">Akhanda Bharatha Viswa Hindu Parirakshana Samiti</p>
        </div>

        <!-- Notification Alerts -->
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

        <!-- STEP 1: Enter Mobile Number Form -->
        @if(!session('otp_sent_to'))
        <form class="mt-6 space-y-4" action="/membership/send-otp" method="POST">
            @csrf
            <div>
                <label for="phone" class="block text-xs font-bold text-brandGray uppercase tracking-wide mb-1">Mobile Number</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-sm font-medium">+91</span>
                    <input id="phone" name="phone" type="tel" required maxlength="10" pattern="[6-9][0-9]{9}" 
                        class="block w-full pl-12 pr-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-brandOrange focus:border-brandOrange text-brandGray font-semibold tracking-wider" 
                        placeholder="Enter 10 Digit Number">
                </div>
            </div>
            <button type="submit" 
                class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-brandOrange hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brandOrange transition">
                Send OTP Verification
            </button>
        </form>
        @else
        <!-- STEP 2: Enter OTP Form (With Hidden Phone Field to prevent Session Expired Error) -->
        <form class="mt-6 space-y-4" action="/membership/verify-otp" method="POST">
            @csrf
            <!-- Hidden field carrying phone number securely back to controller -->
            <input type="hidden" name="phone" value="{{ session('otp_sent_to') }}">
            
            <div>
                <label for="otp" class="block text-xs font-bold text-brandGray uppercase tracking-wide mb-1">Enter OTP Code</label>
                <input id="otp" name="otp" type="text" required maxlength="6" 
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm text-center font-bold tracking-widest focus:outline-none focus:ring-2 focus:ring-brandOrange focus:border-brandOrange text-brandGray" 
                    placeholder="******">
                <p class="mt-1 text-[11px] text-gray-500 text-center">OTP code has been sent to +91 {{ session('otp_sent_to') }}</p>
            </div>
            <button type="submit" 
                class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-brandGray hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brandGray transition">
                Verify OTP & Proceed
            </button>
        </form>
        @endif
    </div>
</section>
@endsection
