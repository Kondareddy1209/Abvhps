@extends('layouts.app')

@section('title', 'Volunteer Portal Login | ABVHPS')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-md w-full space-y-6">

        {{-- Card Container --}}
        <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden">

            {{-- Header Banner --}}
            <div class="bg-gradient-to-r from-orange-700 via-orange-600 to-amber-600 p-6 text-center text-white">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full overflow-hidden bg-white border-2 border-white/80 shadow-md mx-auto mb-2 flex items-center justify-center p-0.5">
                    <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
                </div>
                <h2 class="text-xl font-black uppercase tracking-tight">Volunteer Portal</h2>
                <p class="text-orange-100 text-xs font-semibold mt-1">
                    ABVHPS Sanathana Dharma Cadre Network
                </p>
            </div>

            {{-- Body --}}
            <div class="p-6 sm:p-8 space-y-5">

                {{-- Alert Messages --}}
                @if(session('success'))
                    <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-bold">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-bold">
                        ⚠️ {{ session('error') }}
                    </div>
                @endif

                @if(session('status'))
                    <div class="p-3 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl text-xs font-bold">
                        ℹ️ {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs space-y-1">
                        @foreach($errors->all() as $err)
                            <div>• {{ $err }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('volunteer.login.submit') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="volunteer_id" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">
                            6-Digit Volunteer ID <span class="text-orange-600">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                🆔
                            </div>
                            <input
                                type="text"
                                id="volunteer_id"
                                name="volunteer_id"
                                value="{{ old('volunteer_id') }}"
                                maxlength="6"
                                pattern="[0-9]{6}"
                                inputmode="numeric"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="e.g. 100001"
                                class="w-full bg-gray-50 border border-gray-300 focus:border-orange-500 focus:bg-white rounded-xl pl-10 pr-4 py-3 text-sm font-mono font-black text-gray-900 tracking-widest outline-none transition"
                            >
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1 block">Enter your assigned 6-digit numeric login ID</span>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-black text-gray-700 uppercase tracking-wider">
                                Password <span class="text-orange-600">*</span>
                            </label>
                            <a href="{{ route('volunteer.forgot_password') }}" class="text-[11px] font-bold text-orange-600 hover:underline">
                                Forgot Password?
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                🔑
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter password"
                                class="w-full bg-gray-50 border border-gray-300 focus:border-orange-500 focus:bg-white rounded-xl pl-10 pr-4 py-3 text-sm font-medium text-gray-900 outline-none transition"
                            >
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded"
                        >
                        <label for="remember" class="ml-2 block text-xs text-gray-600 font-semibold">
                            Remember my login on this device
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-700 hover:to-amber-600 text-white font-black text-xs py-3.5 px-4 rounded-xl shadow-md uppercase tracking-wider transition transform hover:-translate-y-0.5 cursor-pointer"
                    >
                        Sign In to Volunteer Portal →
                    </button>

                </form>

                <div class="pt-3 border-t border-gray-100 text-center space-y-2">
                    <p class="text-xs text-gray-500">
                        Not an approved volunteer yet?
                    </p>
                    <div class="flex items-center justify-center gap-3 text-xs font-bold">
                        <a href="{{ route('volunteer.check') }}" class="text-orange-600 hover:underline">
                            Register as Volunteer
                        </a>
                        <span class="text-gray-300">·</span>
                        <a href="{{ route('public.home') }}" class="text-gray-500 hover:underline">
                            Back to Home
                        </a>
                    </div>
                </div>

            </div>

        </div>

        {{-- Footer note --}}
        <div class="text-center text-[10px] text-gray-400 font-medium">
            Official ABVHPS Volunteer Management Authentication System &middot; 256-Bit SSL Encrypted
        </div>

    </div>
</div>
@endsection
