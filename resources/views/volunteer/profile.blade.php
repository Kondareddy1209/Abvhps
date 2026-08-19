@extends('layouts.app')

@section('title', 'Volunteer Profile Dossier | ABVHPS')

@section('content')
<div class="bg-gray-50 min-h-screen pb-16">

    <div class="bg-gradient-to-r from-orange-900 via-orange-800 to-amber-900 text-white py-10 px-4 shadow-md border-b-4 border-yellow-500">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <div>
                <a href="{{ route('volunteer.dashboard') }}" class="text-xs text-yellow-300 font-bold hover:underline mb-1 inline-block">
                    &larr; Back to Volunteer Dashboard
                </a>
                <h1 class="text-2xl md:text-3xl font-black uppercase tracking-wide text-white">
                    Official Volunteer Dossier
                </h1>
            </div>
            <div>
                <span class="bg-yellow-400 text-orange-950 font-mono font-black text-sm px-3 py-1 rounded-lg">
                    {{ $volunteer->volunteer_login_id ?? '100001' }}
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-6">

        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden p-6 sm:p-8 space-y-6">

            {{-- Photo & Basic Info Header --}}
            <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-gray-100">
                <div class="w-28 h-32 rounded-2xl border-2 border-orange-300 overflow-hidden bg-orange-50 flex items-center justify-center shadow-sm">
                    @if($volunteer->photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($volunteer->photo_path))
                        <img src="{{ asset('storage/' . $volunteer->photo_path) }}" alt="{{ $volunteer->full_name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-4xl">👤</span>
                    @endif
                </div>

                <div class="space-y-1 text-center sm:text-left">
                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase">
                        ● Verified &amp; Active
                    </span>
                    <h2 class="text-xl font-black text-gray-900 uppercase">
                        {{ $volunteer->full_name }}
                    </h2>
                    <p class="text-xs font-bold text-brandOrange">
                        {{ $volunteer->cadre_label }} &mdash; {{ $volunteer->locality ?? 'Regional Field' }}
                    </p>
                    <div class="flex flex-wrap gap-2 pt-1 justify-center sm:justify-start text-xs font-mono">
                        <span class="bg-orange-50 text-orange-700 border border-orange-200 px-2.5 py-0.5 rounded font-bold">VOLUNTEER ID: {{ $volunteer->volunteer_id ?? $volunteer->volunteer_login_id }}</span>
                        <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded">MEMBER ID: {{ $volunteer->membership_id }}</span>
                    </div>
                </div>
            </div>

            {{-- Details Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">

                {{-- Academic & Identification --}}
                <div class="p-5 bg-gray-50 rounded-2xl space-y-3">
                    <h4 class="font-black text-gray-700 uppercase tracking-wider text-[11px] border-b border-gray-200 pb-1">
                        Academic &amp; Contact Information
                    </h4>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Qualification:</span>
                        <span class="font-bold text-gray-900">{{ $volunteer->qualification ?? 'Graduate' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Voter ID / Gov ID:</span>
                        <span class="font-mono font-bold text-gray-900">{{ $volunteer->voter_id_number ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Registered Email:</span>
                        <span class="font-bold text-gray-900">{{ $volunteer->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Registered Mobile:</span>
                        <span class="font-mono font-bold text-gray-900">{{ $volunteer->phone }}</span>
                    </div>
                </div>

                {{-- Regional Jurisdiction --}}
                <div class="p-5 bg-gray-50 rounded-2xl space-y-3">
                    <h4 class="font-black text-gray-700 uppercase tracking-wider text-[11px] border-b border-gray-200 pb-1">
                        Jurisdictional Deployment
                    </h4>
                    <div class="flex justify-between">
                        <span class="text-gray-500">State:</span>
                        <span class="font-bold text-gray-900">{{ $volunteer->resolved_state ?? 'Andhra Pradesh' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">District:</span>
                        <span class="font-bold text-gray-900">{{ $volunteer->resolved_district ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Taluk / Assembly:</span>
                        <span class="font-bold text-gray-900">{{ $volunteer->resolved_assembly_segment ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Mandal &amp; Panchayat:</span>
                        <span class="font-bold text-gray-900">{{ $volunteer->resolved_mandal ?? '—' }} / {{ $volunteer->resolved_grama_panchayat ?? '—' }}</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection
