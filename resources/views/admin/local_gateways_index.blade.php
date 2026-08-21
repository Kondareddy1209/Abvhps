<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local GP Gateways Master Desk | ABVHPS Central Board</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-brandOrange: #FF6600;
            --color-brandGray: #4A4A4A;
            --color-brandDarkGray: #1A1A1A;
            --color-brandLightOrange: #FFF5EE;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 flex h-screen overflow-hidden">

    <!-- BLOCK 1: MASTER UNIFIED CENTRAL ADMIN SIDEBAR -->
    @include('admin.partials.sidebar')

    <!-- BLOCK 2: WORKSPACE -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2 min-w-0 max-w-full">
                @include('admin.partials.header_button')
                <span class="text-xs sm:text-sm font-black text-brandGray uppercase tracking-wider shrink-0">Module:</span>
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm break-words whitespace-normal leading-tight">Local GP Gateways Roster</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now()->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            @if(session('success'))
                <div class="p-3 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-bold flex items-center justify-between">
                    <span>✓ {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 font-black">×</button>
                </div>
            @endif

            <!-- KPI Summary Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Total GP Groups</span>
                    <span class="text-2xl font-black font-mono text-gray-800 mt-1 block">{{ $stats['total_groups'] }}</span>
                </div>
                <div class="bg-white border border-amber-200 rounded-xl p-4 shadow-sm bg-amber-50/30">
                    <span class="text-[10px] font-black text-amber-700 uppercase tracking-wider block">Pending Volunteer Approval</span>
                    <span class="text-2xl font-black font-mono text-amber-800 mt-1 block">{{ $stats['pending_groups'] }}</span>
                </div>
                <div class="bg-white border border-emerald-200 rounded-xl p-4 shadow-sm bg-emerald-50/30">
                    <span class="text-[10px] font-black text-emerald-700 uppercase tracking-wider block">Active / Approved Groups</span>
                    <span class="text-2xl font-black font-mono text-emerald-800 mt-1 block">{{ $stats['approved_groups'] }}</span>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block">Kala / Seva / Farmers</span>
                    <span class="text-xs font-black font-mono text-brandOrange mt-2 block">
                        {{ $stats['total_kala_brundam'] }} / {{ $stats['total_grama_seva_dal'] }} / {{ $stats['total_organic_farmers'] }}
                    </span>
                </div>
            </div>

            <!-- Filters Bar -->
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex flex-wrap items-center justify-between gap-3">
                <form method="GET" action="{{ route('admin.local_gateways.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <div class="flex items-center gap-2">
                        <label class="text-[10px] font-black uppercase text-gray-500">Category:</label>
                        <select name="category" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-3 py-1.5 text-xs font-bold text-gray-700 focus:ring-2 focus:ring-brandOrange outline-none">
                            <option value="all" {{ $category === 'all' ? 'selected' : '' }}>All Wings</option>
                            <option value="kala_brundam" {{ $category === 'kala_brundam' ? 'selected' : '' }}>🪘 Kala Brundam</option>
                            <option value="grama_seva_dal" {{ $category === 'grama_seva_dal' ? 'selected' : '' }}>🌱 Grama Seva Dal</option>
                            <option value="organic_farmers" {{ $category === 'organic_farmers' ? 'selected' : '' }}>🌾 Organic Farmers</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="text-[10px] font-black uppercase text-gray-500">Status:</label>
                        <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-3 py-1.5 text-xs font-bold text-gray-700 focus:ring-2 focus:ring-brandOrange outline-none">
                            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>⏳ Pending Approval</option>
                            <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>✓ Approved / Active</option>
                        </select>
                    </div>
                </form>

                <div class="text-xs font-black text-gray-500 uppercase tracking-wider">
                    Showing {{ $allGroups->count() }} Registered Groups
                </div>
            </div>

            <!-- Groups Table -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 font-black uppercase text-[10px] tracking-wider">
                                <th class="p-3.5">Reg ID</th>
                                <th class="p-3.5">Wing Category</th>
                                <th class="p-3.5">Group / Leader Name</th>
                                <th class="p-3.5">Location / GP</th>
                                <th class="p-3.5 text-center">Members</th>
                                <th class="p-3.5 text-center">Status</th>
                                <th class="p-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 font-medium">
                            @forelse($allGroups as $group)
                                <tr class="hover:bg-orange-50/40 transition">
                                    <td class="p-3.5 font-mono font-bold text-brandOrange">
                                        {{ $group->reg_id ?? 'GRP-'.$group->id }}
                                    </td>
                                    <td class="p-3.5">
                                        @if($group->wing_key === 'kala_brundam')
                                            <span class="bg-purple-50 text-purple-700 border border-purple-200 font-black text-[9px] px-2.5 py-1 rounded uppercase">🪘 Kala Brundam</span>
                                        @elseif($group->wing_key === 'grama_seva_dal')
                                            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 font-black text-[9px] px-2.5 py-1 rounded uppercase">🌱 Grama Seva Dal</span>
                                        @else
                                            <span class="bg-amber-50 text-amber-700 border border-amber-200 font-black text-[9px] px-2.5 py-1 rounded uppercase">🌾 Organic Farmers</span>
                                        @endif
                                    </td>
                                    <td class="p-3.5">
                                        <div class="font-bold text-gray-900 uppercase">{{ $group->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono">{{ $group->sub_type }}</div>
                                    </td>
                                    <td class="p-3.5 text-gray-700 font-bold">
                                        📍 {{ $group->gp_location }}
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <span class="bg-gray-100 text-gray-800 font-mono font-bold text-[10px] px-2 py-0.5 rounded border border-gray-200">
                                            {{ $group->members_count }} Members
                                        </span>
                                    </td>
                                    <td class="p-3.5 text-center">
                                        @if($group->status === 'approved')
                                            <span class="bg-emerald-100 text-emerald-800 text-[9px] font-black px-2.5 py-1 rounded border border-emerald-200 uppercase">
                                                ✓ APPROVED
                                            </span>
                                        @else
                                            <span class="bg-amber-100 text-amber-800 text-[9px] font-black px-2.5 py-1 rounded border border-amber-200 uppercase">
                                                ⏳ PENDING APPROVAL
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-right space-x-1.5 whitespace-nowrap">
                                        <a href="{{ route('admin.local_gateways.view', ['wing' => $group->wing_key, 'id' => $group->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-[9px] font-black px-2.5 py-1.5 rounded uppercase shadow-sm transition">
                                            View Roster
                                        </a>

                                        @if($group->status !== 'approved')
                                            <form action="{{ route('admin.local_gateways.approve', ['wing' => $group->wing_key, 'id' => $group->id]) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Approve this GP group?');" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[9px] font-black px-2.5 py-1.5 rounded uppercase shadow-sm transition">
                                                    Approve Group
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.local_gateways.delete', ['wing' => $group->wing_key, 'id' => $group->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this group?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-[9px] font-black px-2 py-1.5 rounded uppercase shadow-sm transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-400 font-bold">
                                        No Local GP Groups found under selected criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Floating WhatsApp Quick Connect Button -->
    <x-whatsapp-floating-button />

</body>
</html>
