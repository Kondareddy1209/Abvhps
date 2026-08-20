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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Volunteer Approval</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- Breadcrumb Navigation Bar -->
            <div class="flex items-center gap-2 text-xs font-bold text-gray-500 border-b border-gray-200 pb-3">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-brandOrange transition">Home</a>
                <span>-</span>
                <a href="{{ route('admin.volunteers.index') }}" class="bg-brandOrange text-white text-[11px] font-black px-3 py-1 rounded shadow-sm uppercase tracking-wide">
                    Volunteer
                </a>
            </div>

            <!-- Page Title & Header -->
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-black text-brandGray tracking-tight">Volunteer Approval Details</h2>
                <a href="{{ route('admin.volunteers.index') }}" class="bg-gray-800 hover:bg-gray-900 text-white font-black text-[10px] px-4 py-2 rounded-lg shadow-sm uppercase tracking-wide transition">
                    ← Back to List
                </a>
            </div>

            <!-- Error Alerts Block -->
            @if(isset($errors) && $errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs font-semibold shadow-sm">
                    <div class="font-black mb-1">Please correct the following errors:</div>
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Input Form Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 max-w-3xl">
                <form action="{{ route('admin.volunteers.update', $volunteer->id) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- 1. Name of Volunteer -->
                    <div>
                        <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Name of Volunteer</label>
                        <input type="text" name="name" readonly class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-black text-gray-800 uppercase focus:outline-none cursor-not-allowed" value="{{ $volunteer->member_full_name ?? 'Volunteer' }}">
                        <p class="text-[10px] text-gray-400 font-semibold mt-1">Linked from Membership ID: {{ implode(' ', str_split($volunteer->membership_id, 4)) }}</p>
                    </div>

                    <!-- 2. Status -->
                    <div>
                        <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Status *</label>
                        <select name="status" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-bold text-gray-800 focus:outline-none focus:border-brandOrange">
                            <option value="Verified" {{ old('status', $volunteer->status) === 'approved' ? 'selected' : '' }}>Verified</option>
                            <option value="Rejected" {{ old('status', $volunteer->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="Pending" {{ old('status', $volunteer->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <!-- 3. Volunteer Cadder -->
                    <div>
                        <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Volunteer Cadder *</label>
                        <input type="text" name="cadre" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-semibold text-gray-900 focus:outline-none focus:border-brandOrange" placeholder="e.g. National Co-Ordinator, Youth Wing, Core Dal" value="{{ old('cadre', $volunteer->cadre) }}">
                    </div>

                    <!-- 4. Volunteer Locality -->
                    <div>
                        <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-2">Volunteer Locality *</label>
                        <input type="text" name="locality" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-xs font-semibold text-gray-900 focus:outline-none focus:border-brandOrange" placeholder="e.g. Porumamilla, Kadapa, Badvel" value="{{ old('locality', $volunteer->locality ?: ($volunteer->member_mandal ?: ($volunteer->member_district ?: 'HQ'))) }}">
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-4 border-t border-gray-200 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.volunteers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-black text-xs px-6 py-2.5 rounded-lg uppercase tracking-wider transition">
                            Cancel
                        </a>
                        <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-xs px-8 py-2.5 rounded-lg shadow-sm uppercase tracking-wider transition flex items-center gap-1.5">
                            <span>💾</span> Save Changes
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</div>
@endsection
