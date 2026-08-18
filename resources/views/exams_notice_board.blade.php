@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-10">

        <!-- Header Section -->
        <div class="text-center space-y-3">
            <span class="bg-orange-100 text-brandOrange text-xs font-black px-3.5 py-1 rounded-full uppercase tracking-widest border border-orange-200">
                Examination Core Desk
            </span>
            <h1 class="text-3xl md:text-5xl font-black text-gray-900 uppercase tracking-tight">
                Sanathana Dharma <span class="text-brandOrange">Exams Info Board</span>
            </h1>
            <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto">
                Official announcement notice board and continuous cycle schedule for youth & community spiritual examinations conducted across Andhra Pradesh.
            </p>
            <div class="pt-2 flex flex-wrap justify-center gap-3">
                <a href="{{ route('exam.form') }}" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-xs px-6 py-3 rounded-lg shadow uppercase tracking-wider transition">
                    Apply Online for Active Exam
                </a>
                <a href="{{ route('exam.results_portal') }}" class="bg-gray-800 hover:bg-gray-900 text-white font-black text-xs px-6 py-3 rounded-lg shadow uppercase tracking-wider transition">
                    Check Hall Ticket Results
                </a>
            </div>
        </div>

        <!-- Exam Cycles Notice Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($exams as $exam)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-md overflow-hidden flex flex-col justify-between transform hover:-translate-y-1 transition duration-300">
                    <!-- Top Ribbon -->
                    <div class="p-6 bg-gradient-to-br from-orange-50 via-white to-amber-50 border-b border-orange-100">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="bg-brandOrange text-white text-[10px] font-black px-3 py-0.5 rounded-full uppercase">
                                Cycle #{{ $exam->id }}
                            </span>
                            @if($exam->status === 'active')
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase border border-emerald-200 animate-pulse">
                                    ● Registration Open
                                </span>
                            @elseif($exam->status === 'upcoming')
                                <span class="bg-blue-100 text-blue-800 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase border border-blue-200">
                                    ⏳ Upcoming Cycle
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-700 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase border border-gray-200">
                                    ✓ Evaluation Closed
                                </span>
                            @endif
                        </div>
                        <h3 class="text-xl font-black text-gray-900 uppercase leading-snug">
                            {{ $exam->exam_title }}
                        </h3>
                        <p class="text-xs text-gray-500 font-bold mt-2 flex items-center gap-1.5">
                            <span>📍 Center:</span> <span>{{ $exam->exam_center_location }}</span>
                        </p>
                    </div>

                    <!-- Details Body -->
                    <div class="p-6 space-y-4 text-xs">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2.5">
                            <span class="text-gray-400 font-bold uppercase text-[10px]">Examination Date</span>
                            <span class="font-mono font-bold text-gray-900 text-sm">
                                {{ $exam->exam_date_time ? \Carbon\Carbon::parse($exam->exam_date_time)->format('d M Y, h:i A') : 'TBA' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2.5">
                            <span class="text-gray-400 font-bold uppercase text-[10px]">Nominal Registration Fee</span>
                            <span class="font-mono font-black text-brandOrange text-sm">₹{{ number_format($exam->application_fee, 2) }}</span>
                        </div>

                        <!-- Prizes & Awards Matrix -->
                        <div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block mb-1.5">Grand Awards Matrix:</span>
                            <div class="bg-orange-50/60 p-3 rounded-xl border border-orange-100 space-y-1 text-[11px] font-semibold text-gray-800">
                                @php
                                    $prizes = is_array($exam->prize_details_json) ? $exam->prize_details_json : json_decode($exam->prize_details_json, true);
                                @endphp
                                @if(is_array($prizes) && count($prizes) > 0)
                                    @foreach($prizes as $prize)
                                        <div class="flex items-center gap-2">
                                            <span>🏆</span> <span>{{ $prize }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-gray-400 italic">Merit Awards & Participation Certificates</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="p-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between gap-3">
                        @if($exam->syllabus_pdf_path)
                            <a href="{{ asset('storage/'.$exam->syllabus_pdf_path) }}" target="_blank" class="text-xs font-black text-blue-600 hover:text-blue-800 flex items-center gap-1.5 transition">
                                <span>📥</span> Download Syllabus
                            </a>
                        @else
                            <span class="text-xs text-gray-400">Syllabus at Center</span>
                        @endif

                        @if($exam->status === 'active')
                            <a href="{{ route('exam.form') }}" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-xs px-4 py-2 rounded-lg uppercase shadow transition">
                                Apply Online →
                            </a>
                        @else
                            <a href="{{ route('exam.results_portal') }}" class="bg-gray-700 hover:bg-gray-800 text-white font-black text-xs px-4 py-2 rounded-lg uppercase transition">
                                Results →
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-gray-200">
                    <p class="text-gray-400 font-bold text-sm">No exam cycles currently published on the board.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
