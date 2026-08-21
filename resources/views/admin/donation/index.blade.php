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
                <span class="bg-orange-100 text-brandOrange text-[9px] font-black px-2.5 py-0.5 rounded border border-orange-200 tracking-widest uppercase shadow-sm">Donation Ledger</span>
            </div>
            <div class="text-right text-[10px] font-mono font-black text-gray-500">
                System Sync: {{ \Carbon\Carbon::now('Asia/Kolkata')->format('d-M-Y H:i') }} IST
            </div>
        </header>

        <!-- Dynamic Content Workspace Container -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            
            <!-- Header Title Node -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <div>
                    <h3 class="text-xs sm:text-sm font-black text-brandDarkGray uppercase tracking-wider flex items-center gap-1.5">
                        💰 Devotee Donation Legal Financial Ledger
                    </h3>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">
                        Unified tracking for online Cashfree, Razorpay, and manual devotee contributions.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-emerald-50 text-emerald-800 border border-emerald-200 text-[10px] font-black px-3 py-1 rounded-lg">
                        Total Recorded: ₹{{ number_format($donations->where('payment_status', 'paid')->sum('amount'), 2) }}
                    </span>
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200">
                <form action="{{ route('admin.donations.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div class="sm:col-span-2">
                        <input type="text" name="search" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-xs font-semibold focus:outline-none focus:border-brandOrange min-h-[40px]" placeholder="Search by Donor Name, Phone, Email, PAN, or Reference..." value="{{ $searchToken ?? '' }}">
                    </div>
                    <div>
                        <select name="gateway" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-xs font-bold text-gray-700 focus:outline-none focus:border-brandOrange min-h-[40px]">
                            <option value="">All Payment Gateways</option>
                            <option value="cashfree" @if(($gatewayFilter ?? '') === 'cashfree') selected @endif>Cashfree Payments</option>
                            <option value="razorpay" @if(($gatewayFilter ?? '') === 'razorpay') selected @endif>Razorpay Payments</option>
                            <option value="manual" @if(($gatewayFilter ?? '') === 'manual') selected @endif>Manual / Cash</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <select name="status" class="flex-1 border border-gray-300 rounded-xl px-3 py-2 text-xs font-bold text-gray-700 focus:outline-none focus:border-brandOrange min-h-[40px]">
                            <option value="">All Statuses</option>
                            <option value="paid" @if(($statusFilter ?? '') === 'paid') selected @endif>Paid</option>
                            <option value="pending" @if(($statusFilter ?? '') === 'pending') selected @endif>Pending</option>
                            <option value="failed" @if(($statusFilter ?? '') === 'failed') selected @endif>Failed</option>
                        </select>
                        <button type="submit" class="bg-brandOrange hover:bg-orange-700 text-white font-black text-[11px] px-4 py-2 rounded-xl shadow-sm uppercase tracking-wide transition min-h-[40px]">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Central Donations Ledger Table Grid -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-xs font-semibold text-gray-700">
                        <thead class="bg-gray-100 text-[10px] font-black uppercase text-gray-600 tracking-wider">
                            <tr>
                                <th class="px-4 py-3 text-center">S.No</th>
                                <th class="px-5 py-3">Donor / Devotee</th>
                                <th class="px-4 py-3">Contact</th>
                                <th class="px-4 py-3">Gateway & Ref</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Cause / Seva</th>
                                <th class="px-5 py-3 text-right">Amount</th>
                                <th class="px-4 py-3 text-center">Date (IST)</th>
                                <th class="px-4 py-3 text-center">Receipt</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($donations as $donation)
                                @php
                                    $gw = strtolower($donation->payment_gateway ?? 'manual');
                                    $status = strtolower($donation->payment_status ?? 'paid');
                                @endphp
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="px-4 py-3.5 text-center text-gray-400 font-mono">
                                        {{ $loop->iteration }}
                                    </td>

                                    <!-- Donor Details -->
                                    <td class="px-5 py-3.5 font-bold text-gray-900 uppercase">
                                        <div class="text-xs">{{ $donation->name }}</div>
                                        @if($donation->guardian)
                                            <span class="block text-[10px] font-normal text-gray-400 normal-case">Guardian: {{ $donation->guardian }}</span>
                                        @endif
                                        @if($donation->pan_number)
                                            <span class="inline-block text-[9px] font-mono font-bold text-brandOrange bg-orange-50 px-1.5 py-0.2 rounded border border-orange-200 mt-0.5">PAN: {{ $donation->pan_number }}</span>
                                        @endif
                                    </td>

                                    <!-- Contact Info -->
                                    <td class="px-4 py-3.5 text-gray-600 font-mono text-[11px]">
                                        <div>{{ $donation->phone ?? $donation->contact }}</div>
                                        @if($donation->email)
                                            <div class="text-[10px] text-gray-400 font-sans truncate max-w-[140px]">{{ $donation->email }}</div>
                                        @endif
                                    </td>

                                    <!-- Gateway & Transaction Reference -->
                                    <td class="px-4 py-3.5">
                                        @if($gw === 'cashfree')
                                            <span class="inline-block bg-orange-100 text-orange-900 border border-orange-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">Cashfree</span>
                                        @elseif($gw === 'razorpay')
                                            <span class="inline-block bg-blue-100 text-blue-900 border border-blue-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">Razorpay</span>
                                        @else
                                            <span class="inline-block bg-gray-100 text-gray-800 border border-gray-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">Manual</span>
                                        @endif

                                        @if($donation->gateway_payment_id || $donation->gateway_order_id)
                                            <span class="block font-mono text-[9px] text-gray-400 mt-0.5 truncate max-w-[130px]" title="{{ $donation->gateway_payment_id ?? $donation->gateway_order_id }}">
                                                {{ $donation->gateway_payment_id ?? $donation->gateway_order_id }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Payment Status -->
                                    <td class="px-4 py-3.5">
                                        @if($status === 'paid')
                                            <span class="inline-block bg-emerald-100 text-emerald-800 border border-emerald-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">Paid</span>
                                        @elseif(in_array($status, ['pending', 'processing']))
                                            <span class="inline-block bg-amber-100 text-amber-800 border border-amber-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">Pending</span>
                                        @else
                                            <span class="inline-block bg-red-100 text-red-800 border border-red-200 text-[9px] font-black px-2 py-0.5 rounded uppercase">{{ $status }}</span>
                                        @endif
                                    </td>

                                    <!-- Seva Purpose / Campaign -->
                                    <td class="px-4 py-3.5 font-bold text-gray-600 text-xs">
                                        @if($donation->campaign)
                                            <span class="text-brandOrange uppercase text-[11px] block">{{ $donation->campaign->title }}</span>
                                        @endif
                                        <span class="text-gray-500 font-normal text-[10px] line-clamp-1">{{ $donation->about ?? 'General Contribution Fund' }}</span>
                                    </td>

                                    <!-- Amount -->
                                    <td class="px-5 py-3.5 text-right font-mono text-emerald-600 font-black text-sm">
                                        ₹{{ number_format((float)$donation->amount, 2) }}
                                    </td>

                                    <!-- Date -->
                                    <td class="px-4 py-3.5 text-center font-mono text-[10px] text-gray-500 whitespace-nowrap">
                                        {{ $donation->paid_at ? \Carbon\Carbon::parse($donation->paid_at)->timezone('Asia/Kolkata')->format('d-M-Y H:i') : \Carbon\Carbon::parse($donation->created_at)->timezone('Asia/Kolkata')->format('d-M-Y H:i') }}
                                    </td>

                                    <!-- Receipt Action -->
                                    <td class="px-4 py-3.5 text-center">
                                        <a href="{{ route('admin.donations.receipt', $donation->id) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[9px] px-2.5 py-1.5 rounded-lg shadow-sm uppercase transition inline-block">
                                            Receipt
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center font-bold text-gray-400 uppercase tracking-wider">
                                        No active donation records found inside the ledger.
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
