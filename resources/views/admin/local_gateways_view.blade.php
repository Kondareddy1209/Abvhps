<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Roster Details | ABVHPS Central Board</title>
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
<body class="bg-gray-100 font-sans text-gray-800 p-6">

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Action Header -->
        <div class="flex items-center justify-between bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
            <div>
                <a href="{{ route('admin.local_gateways.index') }}" class="text-xs font-black text-brandOrange hover:underline">
                    ← Back to Local GP Gateways
                </a>
                <h1 class="text-lg font-black text-gray-900 uppercase mt-1">
                    {{ $group->wing_title }} - Group Roster
                </h1>
            </div>
            <div class="flex items-center gap-2">
                @if($group->status !== 'approved')
                    <form action="{{ route('admin.local_gateways.approve', ['wing' => $wing, 'id' => $group->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs px-4 py-2 rounded-lg shadow-sm uppercase transition">
                            ✓ Approve Group
                        </button>
                    </form>
                @else
                    <span class="bg-emerald-100 text-emerald-800 text-xs font-black px-3 py-1.5 rounded border border-emerald-200 uppercase">
                        ✓ Active & Approved
                    </span>
                @endif
            </div>
        </div>

        <!-- Group Info Card & QR Code -->
        @php
            $regId = $group->team_registration_id ?? ($group->gong_registration_id ?? ($group->farmer_registration_id ?? 'GRP-'.$group->id));
            if ($wing === 'organic_farmers') {
                $verifyUrl = url('/verify/organic-farmers/' . $regId);
            } elseif ($wing === 'kala_brundam') {
                $verifyUrl = url('/verify/kala-brundham/' . $regId);
            } else {
                $verifyUrl = url('/verify/grama-seva-dal/' . $regId);
            }
        @endphp
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 text-xs">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 flex-1">
                <div>
                    <span class="text-gray-400 font-bold uppercase block text-[10px]">Group ID</span>
                    <span class="font-mono font-bold text-brandOrange text-sm">{{ $regId }}</span>
                </div>
                <div>
                    <span class="text-gray-400 font-bold uppercase block text-[10px]">Leader / Team Name</span>
                    <span class="font-bold text-gray-900 uppercase">{{ $group->team_name ?? ($group->leader_name ?? ($group->farmer_name ?? 'N/A')) }}</span>
                </div>
                <div>
                    <span class="text-gray-400 font-bold uppercase block text-[10px]">Location</span>
                    <span class="font-bold text-gray-800">{{ $group->location ?? ($group->village_or_gp ?? ($group->village ?? 'N/A')) }}</span>
                </div>
                <div>
                    <span class="text-gray-400 font-bold uppercase block text-[10px]">Total Group Strength</span>
                    <span class="font-mono font-black text-emerald-700 text-sm">{{ $members->count() > 0 ? $members->count() : 1 }} Registered Members</span>
                </div>
            </div>

            <!-- Dynamic Group Verification QR Code -->
            <div class="flex flex-col items-center p-3 bg-gray-50 border border-gray-200 rounded-xl shrink-0">
                <div class="bg-white p-1.5 border border-gray-300 rounded shadow-xs">
                    {!! QrCode::size(70)->margin(0)->generate($verifyUrl) !!}
                </div>
                <span class="text-[9px] font-bold text-gray-500 uppercase tracking-wider mt-1">Official Group QR</span>
            </div>
        </div>

        <!-- Members Roster Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <h3 class="font-black text-xs text-gray-700 uppercase tracking-wider">
                    Community Members Roster (10–20 Volunteers Matrix)
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-400 font-black uppercase text-[10px]">
                            <th class="p-3">#</th>
                            <th class="p-3">Member Name</th>
                            <th class="p-3">Contact</th>
                            <th class="p-3">Role / Seva Responsibility</th>
                            <th class="p-3">Aadhaar / ID</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($members as $index => $m)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 font-mono font-bold text-gray-400">{{ $index + 1 }}</td>
                                <td class="p-3 font-bold text-gray-900 uppercase">{{ $m->full_name ?? ($m->member_name ?? ($m->farmer_name ?? 'Member')) }}</td>
                                <td class="p-3 font-mono text-gray-700">{{ $m->mobile ?? ($m->phone ?? 'N/A') }}</td>
                                <td class="p-3 text-brandOrange font-bold">{{ $m->role_or_instrument ?? ($m->crop_name ?? ($m->membership_id ?? 'Team Member')) }}</td>
                                <td class="p-3 font-mono text-gray-500">{{ $m->membership_id ?? ($m->aadhaar_number ?? 'Verified') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-400">
                                    No individual member items recorded in this group roster.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
