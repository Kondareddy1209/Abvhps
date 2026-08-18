@extends('layouts.app')

@section('content')
<section class="min-h-[500px] flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow border border-gray-100 text-center">
        <span class="text-4xl text-brandOrange">🔱</span>
        <h2 class="mt-2 text-2xl font-extrabold text-brandGray">Membership Fee Payment</h2>
        <p class="text-xs text-gray-500 mt-1">Akhanda Bharatha Viswa Hindu Parirakshana Samiti</p>
        
        <div class="my-8 p-6 bg-brandLightOrange rounded-lg border border-orange-100">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Total Amount Payable</span>
            <span class="text-4xl font-black text-brandOrange">₹100.00</span>
            <div class="h-[1px] bg-orange-200 my-3"></div>
            <p class="text-xs text-brandGray font-medium">Verified Phone: <strong class="tracking-wider">+91 {{ session('verified_membership_phone') }}</strong></p>
        </div>

        <!-- Simulated Payment Success Trigger Form for project configuration stage -->
        <form action="/membership/process-payment" method="POST" class="space-y-4">
            @csrf
            <p class="text-xs text-gray-500 leading-relaxed">
                By clicking below, your ready-made payment gateway instance initializes. Once payment status turns successful, a 12-digit random unique tracking code generates.
            </p>
            
            <button type="submit" 
                class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-brandOrange hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brandOrange shadow transition">
                Pay ₹100 Securely Now
            </button>
        </form>

        <div class="mt-4">
            <a href="/membership" class="text-xs font-bold text-brandGray hover:text-brandOrange uppercase tracking-wide">&larr; Change Phone Number</a>
        </div>
    </div>
</section>
@endsection
