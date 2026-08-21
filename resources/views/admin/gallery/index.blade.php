@extends('layouts.app')

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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Media Hub</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- Header Title Node -->
            <div class="flex justify-between items-center">
                <h3 class="text-xs font-black text-brandGray uppercase tracking-wider flex items-center gap-1.5">
                    🖼️ Service Work Event Photos & Videos Hub
                </h3>
            </div>

            <!-- Success Alert Block -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Upload New Media Asset Form Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h4 class="text-[11px] font-black uppercase text-brandOrange mb-4 tracking-wider">Upload New Photo or Video</h4>
                
                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <!-- Choice 1: Choose Media Type -->
                        <div>
                            <label class="block text-[11px] font-black uppercase text-gray-500 mb-1.5 tracking-wider">Choose Media Type *</label>
                            <select name="media_type" id="media_type_select" required class="w-full border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange bg-white" onchange="toggleMediaInputs()">
                                <option value="image">Event Photo (File Upload)</option>
                                <option value="video">Streaming Video (URL Link)</option>
                            </select>
                        </div>

                        <!-- Choice 2: Image File Input (Shows by default) -->
                        <div id="image_upload_block">
                            <label class="block text-[11px] font-black uppercase text-gray-500 mb-1.5 tracking-wider">Select Photo * (JPG, PNG - Max 2MB)</label>
                            <input type="file" name="image" class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-xs font-semibold focus:outline-none focus:border-brandOrange bg-gray-50">
                        </div>

                        <!-- Choice 3: Video URL Input (Hidden by default) -->
                        <div id="video_url_block" class="hidden">
                            <label class="block text-[11px] font-black uppercase text-gray-500 mb-1.5 tracking-wider">Paste Video URL * (YouTube Link etc.)</label>
                            <input type="url" name="video_url" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange" placeholder="https://example.com">
                        </div>

                        <!-- Submit Action button -->
                        <div>
                            <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[11px] w-full py-2.5 rounded-lg shadow-sm uppercase tracking-wide transition">
                                Upload Asset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Master Matrix Photo Thumbnail Layout Grid -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h4 class="text-[11px] font-black uppercase text-brandGray mb-4 tracking-wider">Live Media Roster Grid</h4>
                
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @forelse($galleryItems as $item)
                        <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden shadow-sm flex flex-col group relative">
                            <!-- Display Area based on media type -->
                            <div class="aspect-[4/5] bg-gray-900 flex items-center justify-center relative overflow-hidden">
                                @if($item->media_type === 'image')
                                    <img src="{{ asset('storage/' . $item->image_path) }}" class="w-full h-full object-cover transition transform group-hover:scale-105" alt="Service Photo">
                                    <span class="absolute top-1.5 left-1.5 bg-green-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded shadow">PHOTO</span>
                                @else
                                    <div class="text-center p-3">
                                        <span class="text-3xl block drop-shadow">📺</span>
                                        <a href="{{ $item->video_url }}" target="_blank" class="text-[9px] font-bold text-blue-400 hover:underline block mt-1 break-all px-1 font-mono">Open Link</a>
                                    </div>
                                    <span class="absolute top-1.5 left-1.5 bg-indigo-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded shadow">VIDEO</span>
                                @endif
                            </div>

                            <!-- Delete Action Panel Frame -->
                            <div class="p-2 bg-white border-t border-gray-100 mt-auto text-center">
                                <form action="{{ route('admin.gallery.delete', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this media item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-black text-[9px] w-full py-1 rounded shadow-sm uppercase tracking-wider transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-10 text-center font-bold text-gray-400 uppercase tracking-wider">
                            No service event media assets found inside the gallery matrix.
                        </div>
                    @endforelse
                </div>
            </div>

        </main> <!-- END WORKSPACE CONTAINER -->
    </div> <!-- END MAIN WORKSPACE VIEWPORT DESK -->
</div> <!-- END MIN-H-SCREEN CONTAINER -->

<!-- JAVASCRIPT LIVE INPUT TOGGLE LOGIC -->
<script>
    function toggleMediaInputs() {
        var selectBox = document.getElementById('media_type_select');
        var imageBlock = document.getElementById('image_upload_block');
        var videoBlock = document.getElementById('video_url_block');
        
        if (selectBox.value === 'image') {
            imageBlock.classList.remove('hidden');
            videoBlock.classList.add('hidden');
        } else {
            imageBlock.classList.add('hidden');
            videoBlock.classList.remove('hidden');
        }
    }
</script>
@endsection
