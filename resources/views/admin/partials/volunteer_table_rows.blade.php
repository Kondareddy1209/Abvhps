@forelse($volunteers as $index => $volunteer)
    <tr class="hover:bg-gray-50/70 transition-colors">
        
        <!-- 1. S.NO -->
        <td class="px-4 py-4 text-gray-500 font-mono">
            {{ $loop->iteration + ($volunteers->currentPage() - 1) * $volunteers->perPage() }}
        </td>

        <!-- 2. NAME -->
        <td class="px-6 py-4 text-left">
            <div class="font-black text-gray-900 uppercase text-xs flex items-center gap-1.5 flex-wrap">
                <span>{{ $volunteer->member_full_name ?? 'Volunteer' }}</span>
                @if($volunteer->status === 'pending')
                    <span class="bg-amber-100 text-amber-800 text-[8px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider border border-amber-200 animate-pulse">Pending</span>
                @elseif($volunteer->status === 'approved')
                    <span class="bg-emerald-100 text-emerald-800 text-[8px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider border border-emerald-200">Approved</span>
                    <span class="bg-blue-100 text-blue-800 text-[8px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider border border-blue-200">Login Active</span>
                @elseif($volunteer->status === 'rejected')
                    <span class="bg-rose-100 text-rose-800 text-[8px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider border border-rose-200">Rejected</span>
                @endif
            </div>
            <div class="text-[10px] text-gray-400 font-mono mt-0.5 space-x-1">
                @if($volunteer->volunteer_id || $volunteer->volunteer_login_id)
                    <span class="text-orange-600 font-bold bg-orange-50 px-1 py-0.5 rounded border border-orange-100">VOLUNTEER ID: {{ $volunteer->volunteer_id ?? $volunteer->volunteer_login_id }}</span> | 
                @else
                    <span class="text-gray-400 font-semibold italic">VOLUNTEER ID: Not Assigned</span> | 
                @endif
                <span>MEMBER: {{ implode(' ', str_split($volunteer->membership_id, 4)) }}</span>
            </div>
        </td>

        <!-- 3. CONTACT -->
        <td class="px-6 py-4 text-left">
            <div class="font-mono text-gray-900 font-bold text-xs">
                {{ $volunteer->phone }}
            </div>
            <div class="text-[10px] text-gray-500 font-mono">
                {{ $volunteer->email }}
            </div>
        </td>

        <!-- 4. VIEW -->
        <td class="px-2 py-4">
            <a href="{{ route('admin.volunteers.view', $volunteer->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-black text-[9px] px-3 py-1.5 rounded shadow-sm uppercase transition inline-block text-center">
                View
            </a>
        </td>

        <!-- 5. EDIT -->
        <td class="px-2 py-4">
            <a href="{{ route('admin.volunteers.edit', $volunteer->id) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-black text-[9px] px-3 py-1.5 rounded shadow-sm uppercase transition inline-block text-center">
                Edit
            </a>
        </td>

        <!-- 6. CADDER -->
        <td class="px-2 py-4">
            <a href="{{ route('admin.volunteers.cadreEdit', $volunteer->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-black text-[9px] px-3 py-1.5 rounded shadow-sm uppercase transition inline-block text-center">
                Update
            </a>
        </td>

        <!-- 7. ID -->
        <td class="px-2 py-4">
            @if($volunteer->status === 'approved' && !empty($volunteer->volunteer_id))
                <a href="{{ route('admin.volunteer.view_card', $volunteer->volunteer_id) }}" target="_blank" class="bg-yellow-500 hover:bg-yellow-600 text-white font-black text-[9px] px-3 py-1.5 rounded shadow-sm uppercase transition inline-block text-center">
                    Id
                </a>
            @else
                <button disabled class="bg-gray-300 text-gray-500 font-black text-[9px] px-3 py-1.5 rounded uppercase cursor-not-allowed inline-block text-center" title="ID Card generated after approval">
                    Id
                </button>
            @endif
        </td>

        <!-- 8. DELETE -->
        <td class="px-2 py-4">
            <form action="{{ route('admin.volunteers.delete', $volunteer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this volunteer record permanently?');" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-black text-[9px] px-3 py-1.5 rounded shadow-sm uppercase transition">
                    Delete
                </button>
            </form>
        </td>

    </tr>
@empty
    <tr>
        <td colspan="8" class="px-6 py-12 text-center font-bold text-gray-400 uppercase tracking-wider">
            <span class="text-2xl block mb-1">🤝</span>
            No volunteer records found in the roster.
        </td>
    </tr>
@endforelse
