@extends('layouts.app')

@section('content')
<section class="max-w-4xl mx-auto my-8 p-6 bg-white rounded-xl shadow border border-gray-100">
    
    <!-- 1. Admin Module Main Header Block Component -->
    <div class="border-b border-gray-100 pb-3 mb-6 flex justify-between items-center">
        <div>
            <span class="text-xs font-bold text-brandOrange uppercase tracking-wider block">Central Administrative Desk</span>
            <h2 class="text-xl font-black text-brandGray mt-0.5">Volunteer Approvals Control</h2>
        </div>
        <div class="w-10 h-10 rounded-full overflow-hidden bg-white border border-brandOrange flex items-center justify-center p-0.5 shrink-0 shadow-xs">
            <img src="{{ asset('images/ABVHPS_LOGO.jpg') }}" class="w-full h-full object-cover rounded-full" alt="ABVHPS Logo">
        </div>
    </div>

    <!-- Feedback Alerts Component Handling Server Status Logs -->
    @if(session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-3 text-xs text-green-700 rounded font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <!-- 2. Loop Container displaying Pending Volunteer Applications List -->
    @if(isset($pendingVolunteers) && count($pendingVolunteers) > 0)
        <div class="space-y-6">
            @foreach($pendingVolunteers as $volunteer)
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-200/80 space-y-4 shadow-sm">
                    
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-b border-gray-200 pb-3 text-xs text-brandGray">
                        <div><span class="text-gray-400 font-bold block uppercase mb-0.5">Membership ID</span> <strong class="tracking-wide text-sm text-brandOrange">{{ $volunteer->membership_id }}</strong></div>
                        <div><span class="text-gray-400 font-bold block uppercase mb-0.5">Mobile Number</span> <strong class="text-sm">+91 {{ $volunteer->phone }}</strong></div>
                        <div><span class="text-gray-400 font-bold block uppercase mb-0.5">Email (Mandatory Field)</span> <strong class="text-sm text-brandDarkGray">{{ $volunteer->email }}</strong></div>
                    </div>

                    <!-- Mapped Documents Files Links Preview Section -->
                    <div class="flex flex-wrap gap-4 text-xs font-bold">
                        <span class="text-gray-400 uppercase pt-1">Attached Files:</span>
                        <a href="{{ asset('storage/' . $volunteer->document_declaration_path) }}" target="_blank" class="bg-orange-100 text-brandOrange py-1 px-3 rounded hover:bg-orange-200 transition">1. Self Declaration &rarr;</a>
                        <a href="{{ asset('storage/' . $volunteer->document_voter_path) }}" target="_blank" class="bg-orange-100 text-brandOrange py-1 px-3 rounded hover:bg-orange-200 transition">2. Voter ID Copy &rarr;</a>
                        <a href="{{ asset('storage/' . $volunteer->document_bank_path) }}" target="_blank" class="bg-orange-100 text-brandOrange py-1 px-3 rounded hover:bg-orange-200 transition">3. Bank Passbook &rarr;</a>
                    </div>

                    <!-- 3. Dynamic Admin Processing Desk Entry Input Form Component -->
                    <form action="/admin/volunteer/approve" method="POST" class="bg-white p-4 rounded border border-orange-100/60 mt-2">
                        @csrf
                        <input type="hidden" name="id" value="{{ $volunteer->id }}">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                                                        <!-- Admin input row 1: Dynamic Strategic Hierarchy Role Dropdown Mapped Safely -->
                            <div>
                                <label class="block text-[11px] font-black text-brandGray uppercase mb-1">Assign Official Pipeline Role</label>
                                <select name="role" required
                                    class="block w-full px-3 py-1.5 border border-gray-300 rounded text-xs text-brandGray font-semibold focus:ring-brandOrange focus:border-brandOrange">
                                    <option value="village_president">Village President (Grama Panchayat Level)</option>
                                    <option value="mandal_president">Mandal President (10-15 Panchayats Level)</option>
                                    <option value="assembly_president">Assembly Segment President (100 Panchayats Level)</option>
                                    <option value="district_president">District President (Supervisory Analytical Counter)</option>
                                </select>
                            </div>
                            
                            <!-- Admin input row 2: Designation Metrics Configuration -->
                            <div class="mt-2 sm:mt-0">
                                <label class="block text-[11px] font-black text-brandGray uppercase mb-1">Assign Designation Text</label>
                                <input type="text" name="designation" required
                                    class="block w-full px-3 py-1.5 border border-gray-300 rounded text-xs text-brandGray font-semibold focus:ring-brandOrange focus:border-brandOrange"
                                    placeholder="E.g. Mandal President, Co-ordinator">
                            </div>


                            <!-- Admin Action Button Trigger Input Entry -->
                            <div>
                                <button type="submit"
                                    class="w-full py-1.5 px-4 border border-transparent text-xs font-black rounded text-white bg-brandOrange hover:bg-opacity-90 transition shadow-sm uppercase tracking-wider">
                                    Approve & Generate ID
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            @endforeach
        </div>
    @else
        <!-- Fallback Empty State Component -->
        <div class="p-8 bg-gray-50 rounded-lg border border-dashed border-gray-200 text-center text-xs text-gray-500 font-medium">
            No pending volunteer registration applications found waiting for verification clearance.
        </div>
    @endif

</section>
@endsection
