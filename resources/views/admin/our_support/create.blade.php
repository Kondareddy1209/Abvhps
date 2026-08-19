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
            <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition border-b border-gray-800/40">
                <span>🖼️</span> 4. MEDIA GALLERY
            </a>
            <a href="{{ route('admin.support.index') }}" class="flex items-center gap-2 px-3 py-2 bg-brandOrange text-white rounded-lg shadow-sm transition">
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
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-gray-800 hover:text-white rounded-lg transition">
                <span>⚙️</span> 15. SITE GLOBAL SETTINGS
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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Add Project</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- Header Title and Back Link -->
            <div class="flex justify-between items-center">
                <h3 class="text-xs font-black text-brandGray uppercase tracking-wider flex items-center gap-1.5">
                    🌱 Add New Service Project Form
                </h3>
                <a href="{{ route('admin.support.index') }}" class="bg-gray-800 hover:bg-gray-900 text-white font-black text-[10px] px-4 py-2 rounded-lg shadow-sm uppercase tracking-wide transition">
                    ← Back To List
                </a>
            </div>

            <!-- Error Alerts Block -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs font-semibold">
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Input Form Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <form action="{{ route('admin.our_support.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Input 1: Project Name -->
                        <div>
                            <label class="block text-[11px] font-black uppercase text-gray-500 mb-1.5 tracking-wider">Project Name * (e.g. ANNAPURNA, GOSAMRAKSHANA)</label>
                            <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange" placeholder="Enter service project name" value="{{ old('name') }}">
                        </div>

                        <!-- Input 2: Sort Order -->
                        <div>
                            <label class="block text-[11px] font-black uppercase text-gray-500 mb-1.5 tracking-wider">Display Sort Order * (1, 2, 3...)</label>
                            <input type="number" name="sort_order" required min="1" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange" placeholder="Example: 1 for top priority" value="{{ old('sort_order', 1) }}">
                        </div>

                        <!-- Input 3: Status Dropdown -->
                        <div>
                            <label class="block text-[11px] font-black uppercase text-gray-500 mb-1.5 tracking-wider">Website Visibility Status *</label>
                            <select name="status" required class="w-full border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange bg-white">
                                <option value="show" {{ old('status') == 'show' ? 'selected' : '' }}>Show on Home Page</option>
                                <option value="hide" {{ old('status') == 'hide' ? 'selected' : '' }}>Hide / Keep Draft</option>
                            </select>
                        </div>

                        <!-- Input 4: Project Image File -->
                        <div>
                            <label class="block text-[11px] font-black uppercase text-gray-500 mb-1.5 tracking-wider">Project Photo / Banner * (JPG, PNG - Max 2MB)</label>
                            <input type="file" name="image" required class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-xs font-semibold focus:outline-none focus:border-brandOrange bg-gray-50">
                        </div>
                    </div>

                    <!-- Input 5: Short Description Info -->
                    <div>
                        <label class="block text-[11px] font-black uppercase text-gray-500 mb-1.5 tracking-wider">Short Project Description Info *</label>
                        <textarea name="short_info" required rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-xs font-semibold focus:outline-none focus:border-brandOrange" placeholder="Write a short summary about the purpose and goals of this project for the home page...">{{ old('short_info') }}</textarea>
                    </div>

                    <!-- Submit Buttons Action Desk -->
                    <div class="pt-4 border-t border-gray-200 flex gap-2 justify-end">
                        <a href="{{ route('admin.support.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-black text-[11px] px-5 py-2.5 rounded-lg uppercase tracking-wide transition border border-gray-300">
                            Cancel
                        </a>
                        <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[11px] px-6 py-2.5 rounded-lg shadow-sm uppercase tracking-wide transition">
                            Save Project
                        </button>
                    </div>
                </form>
            </div>

        </main> <!-- END WORKSPACE CONTAINER -->
    </div> <!-- END MAIN WORKSPACE VIEWPORT DESK -->
</div> <!-- END MIN-H-SCREEN CONTAINER -->
@endsection
