@extends('layouts.app')

@section('title', 'Edit Page Banner | ABVHPS Central Board')

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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Edit Page Banner #{{ $banner->id }}</span>
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
                        🚩 Edit Banner for '{{ $banner->page_name ?? $banner->page_key }}'
                    </h3>
                    <p class="text-[10px] text-gray-500 mt-0.5">Modify the assigned page, update images, or toggle display status.</p>
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

            <!-- Edit Banner Form Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-3xl">
                <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- 1. Page Selector (Required) -->
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-700 mb-1.5 tracking-wider">
                            Page * <span class="text-brandOrange font-normal text-[10px] normal-case">(Change which website page this banner belongs to)</span>
                        </label>
                        <select name="page_key" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-brandOrange bg-white">
                            @foreach($pages as $pKey => $pLabel)
                                <option value="{{ $pKey }}" {{ old('page_key', $banner->page_key) === $pKey ? 'selected' : '' }}>
                                    {{ $pLabel }} (slug: {{ $pKey }})
                                </option>
                            @endforeach
                        </select>
                        <span class="text-[10px] text-gray-400 mt-1 block">Assigned page slug: <code class="text-brandOrange font-mono font-bold">{{ $banner->page_key }}</code></span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- 2. Desktop Banner (Preview + Replacement) -->
                        <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-200 space-y-3">
                            <label class="block text-xs font-black uppercase text-gray-700 tracking-wider">
                                Desktop Banner Image
                            </label>

                            <!-- Current Image Preview -->
                            @if(!empty($banner->desktop_banner))
                                <div>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase block mb-1">Current File:</span>
                                    <div class="relative rounded-lg overflow-hidden border border-gray-200 bg-gray-900 aspect-[16/7]">
                                        <img src="{{ asset('storage/' . $banner->desktop_banner) }}" class="w-full h-full object-cover" alt="Current Desktop Banner">
                                    </div>
                                </div>
                            @endif

                            <div>
                                <label class="block text-[10px] font-bold uppercase text-gray-600 mb-1">
                                    Replace Desktop Image <span class="text-gray-400 font-normal text-[9px] lowercase">(leave blank to keep current)</span>
                                </label>
                                <input type="file" name="desktop_banner" accept="image/jpeg,image/png,image/webp" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-xs text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-brandOrange">
                            </div>
                        </div>

                        <!-- 3. Mobile Banner (Preview + Replacement) -->
                        <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-200 space-y-3">
                            <label class="block text-xs font-black uppercase text-gray-700 tracking-wider">
                                Mobile Banner Image <span class="text-gray-400 font-normal text-[10px] normal-case">(Optional)</span>
                            </label>

                            <!-- Current Image Preview -->
                            @if(!empty($banner->mobile_banner))
                                <div>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase block mb-1">Current Mobile File:</span>
                                    <div class="relative rounded-lg overflow-hidden border border-gray-200 bg-gray-900 aspect-[16/7]">
                                        <img src="{{ asset('storage/' . $banner->mobile_banner) }}" class="w-full h-full object-cover" alt="Current Mobile Banner">
                                    </div>
                                </div>
                            @else
                                <div class="p-3 bg-gray-100 rounded-lg border border-dashed border-gray-300 text-center">
                                    <span class="text-[10px] text-gray-500 font-semibold block">No distinct mobile image uploaded.</span>
                                    <span class="text-[9px] text-gray-400 block mt-0.5">Website automatically falls back to Desktop Banner.</span>
                                </div>
                            @endif

                            <div>
                                <label class="block text-[10px] font-bold uppercase text-gray-600 mb-1">
                                    Upload / Replace Mobile Image
                                </label>
                                <input type="file" name="mobile_banner" accept="image/jpeg,image/png,image/webp" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-xs text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-brandOrange">
                            </div>
                        </div>
                    </div>

                    <!-- 4. Status Selector -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black uppercase text-gray-700 mb-1.5 tracking-wider">
                                Status *
                            </label>
                            <select name="status" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-brandOrange bg-white">
                                <option value="show" {{ old('status', $banner->status) === 'show' || old('status', $banner->status) === 'Show' || old('status', $banner->status) === 'active' ? 'selected' : '' }}>
                                    Show (Active &amp; Visible to Devotees)
                                </option>
                                <option value="hide" {{ old('status', $banner->status) === 'hide' || old('status', $banner->status) === 'Hide' ? 'selected' : '' }}>
                                    Hide (Inactive / Hidden from Website)
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase text-gray-700 mb-1.5 tracking-wider">
                                Display Sort Order <span class="text-gray-400 font-normal text-[10px] normal-case">(Optional)</span>
                            </label>
                            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $banner->sort_order) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-mono font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-brandOrange">
                        </div>
                    </div>

                    <!-- 5. Optional Text Overlay Info -->
                    <div class="space-y-4 pt-2 border-t border-gray-100">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Optional Banner Header Text Overlay</div>
                        
                        <div>
                            <label class="block text-xs font-black uppercase text-gray-700 mb-1 tracking-wider">
                                Banner Heading Title <span class="text-gray-400 font-normal text-[10px] normal-case">(Optional)</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-brandOrange" placeholder="e.g. Service Media Gallery">
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase text-gray-700 mb-1 tracking-wider">
                                Banner Subtitle / Tagline <span class="text-gray-400 font-normal text-[10px] normal-case">(Optional)</span>
                            </label>
                            <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-brandOrange" placeholder="e.g. Live glimpses of our social and religious service activities across India">
                        </div>
                    </div>

                    <!-- Submit & Cancel Buttons -->
                    <div class="pt-4 flex items-center gap-3 border-t border-gray-100">
                        <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-xs px-6 py-2.5 rounded-lg shadow-sm uppercase tracking-wider transition">
                            Save Changes
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
