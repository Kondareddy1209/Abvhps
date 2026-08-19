@extends('layouts.app')

@section('title', 'Change Temporary Password | ABVHPS Volunteer Portal')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-md w-full space-y-6">

        <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-orange-700 via-orange-600 to-amber-600 p-6 text-center text-white">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-white/15 border border-white/20 text-2xl mb-2">
                    🔒
                </div>
                <h2 class="text-lg font-black uppercase tracking-tight">Security Update Required</h2>
                <p class="text-orange-100 text-xs font-semibold mt-1">
                    Set your permanent confidential password
                </p>
            </div>

            <div class="p-6 sm:p-8 space-y-5">

                {{-- Security Alert --}}
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900 space-y-1">
                    <div class="font-black flex items-center gap-1.5 text-amber-950 uppercase tracking-wide">
                        <span>⚠️</span> First-Login Security Protocol
                    </div>
                    <p class="text-[11px] leading-relaxed">
                        For the security of your volunteer profile and regional assignment, you must replace your default temporary password with a permanent confidential password before accessing the Volunteer Dashboard.
                    </p>
                </div>

                @if(session('warning'))
                    <div class="p-3 bg-amber-50 border border-amber-200 text-amber-900 rounded-xl text-xs font-bold">
                        {{ session('warning') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs space-y-1">
                        @foreach($errors->all() as $err)
                            <div>• {{ $err }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('volunteer.change_password.submit') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="current_password" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">
                            Current Temporary Password <span class="text-orange-600">*</span>
                        </label>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter current temporary password"
                            class="w-full bg-gray-50 border border-gray-300 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-medium text-gray-900 outline-none transition"
                        >
                    </div>

                    <div>
                        <label for="new_password" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">
                            New Permanent Password <span class="text-orange-600">*</span>
                        </label>
                        <input
                            type="password"
                            id="new_password"
                            name="new_password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Minimum 8 characters"
                            class="w-full bg-gray-50 border border-gray-300 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-medium text-gray-900 outline-none transition"
                        >
                        <span class="text-[10px] text-gray-400 mt-1 block">Must be at least 8 characters long and different from temporary password</span>
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">
                            Confirm New Password <span class="text-orange-600">*</span>
                        </label>
                        <input
                            type="password"
                            id="new_password_confirmation"
                            name="new_password_confirmation"
                            required
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Re-type new password"
                            class="w-full bg-gray-50 border border-gray-300 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-medium text-gray-900 outline-none transition"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-700 hover:to-amber-600 text-white font-black text-xs py-3.5 px-4 rounded-xl shadow-md uppercase tracking-wider transition transform hover:-translate-y-0.5 cursor-pointer"
                    >
                        Save New Password &amp; Access Dashboard →
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>
@endsection
