@extends('layouts.app')

@section('content')
<section class="max-w-3xl mx-auto my-8 space-y-6 px-4">
    
    <!-- 1. Dashboard Header Ribbon Grid -->
    <div class="bg-white p-5 rounded-xl shadow border border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <span class="text-xs font-bold text-brandOrange uppercase tracking-wider block">Village President Dashboard</span>
            <h2 class="text-lg font-black text-brandGray mt-0.5">Locality: {{ session('auth_volunteer_locality') }}</h2>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold text-gray-400 uppercase">ID: {{ session('auth_volunteer_code') }}</span>
            <a href="/volunteer/logout" class="bg-red-50 text-red-600 font-bold text-xs py-1.5 px-4 rounded border border-red-100 hover:bg-red-100 transition uppercase tracking-wide">Sign Out</a>
        </div>
    </div>
        <!-- 1.5 Live Analytics Structural Hierarchy Count Indicator Cards -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Card 1: Total Area Members Mapped Container -->
        <div class="bg-white p-4 rounded-xl shadow border-b-4 border-brandOrange text-center">
            <span class="text-2xl block mb-1">👥</span>
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Total Area Members</span>
            <span class="text-2xl font-black text-brandGray block mt-0.5">{{ $totalMembersCount ?? 0 }}</span>
        </div>

        <!-- Card 2: Total Seva Benefits Delivered Container -->
        <div class="bg-white p-4 rounded-xl shadow border-b-4 border-green-500 text-center">
            <span class="text-2xl block mb-1">🎁</span>
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Benefits Delivered</span>
            <span class="text-2xl font-black text-green-600 block mt-0.5">{{ $totalBenefitsCount ?? 0 }}</span>
        </div>
    </div>


    <!-- Alert Message Tracker Panels -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-3 text-xs text-green-700 rounded font-semibold shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-3 text-xs text-red-700 rounded font-semibold shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- 2. Step A: Search Member Record Input Box Component -->
    <div class="bg-white p-6 rounded-xl shadow border border-gray-100 space-y-4">
        <h3 class="text-xs font-black text-brandGray uppercase tracking-wider border-b border-gray-100 pb-2 flex items-center gap-1"><span>🔍</span> Live Seva Benefit Counter Counter</h3>
        
        <form action="/volunteer/dashboard/village/search-member" method="POST" class="flex flex-col sm:flex-row gap-3">
            @csrf
            <input type="text" name="member_id" required maxlength="12" value="{{ $searchedMember->membership_id ?? '' }}"
                class="block flex-1 px-4 py-2 border border-gray-300 rounded-md text-sm text-brandGray font-bold tracking-widest text-center focus:ring-brandOrange focus:border-brandOrange"
                placeholder="ENTER 12-DIGIT MEMBERSHIP ID">
            <button type="submit" class="bg-brandOrange text-white font-bold text-xs py-2 px-6 rounded-md uppercase tracking-wider hover:bg-opacity-90 transition shadow">
                Fetch Profile
            </button>
        </form>
    </div>

    <!-- 3. Step B: Dynamic Mapped Profile Card View & 1KB-2KB Photo Input Form -->
    @if(isset($searchedMember))
        <div class="bg-white p-6 rounded-xl shadow border border-brandOrange/30 space-y-6">
            <h3 class="text-xs font-black text-brandOrange uppercase tracking-wider border-b border-orange-100 pb-2">Verified Member Profile Mapped</h3>
            
            <!-- Mini Profile Preview Ribbon Layout -->
            <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="w-14 h-14 bg-gray-200 rounded-md overflow-hidden border border-brandOrange/40">
                    @if($searchedMember->photo_path)
                        <img src="{{ asset('storage/' . $searchedMember->photo_path) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 font-bold">No Photo</div>
                    @endif
                </div>
                <div class="text-xs space-y-0.5 text-brandGray">
                    <p class="font-black text-sm uppercase text-brandDarkGray">{{ $searchedMember->full_name }}</p>
                    <p class="font-semibold uppercase text-gray-500">Grama Panchayat: <strong class="text-brandGray">{{ $searchedMember->grama_panchayat }}</strong></p>
                    <p class="font-semibold uppercase text-gray-500">Blood Group: <strong class="text-red-600">{{ $searchedMember->blood_group }}</strong></p>
                </div>
            </div>

            <!-- Seva Delivery Form Trigger Routing to Image Compression Engine -->
            <form action="/volunteer/dashboard/village/deliver-seva" method="POST" enctype="multipart/form-data" class="space-y-4 pt-2">
                @csrf
                <input type="hidden" name="member_id" value="{{ $searchedMember->membership_id }}">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Dropdown Select 1: Core Service Item Metrics Type -->
                    <div>
                        <label for="service_type" class="block text-xs font-bold text-brandGray uppercase mb-1">Select Seva/Benefit Distributed</label>
                        <select id="service_type" name="service_type" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md text-xs text-brandGray font-semibold focus:ring-brandOrange focus:border-brandOrange">
                            <option value="Free Medical Camp & Medicines">Free Medical Camp & Medicines</option>
                            <option value="Cow Goseva Fodder Feed Support">Cow Goseva Fodder Feed Support</option>
                            <option value="Akshara Student Education Kit">Akshara Student Education Kit</option>
                            <option value="Annapurna Free Meal Food Service">Annapurna Free Meal Food Service</option>
                        </select>
                    </div>

                    <!-- Input file 2: Live Proof Photo Box Routing to 1KB Compression -->
                    <div>
                        <label for="proof_photo" class="block text-xs font-bold text-brandGray uppercase mb-1">Upload Live Delivery Photo (Proof)</label>
                        <input type="file" id="proof_photo" name="proof_photo" accept="image/*" required
                            class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-orange-100 file:text-brandOrange hover:file:bg-orange-200 cursor-pointer">
                        <span class="text-[10px] text-gray-400 font-bold block mt-1 uppercase">Note: System compresses this image automatically below 2KB space</span>
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 text-xs font-black rounded-md text-white bg-brandOrange hover:bg-opacity-90 transition shadow uppercase tracking-wider">
                    Submit Delivery Proof & Record Digital History
                </button>
            </form>
        </div>
    @endif
    <!-- 4. Section C: Community Mass Seva Group Event Upload Block Components -->
    <div class="bg-white p-6 rounded-xl shadow border border-gray-100 space-y-4">
        <h3 class="text-xs font-black text-brandGray uppercase tracking-wider border-b border-gray-100 pb-2 flex items-center gap-1"><span>📸</span> Mass Community Seva Event Tracker Dashboard</h3>
        
        <!-- Group photo upload form structural layout config with multi-part routing enctype -->
        <form action="/volunteer/dashboard/village/upload-group-event" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end bg-gray-50 p-4 rounded-lg border border-gray-200">
            @csrf
            
            <!-- Entry Input Column 1: Event Name Tracker Metrics -->
            <div>
                <label for="event_title" class="block text-xs font-bold text-brandGray uppercase mb-1">Event/Activity Title Name</label>
                <input type="text" id="event_title" name="event_title" required
                    class="block w-full px-3 py-1.5 border border-gray-300 rounded text-xs text-brandGray font-semibold focus:ring-brandOrange focus:border-brandOrange"
                    placeholder="E.g. Free Annadanam Service, Farmers Meet">
            </div>

            <!-- Entry Input Column 2: Heavy Camera File Tracker mapped to 30KB Compression -->
            <div>
                <label for="group_photo" class="block text-xs font-bold text-brandGray uppercase mb-1">Upload Group Activity Photo</label>
                <input type="file" id="group_photo" name="group_photo" accept="image/*" required
                    class="block w-full text-xs text-gray-500 file:mr-3 file:py-1 file:px-2 file:rounded file:border-0 file:text-[11px] file:font-bold file:bg-orange-100 file:text-brandOrange hover:file:bg-orange-200 cursor-pointer">
            </div>

            <!-- Action Button Submit Module Layout Grid -->
            <div>
                <button type="submit" class="w-full py-1.5 px-4 border border-transparent text-xs font-black rounded text-white bg-brandOrange hover:bg-opacity-90 transition shadow-sm uppercase tracking-wider">
                    Publish Group Event &rarr;
                </button>
            </div>
        </form>
    </div>

    <!-- 5. Section D: Dynamic Group Event Albums Visual Gallery Component -->
    <div class="bg-white p-5 rounded-xl shadow border border-gray-100 space-y-3">
        <h3 class="text-xs font-black text-brandGray uppercase tracking-wider border-b border-gray-100 pb-2">🖼️ Published Community Mass Event Photo Gallery Logs</h3>
        
        <!-- Live Matrix Display mapping group logs compiled directly from database streams -->
        @if(isset($groupEvents) && count($groupEvents) > 0)
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($groupEvents as $event)
                    <div class="bg-gray-50 border border-gray-200 p-2 rounded shadow-sm text-center space-y-1">
                        <!-- High resolution pixels compressed dynamically down to optimized 30KB-50KB memory targets -->
                        <div class="w-full h-24 bg-gray-200 rounded overflow-hidden shadow-inner border border-gray-300">
                            <img src="{{ asset('storage/' . $event->group_photo_path) }}" class="w-full h-full object-cover" alt="Group Event Album Asset">
                        </div>
                        <p class="font-black text-brandDarkGray uppercase text-[10.5px] truncate px-0.5 leading-none pt-1">{{ $event->event_title }}</p>
                        <span class="text-[9.5px] text-gray-400 font-bold uppercase tracking-wider block border-t border-gray-200/60 pt-1">On: {{ date('d-m-Y', strtotime($event->created_at)) }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Fallback Blank Indicator Container Slot -->
            <div class="p-6 bg-gray-50 rounded border border-dashed border-gray-200 text-center text-xs text-gray-400 font-medium">
                No mass activity group events or community albums published from this village council zone yet.
            </div>
        @endif
    </div>

</section>
@endsection
