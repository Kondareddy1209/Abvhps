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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Support Cores</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- Header Title and Add Button Node -->
            <div class="flex justify-between items-center">
                <h3 class="text-xs font-black text-brandGray uppercase tracking-wider flex items-center gap-1.5">
                    🌱 Our 6 Core Service Projects Management
                </h3>
                <a href="{{ route('admin.support.create') }}" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[10px] px-4 py-2 rounded-lg shadow-sm uppercase tracking-wide transition">
                    + Add New Project
                </a>
            </div>

            <!-- Success Alert Block -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Filter Bar -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <form action="{{ route('admin.support.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange" placeholder="Search projects by name or description..." value="{{ $searchToken ?? '' }}">
                    <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[11px] px-5 py-2 rounded-lg shadow-sm uppercase tracking-wide transition">
                        Search Project
                    </button>
                </form>
            </div>
            <!-- Central Projects Ledger Table Grid -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-xs font-semibold text-gray-700">
                        <thead class="bg-gray-100 text-[10px] font-black uppercase text-gray-600 tracking-wider text-center">
                            <tr>
                                <th class="px-4 py-3">S.No</th>
                                <th class="px-6 py-3 text-left">Project Name</th>
                                <th class="px-6 py-3">Project Image</th>
                                <th class="px-6 py-3">Short Info / Description</th>
                                <th class="px-6 py-3">Sort Order</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-4 py-3">Edit</th>
                                <th class="px-4 py-3">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white text-center">
                            @forelse($supports as $index => $support)
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="px-4 py-3.5 text-gray-500 font-mono">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-3.5 text-left font-bold text-gray-900 uppercase tracking-wide">
                                        {{ $support->name }}
                                    </td>
                                    <td class="px-6 py-3.5">
                                        @if($support->image_path)
                                            <img src="{{ asset('storage/' . $support->image_path) }}" class="w-12 h-12 rounded-lg border object-cover mx-auto shadow-sm" alt="Project Image">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 border flex items-center justify-center text-gray-400 text-[9px] mx-auto">No Image</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-left font-medium text-gray-500 max-w-xs truncate normal-case">
                                        {{ $support->short_info }}
                                    </td>
                                    <td class="px-6 py-3.5 font-mono text-brandOrange font-black text-sm">
                                        {{ $support->sort_order }}
                                    </td>
                                    <td class="px-6 py-3.5">
                                        @if($support->status == 'show')
                                            <span class="bg-green-50 text-green-600 text-[9px] font-black px-2.5 py-0.5 rounded border border-green-100 uppercase tracking-wider">
                                                Show / Active
                                            </span>
                                        @else
                                            <span class="bg-gray-50 text-gray-500 text-[9px] font-black px-2.5 py-0.5 rounded border border-gray-200 uppercase tracking-wider">
                                                Hide / Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-3.5">
                                        <a href="{{ route('admin.support.edit', $support->id) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-black text-[9px] px-3 py-1 rounded shadow-sm uppercase transition inline-block">
                                            Edit
                                        </a>
                                    </td>
                                    <td class="px-2 py-3.5">
                                        <form action="{{ route('admin.support.delete', $support->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this service project?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-black text-[9px] px-3 py-1 rounded shadow-sm uppercase transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center font-bold text-gray-400 uppercase tracking-wider">
                                        No core service projects found inside the database repository.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main> <!-- END WORKSPACE CONTAINER -->
    </div> <!-- END MAIN WORKSPACE VIEWPORT DESK -->
</div> <!-- END MIN-H-SCREEN CONTAINER -->
@endsection
