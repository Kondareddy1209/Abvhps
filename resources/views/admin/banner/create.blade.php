@extends('layouts.app')

@section('title', 'Add New Page Banner | ABVHPS Central Board')

@section('content')
<div class="min-h-screen bg-gray-100/60 flex flex-col md:flex-row select-none">
    
    <!-- BLOCK 1: MASTER ADMINISTRATIVE LEFT SIDEBAR -->
    @include('admin.partials.sidebar')

    <!-- BLOCK 2: MASTER MAIN WORKSPACE VIEWPORT DESK -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Workspace Top Status Banner Navbar -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                @include('admin.partials.header_button')
                <span class="text-sm font-black text-brandGray uppercase tracking-wider">System View:</span>
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Add New Page Banner</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xs font-black text-brandGray uppercase tracking-wider flex items-center gap-1.5">
                        🚩 Create New Page-Specific Banner
                    </h3>
                    <p class="text-[10px] text-gray-500 mt-0.5">Select a website page and upload corresponding desktop & mobile images.</p>
                </div>
                <a href="{{ route('admin.banner.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-[10px] px-4 py-2 rounded-lg uppercase tracking-wider transition">
                    &larr; Back to Banners
                </a>
            </div>

            <!-- Error Alerts -->
            @if($errors->any())
                <div class="p-4 bg-rose-50 text-rose-800 border border-rose-200 rounded-xl text-xs space-y-1">
                    <div class="font-black uppercase tracking-wider">Please correct the following errors:</div>
                    <ul class="list-disc list-inside text-[11px] font-medium">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Add Banner Form Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-3xl">
                <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- 1. Page Selector (Required) -->
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-700 mb-1.5 tracking-wider">
                            Page * <span class="text-brandOrange font-normal text-[10px] normal-case">(Which website page this banner belongs to)</span>
                        </label>
                        <select name="page_key" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-brandOrange bg-white">
                            <option value="" disabled {{ old('page_key') ? '' : 'selected' }}>-- Select Website Page --</option>
                            @foreach($pages as $pKey => $pLabel)
                                <option value="{{ $pKey }}" {{ old('page_key') === $pKey ? 'selected' : '' }}>
                                    {{ $pLabel }} (slug: {{ $pKey }})
                                </option>
                            @endforeach
                        </select>
                        <span class="text-[10px] text-gray-400 mt-1 block">When a visitor browses this page, this banner will automatically display.</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- 2. Desktop Banner File Upload -->
                        <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-200">
                            <label class="block text-xs font-black uppercase text-gray-700 mb-1.5 tracking-wider">
                                Desktop Banner *
                            </label>
                            <input type="file" name="desktop_banner" accept="image/jpeg,image/png,image/webp" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-brandOrange">
                            <span class="text-[10px] text-gray-500 mt-1.5 block">
                                Recommended: 1920 &times; 600 px (JPG, PNG, WEBP &mdash; Max 5MB).
                            </span>
                        </div>

                        <!-- 3. Mobile Banner File Upload (Optional) -->
                        <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-200">
                            <label class="block text-xs font-black uppercase text-gray-700 mb-1.5 tracking-wider">
                                Mobile Banner <span class="text-gray-400 font-normal text-[10px] normal-case">(Optional)</span>
                            </label>
                            <input type="file" name="mobile_banner" accept="image/jpeg,image/png,image/webp" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-brandOrange">
                            <span class="text-[10px] text-gray-500 mt-1.5 block">
                                Recommended: 768 &times; 600 px. If empty, desktop banner will be used automatically.
                            </span>
                        </div>
                    </div>

                    <!-- 4. Status Selector -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black uppercase text-gray-700 mb-1.5 tracking-wider">
                                Status *
                            </label>
                            <select name="status" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-brandOrange bg-white">
                                <option value="show" {{ old('status', 'show') === 'show' ? 'selected' : '' }}>Show (Active &amp; Visible to Devotees)</option>
                                <option value="hide" {{ old('status') === 'hide' ? 'selected' : '' }}>Hide (Inactive / Hidden from Website)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase text-gray-700 mb-1.5 tracking-wider">
                                Display Sort Order <span class="text-gray-400 font-normal text-[10px] normal-case">(Optional)</span>
                            </label>
                            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', 0) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-mono font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-brandOrange" placeholder="0">
                        </div>
                    </div>

                    <!-- 5. Optional Text Overlay Info -->
                    <div class="space-y-4 pt-2 border-t border-gray-100">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Optional Banner Header Text Overlay</div>
                        
                        <div>
                            <label class="block text-xs font-black uppercase text-gray-700 mb-1 tracking-wider">
                                Banner Heading Title <span class="text-gray-400 font-normal text-[10px] normal-case">(Optional)</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-brandOrange" placeholder="e.g. Service Media Gallery">
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase text-gray-700 mb-1 tracking-wider">
                                Banner Subtitle / Tagline <span class="text-gray-400 font-normal text-[10px] normal-case">(Optional)</span>
                            </label>
                            <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-brandOrange" placeholder="e.g. Live glimpses of our social and religious service activities across India">
                        </div>
                    </div>

                    <!-- Submit & Cancel Buttons -->
                    <div class="pt-4 flex items-center gap-3 border-t border-gray-100">
                        <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-xs px-6 py-2.5 rounded-lg shadow-sm uppercase tracking-wider transition">
                            Add Banner
                        </button>
                        <a href="{{ route('admin.banner.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs px-5 py-2.5 rounded-lg uppercase tracking-wider transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </main> <!-- END WORKSPACE CONTAINER -->
    </div> <!-- END MAIN WORKSPACE VIEWPORT DESK -->
</div> <!-- END MIN-H-SCREEN CONTAINER -->
@endsection
