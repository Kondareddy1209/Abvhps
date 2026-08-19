@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100/60 flex flex-col md:flex-row select-none">
    
    <!-- BLOCK 1: MASTER ADMINISTRATIVE LEFT SIDEBAR CONTROLLER -->
    <div class="w-full md:w-64 bg-brandDarkGray text-white flex flex-col border-r-4 border-brandOrange shrink-0 shadow-xl">
        <div class="p-5 text-center bg-gray-900 border-b border-gray-800">
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-brandOrange shadow mx-auto mb-2 flex items-center justify-center bg-white p-0.5">
                <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS">
            </div>
            <h2 class="text-xs font-black tracking-widest text-brandOrange uppercase">ABVHPS CENTRAL BOARD</h2>
            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Master Control Panel Desk</p>
        </div>
        
        <!-- 15 Core Navigation Matrix Link Nodes -->
        <nav class="flex-1 p-3 space-y-1 overflow-y-auto text-[10px] font-black tracking-wider uppercase text-gray-300">
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📊</span> DASHBOARD HOME
            </a>

            <!-- WINGS SUBSYSTEMS -->
            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">WINGS SUBSYSTEMS</div>
            
            <a href="{{ route('admin.team.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>👥</span> 1. OUR TEAM
            </a>
            <a href="{{ route('admin.donations.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>💰</span> 2. DONATIONS LEDGER
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📰</span> 3. BLOGS MANAGER
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
                <span>🖼️</span> 4. MEDIA GALLERY
            </a>
            <a href="{{ route('admin.support.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🌱</span> 5. OUR SUPPORT CORES
            </a>

            <!-- MEMBERSHIP & CADRES -->
            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">MEMBERSHIP & CADRES</div>
            
            <a href="{{ route('admin.membership.ledger') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>💳</span> 6. APPROVED MEMBERSHIP
            </a>
            <a href="{{ route('admin.membership.pending') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>⏳</span> 7. PENDING MEMBERSHIP LIST
            </a>
            <a href="{{ route('admin.volunteers.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🤝</span> 8. VOLUNTEER DESK
            </a>
            <a href="{{ route('admin.rudrasena.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🔱</span> 9. RUDRASENA MATRIX
            </a>
            <a href="{{ route('admin.local_gateways.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🏡</span> 10. LOCAL GP GATEWAYS
            </a>

            <!-- EXAMS & CAMPAIGNS -->
            <div class="pt-2 pb-1 border-b border-gray-800/60 text-[8px] text-brandOrange font-black tracking-widest">SERVICES & CORES</div>
            
            <a href="{{ route('admin.exams.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📝</span> 11. EXAMS INFO BOARD
            </a>
            <a href="{{ route('admin.fundraising.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📢</span> 12. FUNDRAISING MATRICES
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📩</span> 13. CONTACT FORMS AUDIT
            </a>
            <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>📜</span> 14. TAX CERTIFICATES
            </a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>⚙️</span> 15. SITE GLOBAL SETTINGS
            </a>
            <a href="{{ route('admin.banner.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🚩</span> 16. BANNER MANAGEMENT
            </a>
            <a href="{{ \App\Models\SiteSetting::getWhatsAppUrl() }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-3 py-2 hover:bg-emerald-800/60 text-emerald-400 hover:text-white rounded-lg transition font-bold">
                <svg class="w-3.5 h-3.5 fill-current shrink-0 text-emerald-400" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.972.531 1.776.813 2.796.813 3.183 0 5.768-2.587 5.769-5.766.001-3.182-2.585-5.77-5.769-5.77zm3.377 8.239c-.144.405-.837.774-1.17.824-.312.045-.694.076-2.155-.529-1.803-.746-2.956-2.58-3.045-2.7-.091-.12-1.222-1.625-1.222-3.099 0-1.474.773-2.197 1.047-2.496.275-.299.598-.374.797-.374.199 0 .399.002.573.01.184.01.432-.07.674.512.25.599.852 2.079.927 2.23.075.15.125.326.025.525-.099.199-.15.324-.298.499-.15.175-.316.39-.45.524-.15.15-.306.314-.132.613.175.299.776 1.28 1.666 2.072 1.144 1.02 2.11 1.335 2.41 1.485.3.15.474.125.65-.075.174-.2.748-.873.948-1.173.199-.3.399-.25.674-.15.275.1 1.748.824 2.048.974.3.15.499.225.574.35.074.125.074.724-.07 1.129zM12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.436 5.178L2 22l4.958-1.3c1.47.839 3.167 1.3 4.978 1.3 5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.167c-1.637 0-3.17-.492-4.455-1.336l-.319-.208-2.946.772.786-2.871-.227-.361A8.125 8.125 0 013.833 12c0-4.503 3.664-8.167 8.167-8.167 4.503 0 8.167 3.664 8.167 8.167 0 4.503-3.664 8.167-8.167 8.167z"/></svg>
                <span>17. WHATSAPP ({{ substr(\App\Models\SiteSetting::getNormalizedWhatsAppNumber(), -10) }})</span>
            </a>
        </nav>
        
        <div class="p-3 bg-gray-900 border-t border-gray-800 text-center text-[8px] font-bold text-gray-500 tracking-wider">
            ABVHPS SECURITY CORE V2.0
        </div>
    </div>
    <!-- BLOCK 2: MASTER MAIN WORKSPACE VIEWPORT DESK -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Workspace Top Status Banner Navbar -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
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
                    🖼️ Section 4: Service Work Event Photos & Videos Hub
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
