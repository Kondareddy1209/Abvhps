@extends('layouts.app')

@section('content')
<!-- Public Website Our Team Page Header Banner -->
<div class="bg-gray-900 text-white py-12 text-center" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/assets/images/banner.jpg') no-repeat center center; background-size: cover;">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold uppercase tracking-wide text-orange-500">🔱 Our Leadership Team</h1>
        <p class="text-xs md:text-sm text-gray-300 mt-2 uppercase tracking-widest">Global Cadre Hierarchy Leadership Matrix of ABVHPS</p>
    </div>
</div>

<div class="py-12 bg-gray-50/50">
    <div class="container mx-auto px-4">
        <!-- Live Admin Team Members Display Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($teamMembers as $member)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 transition-all hover:shadow-lg flex flex-col h-full text-center p-5">
                    
                    <!-- Leader Profile Photo Block -->
                    <div class="w-28 h-36 bg-gray-100 border rounded-lg mx-auto overflow-hidden shadow-sm relative group shrink-0 mb-4">
                        @if($member->image_path)
                            <img src="{{ asset('storage/' . $member->image_path) }}" class="w-full h-full object-cover transition-all duration-300 group-hover:scale-105" alt="Leader Profile">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 font-bold text-[10px]">No Photo</div>
                        @endif
                    </div>

                    <!-- Leader Name and Details Body -->
                    <div class="flex flex-col flex-1 justify-between">
                        <div>
                            <!-- Leader Full Name -->
                            <h4 class="text-base font-bold text-gray-900 uppercase tracking-wide mb-1">
                                {{ $member->name }}
                            </h4>
                            
                            <!-- Designation / Role -->
                            <span class="text-xs font-black text-orange-600 uppercase tracking-wider block mb-2">
                                {{ $member->designation }}
                            </span>
                            
                            <!-- Cadre Hierarchy Level Badge -->
                            <div class="mb-3">
                                <span class="bg-orange-50 text-orange-600 text-[9px] font-black px-2 py-0.5 rounded border border-orange-100 uppercase tracking-wider inline-block">
                                    {{ str_replace('_', ' ', $member->cadre_level) }}
                                </span>
                            </div>
                        </div>

                        <!-- Locality and Verified Membership Smart Card ID Footer -->
                        <div class="pt-3 border-t border-gray-100 mt-auto">
                            <span class="block text-[11px] text-gray-500 font-bold uppercase tracking-wide mb-1">
                                📍 Region: {{ $member->locality }}
                            </span>
                            
                            @if($member->membership_id)
                                <span class="font-mono text-[10px] font-black text-emerald-600 bg-emerald-50 px-2 py-1 rounded border border-emerald-100 uppercase tracking-wider inline-block">
                                    ID: {{ implode(' ', str_split($member->membership_id, 4)) }}
                                </span>
                            @else
                                <span class="text-[9px] text-gray-400 font-bold block">Official Samiti Member</span>
                            @endif
                        </div>
                    </div>

                </div>
            @empty
                <!-- Fallback block if team registry table is clear -->
                <div class="col-span-full text-center py-12">
                    <span class="text-4xl block mb-2">👥</span>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">No committee leader profiles discovered inside the team registry yet.</h3>
                </div>
            @endforelse
        </div>

    </div> <!-- End Container -->
</div> <!-- End Py-12 Wrapper -->
@endsection
