@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">
    
    <!-- CENTRAL ADMIN FUNDRAISING CONTROL DESK WORKSPACE -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        
        <!-- Header Badge -->
        <div class="text-center bg-brandDarkGray text-white p-6 border-b-4 border-brandOrange">
            <span class="text-4xl block mb-1 drop-shadow">💰</span>
            <h1 class="text-xl md:text-2xl font-black tracking-wider uppercase text-brandOrange">DEPLOY NEW FUNDRAISING CAMPAIGN</h1>
            <p class="text-gray-300 mt-1 font-medium text-xs tracking-wide">Central Administrative Campaign Configuration Panel</p>
        </div>

        <!-- Heavy Asset Multipart Form Gateway -->
        <form action="{{ route('admin.fundraising.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-5">
            @csrf

            <!-- BLOCK A: PRIMARY PARAMETERS METRICS -->
            <div class="border-b border-gray-200 pb-1">
                <h3 class="text-xs font-black text-brandGray uppercase tracking-wider">Block A: Campaign Core Configuration</h3>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Campaign Strategic Title *</label>
                    <input type="text" name="title" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="E.g. COWS RECONSTRUCTION AND MAINTENANCE">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Financial Target Amount (INR) *</label>
                        <input type="number" name="target_amount" min="1" step="0.01" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm font-mono font-bold text-brandGray focus:ring-2 focus:ring-brandOrange outline-none" placeholder="Enter target budget (E.g. 500000)">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Campaign Expiry End Date *</label>
                        <input type="date" name="end_date" required min="{{ \Carbon\Carbon::today()->toDateString() }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Detailed Descriptive Purpose Explanation *</label>
                    <textarea name="description" rows="5" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm font-medium text-gray-800 focus:ring-2 focus:ring-brandOrange outline-none" placeholder="Describe the cause, current critical crisis situation, and how the funds will be transparently utilized..."></textarea>
                </div>
            </div>
            <!-- BLOCK B: PRIMARY BANNER MEDIA ASSET -->
            <div class="border-b border-gray-200 pb-1 pt-2">
                <h3 class="text-xs font-black text-brandGray uppercase tracking-wider">Block B: Primary Display Media</h3>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Primary Display Cover Banner *</label>
                <input type="file" name="cover_image" required class="w-full text-xs p-2 bg-gray-50 border border-gray-300 rounded focus:ring-2 focus:ring-brandOrange outline-none">
                <span class="text-[10px] text-gray-500 font-semibold mt-1 block">Upload main high-quality landscape image to showcase on the master donations grid (Max 2MB).</span>
            </div>

            <!-- BLOCK C: OPTIONAL CONTEXTUAL MULTI-MEDIA GALLERY ASSETS -->
            <div class="border-b border-gray-200 pb-1 pt-2">
                <h3 class="text-xs font-black text-brandGray uppercase tracking-wider">Block C: Optional Campaign Multi-Media Grid (1 to 4 Files)</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-gray-50/60 p-3 rounded border border-gray-200 shadow-sm">
                    <label class="block text-[10px] font-black text-brandGray uppercase mb-1">Gallery Image 1</label>
                    <input type="file" name="image_1" class="w-full text-xs p-1 bg-white border border-gray-300 rounded">
                </div>
                <div class="bg-gray-50/60 p-3 rounded border border-gray-200 shadow-sm">
                    <label class="block text-[10px] font-black text-brandGray uppercase mb-1">Gallery Image 2</label>
                    <input type="file" name="image_2" class="w-full text-xs p-1 bg-white border border-gray-300 rounded">
                </div>
                <div class="bg-gray-50/60 p-3 rounded border border-gray-200 shadow-sm">
                    <label class="block text-[10px] font-black text-brandGray uppercase mb-1">Gallery Image 3</label>
                    <input type="file" name="image_3" class="w-full text-xs p-1 bg-white border border-gray-300 rounded">
                </div>
                <div class="bg-gray-50/60 p-3 rounded border border-gray-200 shadow-sm">
                    <label class="block text-[10px] font-black text-brandGray uppercase mb-1">Gallery Image 4</label>
                    <input type="file" name="image_4" class="w-full text-xs p-1 bg-white border border-gray-300 rounded">
                </div>
            </div>

            <!-- BLOCK D: EMERGENCY EXPLAINER VIDEO TEASER -->
            <div class="border-b border-gray-200 pb-1 pt-2">
                <h3 class="text-xs font-black text-brandGray uppercase tracking-wider">Block D: Emergency Explainer Video Teaser</h3>
            </div>

            <div class="bg-orange-50/30 p-4 rounded-lg border border-dashed border-brandOrange/30">
                <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Upload Crisis Action Video (Optional)</label>
                <input type="file" name="video_file" class="w-full text-xs p-2 bg-white border border-gray-300 rounded focus:ring-2 focus:ring-brandOrange outline-none">
                <span class="text-[10px] text-gray-500 font-semibold mt-1 block">Upload emergency field briefing or description video clips. Format: MP4, MOV, AVI (Max 25MB).</span>
            </div>

            <!-- Master Action Submission Action Grid Trigger -->
            <div class="text-center pt-4">
                <button type="submit" class="bg-brandOrange hover:bg-opacity-95 text-white font-black text-sm py-3 px-12 rounded-lg shadow uppercase tracking-wider w-full sm:w-auto cursor-pointer transition">
                    Deploy Live Fundraising Campaign
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
