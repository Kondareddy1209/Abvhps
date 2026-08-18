@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-10">

        <!-- Page Header -->
        <div class="text-center space-y-3">
            <span class="bg-orange-100 text-brandOrange text-xs font-black px-3.5 py-1 rounded-full uppercase tracking-widest border border-orange-200">
                Official Statutory Disclosures
            </span>
            <h1 class="text-3xl md:text-5xl font-black text-gray-900 uppercase tracking-tight">
                Tax & Legal <span class="text-brandOrange">Compliance Certificates</span>
            </h1>
            <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto">
                Official registration documents, Income Tax Section 12A exemption, 80G tax rebate certificates, and Ministry of Corporate Affairs CSR-1 accreditations of ABVHPS.
            </p>
        </div>

        <!-- Certificates Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($certificates as $cert)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-md p-6 flex flex-col justify-between transform hover:-translate-y-1 transition duration-200 space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="bg-orange-50 text-brandOrange border border-orange-200 text-[10px] font-black px-2.5 py-1 rounded-full uppercase">
                                {{ $cert->certificate_type }}
                            </span>
                            <span class="text-xl">📜</span>
                        </div>
                        <h3 class="text-lg font-black text-gray-900 uppercase leading-snug">
                            {{ $cert->title }}
                        </h3>
                        @if($cert->document_number)
                            <div class="text-xs font-mono font-bold text-gray-500 bg-gray-50 p-2 rounded-lg border border-gray-100">
                                Reg No: {{ $cert->document_number }}
                            </div>
                        @endif
                        @if($cert->description)
                            <p class="text-xs text-gray-600 leading-relaxed">
                                {{ $cert->description }}
                            </p>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-[10px] font-mono text-gray-400">
                            Valid: {{ $cert->valid_from ? $cert->valid_from->format('M Y') : 'Permanent' }} {{ $cert->valid_to ? '- '.$cert->valid_to->format('M Y') : '' }}
                        </span>
                        <a href="{{ $cert->file_url }}" target="_blank" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-xs px-4 py-2 rounded-lg uppercase shadow flex items-center gap-1.5 transition">
                            <span>📥</span> Download PDF
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-gray-200">
                    <p class="text-gray-400 font-bold text-sm">No statutory certificates published yet.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
