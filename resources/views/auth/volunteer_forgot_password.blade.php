@extends('layouts.app')

@section('title', 'Forgot Password | ABVHPS Volunteer Portal')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-md w-full space-y-6">

        <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden">

            <div class="bg-gradient-to-r from-orange-700 via-orange-600 to-amber-600 p-6 text-center text-white">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-white/15 border border-white/20 text-2xl mb-2">
                    🔑
                </div>
                <h2 class="text-lg font-black uppercase tracking-tight">Recover Credentials</h2>
                <p class="text-orange-100 text-xs font-semibold mt-1">
                    ABVHPS Volunteer Password Reset
                </p>
            </div>

            <div class="p-6 sm:p-8 space-y-5">

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

                <form method="POST" action="{{ route('volunteer.forgot_password.submit') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="login_identifier" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">
                            6-Digit Volunteer ID or Registered Email <span class="text-orange-600">*</span>
                        </label>
                        <input
                            type="text"
                            id="login_identifier"
                            name="login_identifier"
                            value="{{ old('login_identifier') }}"
                            required
                            autofocus
                            placeholder="e.g. 100001 or name@example.com"
                            class="w-full bg-gray-50 border border-gray-300 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-medium text-gray-900 outline-none transition"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-700 hover:to-amber-600 text-white font-black text-xs py-3.5 px-4 rounded-xl shadow-md uppercase tracking-wider transition transform hover:-translate-y-0.5 cursor-pointer"
                    >
                        Send Password Reset Link →
                    </button>

                </form>

                <div class="pt-3 border-t border-gray-100 text-center">
                    <a href="{{ route('volunteer.login') }}" class="text-xs font-bold text-orange-600 hover:underline">
                        &larr; Back to Volunteer Login
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
