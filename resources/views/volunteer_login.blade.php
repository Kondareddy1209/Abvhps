@extends('layouts.app')

@section('content')
<section class="min-h-[500px] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow border border-gray-100">
        
        <!-- Header Brand Layout Banner -->
        <div class="text-center">
            <span class="text-4xl text-brandOrange block">🔱</span>
            <h2 class="mt-2 text-xl font-black text-brandGray uppercase tracking-wide">Official Pipeline Login</h2>
            <p class="mt-1 text-xs text-gray-500">ABVHPS Administrative Governance Council Desk</p>
        </div>

        <!-- Session Flash Status Notification Alerts Tracking -->
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-3 text-xs text-red-700 rounded font-semibold shadow-sm">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-3 text-xs text-green-700 rounded font-semibold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Secure Credentials Access Verification Form Block -->
        <form class="mt-6 space-y-4" action="/volunteer/process-login" method="POST">
            @csrf
            
            <!-- Input 1: 6-Digit Mapped Identification Key Tracker -->
            <div>
                <label for="volunteer_id" class="block text-xs font-bold text-brandGray uppercase tracking-wide mb-1">Volunteer / President ID</label>
                <input id="volunteer_id" name="volunteer_id" type="text" required maxlength="6" pattern="[0-9]*" inputmode="numeric"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-brandOrange focus:border-brandOrange text-brandGray font-semibold tracking-widest text-center" 
                    placeholder="Enter 6-Digit ID (E.g. 662424)">
            </div>

            <!-- Input 2: Encrypted Guard Passcode Metric with Eye Visibility Toggle Button -->
            <div>
                <label for="password" class="block text-xs font-bold text-brandGray uppercase tracking-wide mb-1">Access Password</label>
                <div class="relative rounded-md shadow-sm">
                    <input id="password" name="password" type="password" required
                        class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brandOrange focus:border-brandOrange text-brandGray font-semibold" 
                        placeholder="Enter Secure Password">
                    <!-- Pure absolute positioning container slot pushing eye tracker button -->
                    <button type="button" id="toggle_password_visibility"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 font-bold text-brandOrange focus:outline-none hover:text-opacity-80 transition select-none">
                        👁️
                    </button>
                </div>
            </div>

            <!-- Action Button Submit Authentication Trigger -->
            <div class="pt-2">
                <button type="submit" 
                    class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-brandOrange hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brandOrange shadow transition uppercase tracking-wider">
                    Sign In to Dashboard
                </button>
            </div>
        </form>

        <div class="text-center pt-2 border-t border-gray-100">
            <a href="/" class="text-xs font-bold text-gray-400 hover:text-brandOrange uppercase tracking-wide">&larr; Return to Main Home</a>
        </div>

    </div>
</section>

<!-- Lightweight Javascript client layout switch tracking metrics action -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const passwordInput = document.getElementById("password");
        const toggleButton = document.getElementById("toggle_password_visibility");

        toggleButton.addEventListener("click", function() {
            // Toggling input type attributes based on visibility states tracking
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.textContent = "🙈"; // Shifting icon layout to hide state
            } else {
                passwordInput.type = "password";
                toggleButton.textContent = "👁️"; // Shifting icon layout back to view state
            }
        });
    });
</script>
@endsection
